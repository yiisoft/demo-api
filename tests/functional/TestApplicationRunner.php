<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use ErrorException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use Yiisoft\Config\ConfigInterface;
use Yiisoft\Definitions\Exception\CircularReferenceException;
use Yiisoft\Definitions\Exception\InvalidConfigException;
use Yiisoft\Definitions\Exception\NotInstantiableException;
use Yiisoft\Di\Container;
use Yiisoft\Di\ContainerConfig;
use Yiisoft\Di\NotFoundException;
use Yiisoft\ErrorHandler\Middleware\ErrorCatcher;
use Yiisoft\Yii\Http\Application;
use Yiisoft\Yii\Http\Handler\ThrowableHandler;
use Yiisoft\Yii\Runner\ApplicationRunner;
use Yiisoft\Yii\Runner\Http\Exception\HeadersHaveBeenSentException;
use Yiisoft\Yii\Runner\Http\ServerRequestFactory;

final class TestApplicationRunner extends ApplicationRunner
{
    private array $requestParameters;
    public ?ContainerInterface $container = null;
    private array $providers = [];

    /**
     * @param string $rootPath The absolute path to the project root.
     * @param bool $debug Whether the debug mode is enabled.
     * @param string|null $environment The environment name.
     */
    public function __construct(
        public ResponseGrabber $responseGrabber,
        string $rootPath,
        bool $debug,
        ?string $environment,
        protected ?string $applicationEnvironment,
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
        $this->preloadContainer();

        /** @var Application $application */
        $application = $this->container->get(Application::class);

        /**
         * @var ServerRequestInterface
         * @psalm-suppress MixedMethodCall
         */
        $serverRequest = $this->container
            ->get(ServerRequestFactory::class)
            ->createFromParameters(
                ...$this->requestParameters,
            );

        try {
            $application->start();
            $response = $application->handle($serverRequest);
        } catch (Throwable $throwable) {
            $handler = new ThrowableHandler($throwable);
            /**
             * @var ResponseInterface
             * @psalm-suppress MixedMethodCall
             */
            $response = $this->container
                ->get(ErrorCatcher::class)
                ->process($serverRequest, $handler);
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

    public function preloadContainer()
    {
        require_once $this->rootPath . '/autoload.php';

        $config = $this->getConfig();
        $this->container = $this->getContainer($config, $this->applicationEnvironment);

        $this->runBootstrap($config, $this->container);
        $this->checkEvents($config, $this->container);
    }

    protected function createDefaultContainer(ConfigInterface $config, string $definitionEnvironment): Container
    {
        $containerConfig = ContainerConfig::create()->withValidate($this->debug);

        if ($config->has($definitionEnvironment)) {
            $containerConfig = $containerConfig->withDefinitions($config->get($definitionEnvironment));
        }

        $providers = [];

        if ($config->has("providers-$definitionEnvironment")) {
            $providers = $config->get("providers-$definitionEnvironment");
        }

        if ($this->providers !== []) {
            $providers = array_merge($providers, $this->providers);
        }

        if ($providers !== []) {
            $containerConfig = $containerConfig->withProviders($providers);
        }

        if ($config->has("delegates-$definitionEnvironment")) {
            $containerConfig = $containerConfig->withDelegates($config->get("delegates-$definitionEnvironment"));
        }

        if ($config->has("tags-$definitionEnvironment")) {
            $containerConfig = $containerConfig->withTags($config->get("tags-$definitionEnvironment"));
        }

        $containerConfig = $containerConfig->withDefinitions(
            array_merge($containerConfig->getDefinitions(), [ConfigInterface::class => $config])
        );

        return new Container($containerConfig);
    }

    public function addProviders(array $providers)
    {
        $this->providers = array_merge($this->providers, $providers);
    }
}
