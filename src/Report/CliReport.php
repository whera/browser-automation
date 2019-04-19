<?php

declare(strict_types=1);

namespace WSW\BrowserAutomation\Report;

/**
 * Class CliReport
 *
 * @package WSW\BrowserAutomation\Report
 */
class CliReport implements ReportInterface
{

    /**
     * {@inheritDoc}
     */
    public function toReport(array $data)
    {
        echo json_encode($data);
    }
}
