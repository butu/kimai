<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Timesheet;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserDateTimeFactory
{
    /**
     * @var \DateTimeZone
     */
    protected $timezone;

    /**
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        if (null === $tokenStorage->getToken()) {
            return;
        }

        /* @var $user User */
        $user = $tokenStorage->getToken()->getUser();
        $timezone = date_default_timezone_get();

        if ($user instanceof User && null !== $user->getPreferenceValue('timezone')) {
            $timezone = $user->getPreferenceValue('timezone');
        }

        $this->timezone = new \DateTimeZone($timezone);
    }

    /**
     * @return \DateTimeZone
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * @return \DateTime
     */
    public function getStartOfMonth()
    {
        $date = $this->createDateTime('first day of this month');
        $date->setTime(0, 0, 0);

        return $date;
    }

    /**
     * @return \DateTime
     */
    public function getEndOfMonth()
    {
        $date = $this->createDateTime('last day of this month');
        $date->setTime(23, 59, 59);

        return $date;
    }

    /**
     * @param string $datetime
     * @return \DateTime
     */
    public function createDateTime(string $datetime = 'now')
    {
        $date = new \DateTime($datetime, $this->timezone);

        return $date;
    }
}
