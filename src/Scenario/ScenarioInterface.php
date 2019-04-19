<?php

declare(strict_types=1);

namespace WSW\BrowserAutomation\Scenario;

use WSW\BrowserAutomation\Pipeline\PipelineInterface;

/**
 * Interface ScenarioInterface
 *
 * @package WSW\BrowserAutomation\Scenario
 */
interface ScenarioInterface
{
    /**
     * Scenario Name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Callable in scenario.
     *
     * @return callable
     */
    public function getCallback(): callable;

    /**
     * Pipeline pattern
     *
     * @return PipelineInterface
     */
    public function pipeline(): PipelineInterface;
}
