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

    /** @var int[] */
    private array $flatProjectIds;

    /** @var int[] */
    private array $atCostProjectIds;

    /** @var int[] */
    private array $unknownProjectIds;

    /**
     * @param int[] $flatProjectIds
     * @param int[] $atCostProjectIds
     * @param int[] $unknownProjectIds
     */
    public function __construct(
        private ?User $user,
        int $flatDuration,
        int $atCostDuration,
        int $unknownDuration,
        array $flatProjectIds = [],
        array $atCostProjectIds = [],
        array $unknownProjectIds = []
    )
    {
        $this->flatDuration = max(0, $flatDuration);
        $this->atCostDuration = max(0, $atCostDuration);
        $this->unknownDuration = max(0, $unknownDuration);
        $this->flatProjectIds = array_values(array_unique(array_map('intval', $flatProjectIds)));
        $this->atCostProjectIds = array_values(array_unique(array_map('intval', $atCostProjectIds)));
        $this->unknownProjectIds = array_values(array_unique(array_map('intval', $unknownProjectIds)));
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

    /**
     * @return int[]
     */
    public function getFlatProjectIds(): array
    {
        return $this->flatProjectIds;
    }

    /**
     * @return int[]
     */
    public function getAtCostProjectIds(): array
    {
        return $this->atCostProjectIds;
    }

    /**
     * @return int[]
     */
    public function getUnknownProjectIds(): array
    {
        return $this->unknownProjectIds;
    }

    /**
     * @return int[]
     */
    public function getProjectIdsForClassification(string $classification): array
    {
        return match ($classification) {
            'flat' => $this->flatProjectIds,
            'atcost' => $this->atCostProjectIds,
            'unknown' => $this->unknownProjectIds,
            default => [],
        };
    }
}
