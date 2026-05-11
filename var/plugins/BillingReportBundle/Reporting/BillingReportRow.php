<?php

/*
 * This file is part of the Kimai plugin "Billing report".
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\BillingReportBundle\Reporting;

use App\Entity\User;

final class BillingReportRow
{
    private int $flatDuration;
    private int $atCostDuration;
    private int $unknownDuration;

    public function __construct(private ?User $user, int $flatDuration, int $atCostDuration, int $unknownDuration)
    {
        $this->flatDuration = max(0, $flatDuration);
        $this->atCostDuration = max(0, $atCostDuration);
        $this->unknownDuration = max(0, $unknownDuration);
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function getUserDisplayName(): string
    {
        if ($this->user === null) {
            return 'Unknown user';
        }

        return $this->user->getDisplayName();
    }

    public function getFlatDuration(): int
    {
        return $this->flatDuration;
    }

    public function getFlatHours(): float
    {
        return $this->flatDuration / 3600;
    }

    public function getAtCostDuration(): int
    {
        return $this->atCostDuration;
    }

    public function getAtCostHours(): float
    {
        return $this->atCostDuration / 3600;
    }

    public function getUnknownDuration(): int
    {
        return $this->unknownDuration;
    }

    public function getUnknownHours(): float
    {
        return $this->unknownDuration / 3600;
    }

    public function getTotalDuration(): int
    {
        return $this->flatDuration + $this->atCostDuration + $this->unknownDuration;
    }

    public function getTotalHours(): float
    {
        return $this->getTotalDuration() / 3600;
    }
}
