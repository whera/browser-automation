<?php

declare(strict_types=1);

namespace WSW\BrowserAutomation\Scenario\Dispatcher;

use Facebook\WebDriver\WebDriver;
use WSW\BrowserAutomation\Scenario\Scenario;

/**
 * Interface DispatcherInterface
 *
 * @package WSW\BrowserAutomation\Scenario\Dispatcher
 */
interface DispatcherInterface
{
    /**
     * Scenario dispatch.
     *
     * @param Scenario $scenario
     * @param WebDriver $driver
     *
     * @return array
     */
    public function dispatch(Scenario $scenario, WebDriver $driver): array;
}
