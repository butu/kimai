<?php

/*
 * This file is part of the Kimai plugin "Billing report".
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\BillingReportBundle\Reporting;

use App\Entity\User;

final class BillingReportQuery
{
    private ?\DateTime $month = null;

    public function __construct(private User $user)
    {
        $now = new \DateTimeImmutable('now', new \DateTimeZone($user->getTimezone()));
        $this->month = new \DateTime($now->format('Y-m-01 00:00:00'), new \DateTimeZone($user->getTimezone()));
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getMonth(): ?\DateTime
    {
        return $this->month;
    }

    public function setMonth(?\DateTime $month): void
    {
        $this->month = $month;
    }
}
