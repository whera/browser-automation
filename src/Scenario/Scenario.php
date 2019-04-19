<?php

declare(strict_types=1);

namespace WSW\BrowserAutomation\Scenario;

use WSW\BrowserAutomation\Pipeline\Pipeline;
use WSW\BrowserAutomation\Pipeline\PipelineInterface;

/**
 * Class Scenario
 *
 * @package WSW\BrowserAutomation\Scenario
 */
class Scenario implements ScenarioInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var callable
     */
    private $callback;

    /**
     * @var PipelineInterface
     */
    private $pipeline;

    /**
     * Scenario constructor.
     *
     * @param string $name
     * @param callable $callback
     * @param PipelineInterface $pipeline
     */
    public function __construct(string $name, callable $callback, PipelineInterface $pipeline = null)
    {
        $this->name = $name;
        $this->callback = $callback;
        $this->pipeline = $pipeline ?? new Pipeline();
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getCallback(): callable
    {
        return $this->callback;
    }

    /**
     * {@inheritdoc}
     */
    public function pipeline(): PipelineInterface
    {
        return $this->pipeline;
    }
}
