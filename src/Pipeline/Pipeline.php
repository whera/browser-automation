<?php

declare(strict_types=1);

namespace WSW\BrowserAutomation\Pipeline;

use Facebook\WebDriver\WebDriver;
use SplObjectStorage;
use WSW\BrowserAutomation\Task\TaskInterface;

/**
 * Class Pipeline
 *
 * @package WSW\BrowserAutomation\Pipeline
 */
class Pipeline implements PipelineInterface
{
    /**
     * @var SplObjectStorage
     */
    private $storage;

    /**
     * @var ProcessorInterface
     */
    private $processor;

    /**
     * Pipeline constructor.
     *
     * @param ProcessorInterface $processor
     */
    public function __construct(ProcessorInterface $processor = null)
    {
        $this->storage = new SplObjectStorage();
        $this->processor = $processor ?? new Processor();
    }

    /**
     * {@inheritdoc}
     */
    public function pipe(TaskInterface $task): PipelineInterface
    {
        $this->storage->attach($task);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function process(WebDriver $driver): array
    {
        $result = [];

        foreach ($this->storage as $task) {
            $result[] = $this->processor->process($task, $driver);
        }

        return $result;
    }
}
