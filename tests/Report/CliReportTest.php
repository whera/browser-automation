<?php
declare(strict_types=1);

namespace WSW\BrowserAutomationTest\Report;

use PHPUnit\Framework\TestCase;
use WSW\BrowserAutomation\Report\CliReport;
use WSW\BrowserAutomation\Report\ReportInterface;

/**
 * Class CliReportTest
 *
 * @package WSW\BrowserAutomationTest\Report
 */
class CliReportTest extends TestCase
{
    /**
     * Test instance.
     *
     * @return void
     */
    public function testInstance(): void
    {
        $report = new CliReport();
        $this->assertInstanceOf(ReportInterface::class, $report);
    }

    /**
     * Test output.
     *
     * @return void
     */
    public function testToReport(): void
    {
        $arr = [
            'test' => true
        ];
        $report = new CliReport();
        $report->toReport($arr);

        $this->expectOutputString(json_encode($arr));
    }
}
