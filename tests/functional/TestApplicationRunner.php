<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use ErrorException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Di\NotFoundException;
use Yiisoft\ErrorHandler\Middleware\ErrorCatcher;
use Yiisoft\Log\Target\File\FileTarget;
use Yiisoft\Yii\Http\Application;
use Yiisoft\Yii\Http\Handler\ThrowableHandler;
use Yiisoft\Yii\Runner\ApplicationRunner;
use Yiisoft\Yii\Runner\Http\Exception\HeadersHaveBeenSentException;
use Yiisoft\Yii\Runner\Http\ServerRequestFactory;

use function microtime;

final class TestApplicationRunner extends ApplicationRunner
{
    private array $requestParameters;

    /**
     * @param string $rootPath The absolute path to the project root.
     * @param bool $debug Whether the debug mode is enabled.
     * @param string|null $environment The environment name.
     */
    public function __construct(
        private ResponseGrabber $responseGrabber,
        string $rootPath,
        bool $debug,
        ?string $environment
    ) {
        parent::__construct($rootPath, $debug, $environment);
        $this->bootstrapGroup = 'bootstrap-web';
        $this->eventsGroup = 'events-web';
    }

    /**
     * {@inheritDoc}
     *
     * @throws CircularReferenceException|ErrorException|HeadersHaveBeenSentException|InvalidConfigException
     * @throws ContainerExceptionInterface|NotFoundException|NotFoundExceptionInterface|NotInstantiableException
     */
    public function run(): void
    {
        require_once $this->rootPath . '/autoload.php';

        $startTime = microtime(true);

        $config = $this->getConfig();
        $container = $this->getContainer($config, 'web');

        $this->runBootstrap($config, $container);
        $this->checkEvents($config, $container);

        /** @var Application $application */
        $application = $container->get(Application::class);

        /**
         * @var ServerRequestInterface
         * @psalm-suppress MixedMethodCall
         */
        $serverRequest = $container
            ->get(ServerRequestFactory::class)
            ->createFromParameters(
                ...$this->requestParameters,
            );
        $request = $serverRequest->withAttribute('applicationStartTime', $startTime);

        try {
            $application->start();
            $response = $application->handle($request);
        } catch (Throwable $throwable) {
            $handler = new ThrowableHandler($throwable);
            /**
             * @var ResponseInterface
             * @psalm-suppress MixedMethodCall
             */
            $response = $container
                ->get(ErrorCatcher::class)
                ->process($request, $handler);
        } finally {
            $application->afterEmit($response ?? null);
            $application->shutdown();
            $this->responseGrabber->setResponse($response ?? null);
        }
    }

    public function withRequest(
        string $method,
        string $url,
        array $queryParams = [],
        array $postParams = [],
        mixed $body = null,
        array $files = [],
    ) {
        $this->requestParameters = [
            'server' => [
                'SCRIPT_NAME' => '/index.php',
                'REQUEST_METHOD' => $method,
                'SERVER_PROTOCOL' => '1.1',
                'REQUEST_URI' => $url,
            ],
            'headers' => [],
            'cookies' => [],
            'get' => $queryParams,
            'post' => $postParams,
            'files' => $files,
            'body' => $body,
        ];
    }
}
