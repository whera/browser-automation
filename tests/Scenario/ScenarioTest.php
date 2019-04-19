<?php

declare(strict_types=1);

namespace WSW\BrowserAutomationTest\Scenario;

use Facebook\WebDriver\WebDriver;
use PHPUnit\Framework\TestCase;
use WSW\BrowserAutomation\Pipeline\Pipeline;
use WSW\BrowserAutomation\Pipeline\PipelineInterface;
use WSW\BrowserAutomation\Scenario\Scenario;
use WSW\BrowserAutomation\Task\TaskInterface;

/**
 * Class ScenarioTest
 *
 * @package WSW\BrowserAutomationTest\Scenario
 */
class ScenarioTest extends TestCase
{
    /**
     * Test name Scenario.
     *
     * @return void
     */
    public function testScenarioName(): void
    {
        $scenario = new Scenario('test.scenario', function () {
        });
        $this->assertEquals('test.scenario', $scenario->getName());
    }

    /**
     * Test callable scenario.
     *
     * @return void
     */
    public function testScenarioCallable(): void
    {
        $scenario = new Scenario('test.scenario', function (): string {
            return 'callable ok';
        });
        $result = call_user_func($scenario->getCallback());

        $this->assertTrue(is_callable($scenario->getCallback()));
        $this->assertEquals('callable ok', $result);
    }

    /**
     * Test instance pipeline.
     *
     * @return void
     */
    public function testReturnPipelineDefaultScenario(): void
    {
        $scenario = new Scenario('test.scenario', function () {
        });
        $this->assertInstanceOf(Pipeline::class, $scenario->pipeline());
    }

    /**
     * Test instance custom pipeline.
     *
     * @return void
     */
    public function testReturnPipelineCustomScenario(): void
    {
        $pipeline = new class implements PipelineInterface
        {
            /**
             * {@inheritdoc}
             */
            public function pipe(TaskInterface $task): PipelineInterface
            {
                return $this;
            }

            /**
             * {@inheritdoc}
             */
            public function process(WebDriver $driver): array
            {
                return [];
            }
        };

        $scenario = new Scenario('test.scenario', function () {
        }, $pipeline);

        $this->assertInstanceOf(PipelineInterface::class, $scenario->pipeline());
        $this->assertFalse($pipeline instanceof Pipeline);
    }
}
