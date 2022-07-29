<?php

declare(strict_types=1);

namespace App\Tests;

use Codeception\Event\FailEvent;
use Codeception\Event\PrintResultEvent;
use Codeception\Event\TestEvent;
use Codeception\Events;
use Codeception\Extension;
use Codeception\Test\Descriptor;

class JSONReporter extends Extension
{
    protected array $globalConfig = [];
    private array $data = [];

    public function _initialize(): void
    {
        $this->_reconfigure(['settings' => ['silent' => true]]); // turn off printing for everything else
    }

    /**
     * We are listening for events
     *
     * @var array<string, string>
     */
    public static array $events = [
        Events::TEST_SUCCESS => 'success',
        Events::TEST_FAIL => 'fail',
        Events::TEST_ERROR => 'error',
        Events::RESULT_PRINT_AFTER => 'all',
    ];

    public function success(TestEvent $event): void
    {
        $this->data[] = [
            'file' => $this->getTestFilename($event),
            'test' => $this->getTestName($event),
            'status' => 'ok',
            'stacktrace' => [],
        ];
    }

    public function fail(FailEvent $event): void
    {
        $this->data[] = [
            'file' => $this->getTestFilename($event),
            'test' => $this->getTestName($event),
            'status' => 'fail',
            'stacktrace' => $event->getFail()->getTrace(),
        ];
    }

    public function error(FailEvent $event): void
    {
        $this->data[] = [
            'file' => $this->getTestFilename($event),
            'test' => $this->getTestName($event),
            'status' => 'error',
            'stacktrace' => $event->getFail()->getTrace(),
        ];
    }

    // we are printing test status and time taken
    public function all(PrintResultEvent $event): void
    {
        file_put_contents(__DIR__ . '/output.json', \Safe\json_encode($this->data));
    }

    private function getTestName(TestEvent $event): string
    {
        return Descriptor::getTestFullName($event->getTest());
    }

    private function getTestFilename(TestEvent $event): string
    {
        return Descriptor::getTestFileName($event->getTest());
    }
}
