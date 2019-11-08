<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Export\Timesheet;

use App\Export\Base\CsvRenderer as BaseCsvRenderer;
use App\Export\TimesheetExportInterface;
use App\Repository\Query\TimesheetQuery;

final class CsvRenderer extends BaseCsvRenderer implements TimesheetExportInterface
{
    protected function isRenderRate(TimesheetQuery $query): bool
    {
        if (null !== $query->getUser()) {
            return $this->voter->isGranted('view_rate_own_timesheet');
        }

        return true;
    }
}
