<?php

declare(strict_types=1);

namespace WSW\BrowserAutomationTest;

use Facebook\WebDriver\WebDriver;
use PHPUnit\Framework\TestCase;
use WSW\BrowserAutomation\Application;
use WSW\BrowserAutomation\Driver\Chrome;
use WSW\BrowserAutomation\Driver\DriverInterface;
use WSW\BrowserAutomation\Pipeline\PipelineInterface;
use WSW\BrowserAutomation\Report\CliReport;
use WSW\BrowserAutomation\Report\ReportInterface;
use WSW\BrowserAutomation\Task\TaskInterface;

/**
 * Class ApplicationTest
 *
 * @package WSW\BrowserAutomationTest
 */
class ApplicationTest extends TestCase
{
    /**
     * @var DriverInterface
     */
    private $driver;

    /**
     * @var TaskInterface
     */
    private $task;

    /**
     * @var ReportInterface
     */
    private $report;

    /**
     * SetUp.
     *
     * @throws \ReflectionException
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->driver = $this->createMock(Chrome::class);
        $this->report = $this->createMock(CliReport::class);

        $this->task = new class implements TaskInterface
        {
            /**
             * {@inheritdoc}
             */
            public function handle(WebDriver $driver): void
            {
                // TODO: Implement handle() method.
            }
        };
    }

    /**
     * Test add new scenarios in pipeline
     *
     * @return void
     */
    public function testAddNewScenario(): void
    {
        $app = new Application($this->driver, $this->report);
        $task = &$this->task;
        $app->scenario('scenario.test', function (PipelineInterface $pipeline) use ($task) {
            $pipeline->pipe($task);
        });

        $result = $app->run(['scenario.test']);

        $this->assertIsArray($result);
        $this->assertEquals(1, count($result['scenarios']));
        $this->assertEquals(1, count($result['scenarios'][0]['tasks']));
    }

    /**
     * Test scenario not found.
     *
     * @return void
     */
    public function testRunScenarioNotFound(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionCode(404);
        $this->expectExceptionMessage('The scenario "test.notfound" does not exists.');

        $app = new Application($this->driver, $this->report);
        $app->run(['test.notfound']);
    }

    /**
     * Test scenario name invalid.
     *
     * @return void
     */
    public function testScenarioInvalidName(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Invalid character in scenario name: "scenario test"');

        $app = new Application($this->driver, $this->report);
        $task = &$this->task;
        $app->scenario('scenario test', function (PipelineInterface $pipeline) use ($task) {
            $pipeline->pipe($task);
        });

        $app->run(['scenario test']);
    }
}
