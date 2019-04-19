<?php

declare(strict_types=1);

namespace WSW\BrowserAutomationTest\Pipeline;

use Facebook\WebDriver\WebDriver;
use PHPUnit\Framework\TestCase;
use WSW\BrowserAutomation\Pipeline\Pipeline;
use WSW\BrowserAutomation\Pipeline\PipelineInterface;
use WSW\BrowserAutomation\Pipeline\ProcessorInterface;
use WSW\BrowserAutomation\Task\TaskInterface;

/**
 * Class PipelineTest
 *
 * @package WSW\BrowserAutomationTest\Pipeline
 */
class PipelineTest extends TestCase
{
    /**
     * SetUp.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @return void
     */
    public function testInstanceDefaultProcessor(): void
    {
        $pipeline = new Pipeline();
        $this->assertInstanceOf(PipelineInterface::class, $pipeline);
    }

    /**
     * @return void
     */
    public function testInstanceCustomProcessor(): void
    {
        $custom = new class implements ProcessorInterface
        {
            /**
             * {@inheritdoc}
             */
            public function process(TaskInterface $task, WebDriver $driver): array
            {
                return [];
            }
        };

        $pipeline = new Pipeline($custom);
        $this->assertInstanceOf(PipelineInterface::class, $pipeline);
    }

    /**
     * @return void
     */
    public function testAddNewPipe(): void
    {
        $task = new class implements TaskInterface
        {
            /**
             * {@inheritdoc}
             */
            public function handle(WebDriver $driver): void
            {
                // Task
            }
        };

        $pipeline = new Pipeline();
        $result = $pipeline->pipe($task);
        $this->assertInstanceOf(PipelineInterface::class, $result);
    }

    /**
     * @throws \ReflectionException
     *
     * @return void
     */
    public function testRunProcessPipeline(): void
    {
        $drive = $this->createMock(WebDriver::class);

        $task = new class implements TaskInterface
        {
            /**
             * {@inheritdoc}
             */
            public function handle(WebDriver $driver): void
            {
                // Task
            }
        };

        $pipeline = new Pipeline();
        $pipeline->pipe($task);
        $result = $pipeline->process($drive);
        $this->assertEquals(1, count($result));
    }
}
