<?php

declare(strict_types=1);

namespace WSW\BrowserAutomation\Driver;

use Facebook\WebDriver\Remote\RemoteWebDriver;

/**
 * Interface DriverInterface
 *
 * @package WSW\BrowserAutomation\Driver
 */
interface DriverInterface
{
    /**
     * Get the web driver instance for this browser.
     *
     * @return RemoteWebDriver
     */
    public function getDriver(): RemoteWebDriver;
}
