<?php

declare(strict_types=1);

namespace WSW\BrowserAutomation\Scenario;

use Facebook\WebDriver\WebDriver;
use InvalidArgumentException;
use RuntimeException;
use SplObjectStorage;
use WSW\BrowserAutomation\Scenario\Dispatcher\Dispatcher;
use WSW\BrowserAutomation\Scenario\Dispatcher\DispatcherInterface;

/**
 * Class ScenarioRepository
 *
 * @package WSW\BrowserAutomation\Scenario
 */
class ScenarioRepository implements ScenarioRepositoryInterface
{
    /**
     * @var string control characters for keys.
     */
    const KEY_REGEX = '/[^a-z_\-0-9.]/i';

    /**
     * @var SplObjectStorage
     */
    private $storage;

    /**
     * @var DispatcherInterface
     */
    private $dispatcher;

    /**
     * Scenario constructor.
     *
     * @param DispatcherInterface $dispatcher
     */
    public function __construct(DispatcherInterface $dispatcher = null)
    {
        $this->storage = new SplObjectStorage;
        $this->dispatcher = $dispatcher ?? new Dispatcher();
    }

    /**
     * {@inheritdoc}
     */
    public function add(string $name, callable $callback): ScenarioRepositoryInterface
    {
        $this->validateKey($name);
        $this->storage->attach(new Scenario($name, $callback));

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function has(string $name): bool
    {
        $this->validateKey($name);

        return !is_null($this->search($name));
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $name): Scenario
    {
        if (!$this->has($name)) {
            throw new RuntimeException('The scenario "' . $name . '" does not exists.', 404);
        }

        return $this->search($name);
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(array $scenarios, WebDriver $driver): array
    {
        $result = ['scenarios' => []];

        foreach ($scenarios as $item) {
            $scenario = $this->get($item);
            $result['scenarios'][] = $this->dispatcher->dispatch($scenario, $driver);
        }

        return $result;
    }

    /**
     * Check if scenario name is valid.
     *
     * @param string $key
     * @throws InvalidArgumentException
     *
     * @return void
     */
    private function validateKey(string $key): void
    {
        if (preg_match(static::KEY_REGEX, $key)) {
            throw new InvalidArgumentException('Invalid character in scenario name: "'.$key.'"', 400);
        }
    }

    /**
     * Search object in our storage.
     *
     * @param string $name
     *
     * @return Scenario|null
     */
    private function search(string $name): ?Scenario
    {
        foreach ($this->storage as $scenario) {
            if ($scenario->getName() === $name) {
                return $scenario;
            }
        }

        return null;
    }
}
