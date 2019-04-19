<?php

declare(strict_types=1);

namespace WSW\BrowserAutomationTest\Driver;

use Facebook\WebDriver\Remote\RemoteWebDriver;
use PHPUnit\Framework\TestCase;
use WSW\BrowserAutomation\Driver\Chrome;

/**
 * Class ChromeTest
 *
 * @package WSW\BrowserAutomationTest\Driver
 */
class ChromeTest extends TestCase
{
    /**
     * @var RemoteWebDriver
     */
    private $driverMock;

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

        $this->driverMock = $this->createMock(RemoteWebDriver::class);
    }

    /**
     * Test instance.
     *
     * @return void
     */
    public function testGetInstance(): void
    {
        $driver = new Chrome('', [], $this->driverMock);

        $this->assertInstanceOf(RemoteWebDriver::class, $driver->getDriver());
    }
}
