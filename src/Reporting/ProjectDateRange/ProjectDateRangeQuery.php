<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Reporting\ProjectDateRange;

use App\Entity\Customer;
use App\Entity\User;

final class ProjectDateRangeQuery
{
    /**
     * @var \DateTime
     */
    private $month;
    /**
     * @var User|null
     */
    private $user;
    /**
     * @var Customer|null
     */
    private $customer;

    private $includeNoBudget = false;
    private $onlyWithRecords = false;

    public function __construct(\DateTime $month, User $user)
    {
        $this->month = clone $month;
        $this->user = $user;
    }

    public function isIncludeNoBudget(): bool
    {
        return $this->includeNoBudget;
    }

    public function setIncludeNoBudget(bool $includeNoBudget): void
    {
        $this->includeNoBudget = $includeNoBudget;
    }

    public function isOnlyWithRecords(): bool
    {
        return $this->onlyWithRecords;
    }

    public function setOnlyWithRecords(bool $onlyWithRecords): void
    {
        $this->onlyWithRecords = $onlyWithRecords;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function getMonth(): \DateTime
    {
        return $this->month;
    }

    public function setMonth(\DateTime $month): void
    {
        $this->month = $month;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): void
    {
        $this->customer = $customer;
    }
}
