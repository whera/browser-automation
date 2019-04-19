<?php

declare(strict_types=1);

namespace WSW\BrowserAutomation\Report;

/**
 * Interface ReportInterface
 *
 * @package WSW\BrowserAutomation\Report
 */
interface ReportInterface
{
    /**
     * Report Result.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function toReport(array $data);
}
