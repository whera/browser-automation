<?php

declare(strict_types=1);

namespace WSW\BrowserAutomationTest\Scenario;

use Facebook\WebDriver\WebDriver;
use PHPUnit\Framework\TestCase;
use WSW\BrowserAutomation\Pipeline\PipelineInterface;
use WSW\BrowserAutomation\Scenario\Scenario;
use WSW\BrowserAutomation\Scenario\ScenarioRepository;
use WSW\BrowserAutomation\Scenario\ScenarioRepositoryInterface;

/**
 * Class ScenarioRepositoryTest
 *
 * @package WSW\BrowserAutomationTest\Scenario
 */
class ScenarioRepositoryTest extends TestCase
{
    /**
     * @var \Facebook\WebDriver\WebDriver
     */
    protected $driver;

    /**
     * SetUp.
     *
     * @throws \ReflectionException
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->driver = $this->createMock(WebDriver::class);
    }

    /**
     * Test new Scenario.
     *
     * @return void
     */
    public function testAddNewScenario(): void
    {
        $scenarioRepo = new ScenarioRepository();
        $resultInstance = $scenarioRepo->add('scenario.1', function (PipelineInterface $pipeline) {
        });
        $this->assertInstanceOf(ScenarioRepositoryInterface::class, $resultInstance);
    }

    /**
     * Test fail scenario name.
     *
     * @throws \InvalidArgumentException
     *
     * @return void
     */
    public function testFailScenarioName(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Invalid character in scenario name: "scenario 1"');

        $scenarioRepo = new ScenarioRepository();
        $scenarioRepo->add('scenario 1', function (PipelineInterface $pipeline) {
        });
    }

    /**
     * Test scenario exist or not exist in repository.
     *
     * @return void
     */
    public function testHasScenario(): void
    {
        $scenarioRepo = new ScenarioRepository();
        $scenarioRepo->add('scenario.1', function (PipelineInterface $pipeline) {
        });

        $this->assertTrue($scenarioRepo->has('scenario.1'));
        $this->assertFalse($scenarioRepo->has('scenario.2'));
    }

    /**
     * Test exception scenario method has.
     *
     * @return void
     */
    public function testHasScenarioException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Invalid character in scenario name: "scenario 1"');

        $scenarioRepo = new ScenarioRepository();
        $scenarioRepo->add('scenario.1', function (PipelineInterface $pipeline) {
        });

        $scenarioRepo->has('scenario 1');
    }

    /**
     * Test get scenario in repository.
     *
     * @return void
     */
    public function testGetScenarioInRepository(): void
    {
        $scenarioRepo = new ScenarioRepository();
        $scenarioRepo->add('scenario.1', function (PipelineInterface $pipeline) {
        });
        $result = $scenarioRepo->get('scenario.1');

        $this->assertInstanceOf(Scenario::class, $result);
        $this->assertEquals('scenario.1', $result->getName());
    }

    /**
     * Test scenario not found.
     *
     * @throws \RuntimeException
     *
     * @return void
     */
    public function testScenarioNotFount(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionCode(404);
        $this->expectExceptionMessage('The scenario "scenario.2" does not exists.');

        $scenarioRepo = new ScenarioRepository();
        $scenarioRepo->add('scenario.1', function (PipelineInterface $pipeline) {
        });
        $scenarioRepo->get('scenario.2');
    }

    /**
     * Test get scenario invalid key.
     *
     * @throws \InvalidArgumentException
     *
     * @return void
     */
    public function testGetScenarioInvalidKey(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Invalid character in scenario name: "scenario 2"');

        $scenarioRepo = new ScenarioRepository();
        $scenarioRepo->add('scenario.1', function (PipelineInterface $pipeline) {
        });

        $scenarioRepo->get('scenario 2');
    }

    /**
     * Test dispatch scenario.
     *
     * @return void
     */
    public function testDispatchScenario(): void
    {
        $scenarioRepo = new ScenarioRepository();
        $scenarioRepo->add('scenario.1', function (PipelineInterface $pipeline) {
        });
        $result = $scenarioRepo->dispatch(['scenario.1'], $this->driver);

        $this->assertIsArray($result);
        $this->assertEquals('scenario.1', $result['scenarios'][0]['name']);
        $this->assertEmpty($result['scenarios'][0]['tasks']);
    }
}
