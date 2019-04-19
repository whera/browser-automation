<?php

declare(strict_types=1);

namespace WSW\BrowserAutomationTest\Pipeline;

use Facebook\WebDriver\WebDriver;
use PHPUnit\Framework\TestCase;
use WSW\BrowserAutomation\Pipeline\Processor;
use WSW\BrowserAutomation\Pipeline\ProcessorInterface;
use WSW\BrowserAutomation\Task\TaskInterface;

/**
 * Class ProcessorTest
 *
 * @package WSW\BrowserAutomationTest\Pipeline
 */
class ProcessorTest extends TestCase
{
    /**
     * @var TaskInterface
     */
    private $taskSuccess;

    /**
     * @var TaskInterface
     */
    private $taskError;

    /**
     * @var ProcessorInterface
     */
    private $processor;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->processor = new Processor();

        $this->taskSuccess = new class implements TaskInterface
        {
            /**
             * {@inheritdoc}
             */
            public function handle(WebDriver $driver): void
            {
                // Test
            }
        };

        $this->taskError = new class implements TaskInterface
        {
            /**
             * {@inheritdoc}
             */
            public function handle(WebDriver $driver): void
            {
                throw new \InvalidArgumentException('Error Test.', 400);
            }
        };
    }

    /**
     * @throws \ReflectionException
     */
    public function testProcessSuccess(): void
    {
        $driver = $this->createMock(WebDriver::class);
        $result = $this->processor->process($this->taskSuccess, $driver);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('task', $result);
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('error', $result);
        $this->assertArrayHasKey('duration', $result);

        $this->assertTrue($result['success']);

        $this->assertEmpty($result['error']);
    }

    /**
     * @throws \ReflectionException
     */
    public function testProcessError(): void
    {
        $driver = $this->createMock(WebDriver::class);
        $result = $this->processor->process($this->taskError, $driver);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('task', $result);
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('error', $result);
        $this->assertArrayHasKey('duration', $result);

        $this->assertFalse($result['success']);

        $this->assertEquals('Error Test.', $result['error']);
    }
}
