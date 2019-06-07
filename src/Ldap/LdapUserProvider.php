<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Ldap;

use App\Configuration\LdapConfiguration;
use App\Entity\User;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Overwritten to be able to deactivate LDAP via config switch.
 *
 * Inspired by https://github.com/Maks3w/FR3DLdapBundle @ MIT License
 */
class LdapUserProvider implements UserProviderInterface
{
    /**
     * @var bool
     */
    protected $activated = false;
    /**
     * @var LdapManager
     */
    protected $ldapManager;
    /**
     * @var LoggerInterface|null
     */
    protected $logger;

    public function __construct(LdapManager $ldapManager, LdapConfiguration $config, LoggerInterface $logger = null)
    {
        $this->ldapManager = $ldapManager;
        $this->logger = $logger;
        $this->activated = $config->isActivated();
    }

    public function loadUserByUsername($username)
    {
        // this method is called at least for unknown user, no matter what supportsClass() returns,
        // so we have to check if LDAP is activated here as well
        if (!$this->activated) {
            $ex = new UsernameNotFoundException(sprintf('LDAP is deactivated, user "%s" not searched', $username));
            $ex->setUsername($username);

            throw $ex;
        }

        $user = $this->ldapManager->findUserByUsername($username);

        if (empty($user)) {
            $this->logInfo('User {username} {result} on LDAP', [
                'action' => 'loadUserByUsername',
                'username' => $username,
                'result' => 'not found',
            ]);
            $ex = new UsernameNotFoundException(sprintf('User "%s" not found', $username));
            $ex->setUsername($username);

            throw $ex;
        }

        $this->logInfo('User {username} {result} on LDAP', [
            'action' => 'loadUserByUsername',
            'username' => $username,
            'result' => 'found',
        ]);

        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        if (!($user instanceof User) || !$this->supportsClass(get_class($user))) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        if (null === $user->getPreferenceValue('ldap.dn')) {
            throw new UnsupportedUserException(sprintf('Account "%s" is not a registered LDAP user.', $user->getUsername()));
        }

        try {
            $this->ldapManager->updateUser($user);
        } catch (LdapDriverException $ex) {
            throw new UnsupportedUserException(sprintf('Failed to refresh user "%s", probably DN is expired.', $user->getUsername()));
        }

        return $user;
    }

    public function supportsClass($class)
    {
        if (!$this->activated) {
            return false;
        }

        return $class === User::class || $class === 'App\Entity\User';
    }

    /**
     * Log a message into the logger if this exists.
     */
    private function logInfo(string $message, array $context = []): void
    {
        if (!$this->logger) {
            return;
        }

        $this->logger->info($message, $context);
    }
}
