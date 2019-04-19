<?php

declare(strict_types=1);

namespace WSW\BrowserAutomation\Driver;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverCapabilities;

/**
 * Class Chrome
 *
 * @package WSW\BrowserAutomation\Driver
 */
class Chrome implements DriverInterface
{
    /**
     * @var WebDriverCapabilities
     */
    private $capabilities;

    /**
     * @var string
     */
    private $dsn;

    /**
     * @var RemoteWebDriver
     */
    private $driver;

    /**
     * Create a new instance and automatically start the driver.
     *
     * @param string $dsn
     * @param array $arguments
     * @param RemoteWebDriver $driver
     */
    public function __construct(
        string $dsn = 'http://localhost:4444/wd/hub',
        array $arguments = [],
        RemoteWebDriver $driver = null
    ) {

        $this->dsn = $dsn;
        $capabilities = DesiredCapabilities::chrome();
        $options = (new ChromeOptions())->addArguments($arguments);
        $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);
        $this->capabilities = $capabilities;
        $this->driver = $driver ?? RemoteWebDriver::create($this->dsn, $this->capabilities);
    }

    /**
     * {@inheritdoc}
     */
    public function getDriver(): RemoteWebDriver
    {
        return $this->driver;
    }
}
