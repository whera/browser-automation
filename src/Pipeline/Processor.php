<?php

declare(strict_types=1);

namespace WSW\BrowserAutomation\Pipeline;

use Facebook\WebDriver\WebDriver;
use WSW\BrowserAutomation\Task\TaskInterface;

/**
 * Class Processor
 *
 * @package WSW\BrowserAutomation\Pipeline
 */
class Processor implements ProcessorInterface
{

    /**
     * {@inheritdoc}
     */
    public function process(TaskInterface $task, WebDriver $driver): array
    {
        $name   = get_class($task);
        $start  = microtime(true);
        $succes = false;
        $error  = null;

        try {
            $task->handle($driver);
            $succes = true;
        } catch (\Throwable $e) {
            $error = $e->getMessage();
        }

        return [
            'task' => $name,
            'success' => $succes,
            'error' => $error,
            'duration' => round(microtime(true) - $start, 4)
        ];
    }
}
