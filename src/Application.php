<?php

declare(strict_types=1);

namespace WSW\BrowserAutomation;

use Facebook\WebDriver\WebDriver;
use WSW\BrowserAutomation\Driver\DriverInterface;
use WSW\BrowserAutomation\Report\CliReport;
use WSW\BrowserAutomation\Report\ReportInterface;
use WSW\BrowserAutomation\Scenario\ScenarioRepository;
use WSW\BrowserAutomation\Scenario\ScenarioRepositoryInterface;

/**
 * Class Application
 *
 * @package WSW\BrowserAutomation
 */
final class Application
{

    /**
     * @var WebDriver
     */
    private $driver;

    /**
     * @var ReportInterface
     */
    private $report;

    /**
     * @var ScenarioRepositoryInterface
     */
    private $scenario;

    /**
     * Application constructor.
     *
     * @param DriverInterface $webDriver
     * @param ReportInterface $report
     * @param ScenarioRepositoryInterface $scenario
     */
    public function __construct(
        DriverInterface $webDriver,
        ReportInterface $report = null,
        ScenarioRepositoryInterface $scenario = null
    ) {
        $this->driver = $webDriver->getDriver();
        $this->report    = $report ?? new CliReport;
        $this->scenario  = $scenario ?? new ScenarioRepository;
    }

    /**
     * Add new scenario in collection.
     *
     * @param string $name
     * @param callable $callback
     * @throws \InvalidArgumentException
     *
     * @return self
     */
    public function scenario(string $name, callable $callback): self
    {
        $this->scenario->add($name, $callback);

        return $this;
    }

    /**
     * @param array $scenarios
     *
     * @return array
     */
    public function run(array $scenarios = []): array
    {
        $scenarios = count($scenarios) ? $scenarios : ['default'];
        $result = $this->scenario->dispatch($scenarios, $this->driver);
        $this->driver->quit();
        $this->report->toReport($result);

        return $result;
    }
}
