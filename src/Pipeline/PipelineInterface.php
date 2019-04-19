<?php

declare(strict_types=1);

namespace WSW\BrowserAutomation\Pipeline;

use Facebook\WebDriver\WebDriver;
use WSW\BrowserAutomation\Task\TaskInterface;

/**
 * Interface PipelineInterface
 *
 * @package WSW\BrowserAutomation\Pipeline
 */
interface PipelineInterface
{
    /**
     * Create a new pipeline with an appended stage.
     *
     * @param TaskInterface $task
     *
     * @return self
     */
    public function pipe(TaskInterface $task): self;

    /**
     * Process pipes.
     *
     * @param WebDriver $driver
     *
     * @return array
     */
    public function process(WebDriver $driver): array;
}
