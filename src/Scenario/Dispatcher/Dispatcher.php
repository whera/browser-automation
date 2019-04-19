<?php

declare(strict_types=1);

namespace WSW\BrowserAutomation\Scenario\Dispatcher;

use Facebook\WebDriver\WebDriver;
use WSW\BrowserAutomation\Scenario\Scenario;

/**
 * Class Dispatcher
 *
 * @package WSW\BrowserAutomation\Scenario\Dispatcher
 */
class Dispatcher implements DispatcherInterface
{

    /**
     * {@inheritdoc}
     */
    public function dispatch(Scenario $scenario, WebDriver $driver): array
    {
        $start  = microtime(true);

        call_user_func($scenario->getCallback(), $scenario->pipeline());
        $tasks = $scenario->pipeline()->process($driver);

        return [
            'name'  => $scenario->getName(),
            'tasks' => $tasks,
            'duration' => round(microtime(true) - $start, 4)
        ];
    }
}
