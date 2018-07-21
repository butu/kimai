<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use Symfony\Component\Security\Core\Exception\LockedException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Advanced checks during authentication to make sure the user is allowed to use Kimai.
 */
class UserChecker implements UserCheckerInterface
{
    /**
     * @param UserInterface $user
     * @throws AccountStatusException
     */
    public function checkPreAuth(UserInterface $user)
    {
    }

    /**
     * @param UserInterface $user
     * @throws AccountStatusException
     */
    public function checkPostAuth(UserInterface $user)
    {
        if (!$user instanceof User) {
            return;
        }

        // user account is not enabled, the user may be notified
        if (!$user->isEnabled()) {
            throw new LockedException();
        }
    }
}
