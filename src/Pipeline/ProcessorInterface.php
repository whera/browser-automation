<?php

declare(strict_types=1);

namespace WSW\BrowserAutomation\Pipeline;

use Facebook\WebDriver\WebDriver;
use WSW\BrowserAutomation\Task\TaskInterface;

interface ProcessorInterface
{
    /**
     * Process task.
     *
     * @param TaskInterface $task
     * @param WebDriver $driver
     *
     * @return array
     */
    public function process(TaskInterface $task, WebDriver $driver): array;
}
