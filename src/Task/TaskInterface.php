<?php

declare(strict_types=1);

namespace WSW\BrowserAutomation\Task;

use Facebook\WebDriver\WebDriver;

/**
 * Interface TaskInterface
 *
 * @package WSW\BrowserAutomation\Task
 */
interface TaskInterface
{
    /**
     * @param WebDriver $driver
     *
     * @return void
     */
    public function handle(WebDriver $driver): void;
}
