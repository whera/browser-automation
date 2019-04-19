<?php

declare(strict_types=1);

namespace WSW\BrowserAutomationTest\Scenario\Dispatcher;

use Facebook\WebDriver\WebDriver;
use PHPUnit\Framework\TestCase;
use WSW\BrowserAutomation\Pipeline\PipelineInterface;
use WSW\BrowserAutomation\Scenario\Dispatcher\Dispatcher;
use WSW\BrowserAutomation\Scenario\Scenario;
use WSW\BrowserAutomation\Task\TaskInterface;

/**
 * Class DispatcherTest
 *
 * @package WSW\BrowserAutomationTest\Scenario\Dispatcher
 */
class DispatcherTest extends TestCase
{
    /**
     * Test dispatch scenario.
     *
     * @throws \ReflectionException
     *
     * @return void
     */
    public function testDispatch(): void
    {
        $driver = $this->createMock(WebDriver::class);

        $task = new class implements TaskInterface
        {
            /**
             * {@inheritdoc}
             */
            public function handle(WebDriver $driver): void
            {
                // task.
            }
        };

        $scenario = new Scenario('test.scenario', function (PipelineInterface $pipeline) use ($task): void {
            $pipeline->pipe($task);
        });

        $result = (new Dispatcher())->dispatch($scenario, $driver);

        $this->assertIsArray($result);
        $this->assertEquals('test.scenario', $result['name']);
        $this->assertEquals(1, count($result['tasks']));
    }
}
