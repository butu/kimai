<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Model\Statistic;

/**
 * Yearly statistics
 */
class Year
{
    /**
     * @var string
     */
    protected $year;
    /**
     * @var Month[]
     */
    protected $months = [];

    /**
     * Year constructor.
     * @param string $year
     */
    public function __construct($year)
    {
        $this->year = $year;
    }

    /**
     * @return string
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param Month $month
     * @return $this
     */
    public function setMonth(Month $month)
    {
        $this->months[(int) $month->getMonth()] = $month;

        return $this;
    }

    /**
     * @param int $month
     * @return null|Month
     */
    public function getMonth(int $month)
    {
        if (isset($this->months[$month])) {
            return $this->months[$month];
        }

        return null;
    }

    /**
     * @return Month[]
     */
    public function getMonths()
    {
        return array_values($this->months);
    }
}
