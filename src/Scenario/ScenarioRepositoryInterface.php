<?php

declare(strict_types=1);

namespace WSW\BrowserAutomation\Scenario;

use Facebook\WebDriver\WebDriver;

/**
 * Interface ScenarioRepositoryInterface
 *
 * @package WSW\BrowserAutomation\Scenario
 */
interface ScenarioRepositoryInterface
{

    /**
     * Add new scenario in collection.
     *
     * @param string $name
     * @param callable $callback
     * @throws \InvalidArgumentException
     *
     * @return self
     */
    public function add(string $name, callable $callback): self;

    /**
     * Check if the scenario exists in our collection.
     *
     * @param string $name Scenario name.
     * @throws \InvalidArgumentException
     *
     * @return bool
     */
    public function has(string $name): bool;

    /**
     * We took the scenery by its name.
     *
     * @param string $name Scenario name.
     * @throws \InvalidArgumentException
     *
     * @return Scenario
     */
    public function get(string $name): Scenario;

    /**
     *
     * @param array $scenarios
     * @param WebDriver $driver
     *
     * @return array
     */
    public function dispatch(array $scenarios, WebDriver $driver): array;
}
