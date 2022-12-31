<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\UserPreference;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Defines the sample data to load in the database when running the unit and
 * functional tests or while development.
 *
 * Execute this command to load the data:
 * $ php bin/console doctrine:fixtures:load
 *
 * @codeCoverageIgnore
 */
final class UserFixtures extends Fixture implements FixtureGroupInterface
{
    public const DEFAULT_PASSWORD = 'kitten';
    public const DEFAULT_API_TOKEN = 'api_kitten';
    public const DEFAULT_AVATAR = 'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=retro&f=y';

    public const USERNAME_USER = 'john_user';
    public const USERNAME_TEAMLEAD = 'tony_teamlead';
    public const USERNAME_ADMIN = 'anna_admin';
    public const USERNAME_SUPER_ADMIN = 'susan_super';

    public const AMOUNT_EXTRA_USER = 25;

    public const MIN_RATE = 30;
    public const MAX_RATE = 120;

    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public static function getGroups(): array
    {
        return ['user'];
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadDefaultAccounts($manager);
        $this->loadTestUsers($manager);
    }

    /**
     * Default users for all test cases
     *
     * @param ObjectManager $manager
     */
    private function loadDefaultAccounts(ObjectManager $manager)
    {
        $allUsers = $this->getUserDefinition();
        foreach ($allUsers as $userData) {
            $user = new User();
            $user->setAlias($userData[0]);
            $user->setTitle($userData[1]);
            $user->setUserIdentifier($userData[2]);
            $user->setEmail($userData[3]);
            $user->setRoles([$userData[4]]);
            $user->setAvatar($userData[5]);
            $user->setEnabled($userData[6]);
            $user->setPassword($this->passwordHasher->hashPassword($user, self::DEFAULT_PASSWORD));
            $user->setApiToken($this->passwordHasher->hashPassword($user, self::DEFAULT_API_TOKEN));
            $manager->persist($user);

            $prefs = $this->getUserPreferences($user, $userData[7]);
            $user->setPreferences($prefs);
            foreach (User::WIZARDS as $wizard) {
                $user->setWizardAsSeen($wizard);
            }
            $manager->persist($prefs[0]);
            $manager->persist($prefs[1]);
        }

        $manager->flush();
        $manager->clear();
    }

    /**
     * @param User $user
     * @param string|null $timezone
     * @return array
     */
    private function getUserPreferences(User $user, string $timezone = null): array
    {
        $preferences = [];

        $prefHourlyRate = new UserPreference(UserPreference::HOURLY_RATE, rand(self::MIN_RATE, self::MAX_RATE));
        $user->addPreference($prefHourlyRate);
        $preferences[] = $prefHourlyRate;

        if (null !== $timezone) {
            $prefTimezone = new UserPreference(UserPreference::TIMEZONE, $timezone);
            $user->addPreference($prefTimezone);
            $preferences[] = $prefTimezone;
        }

        return $preferences;
    }

    /**
     * Generate randomized test users, which don't have API access.
     *
     * @param ObjectManager $manager
     */
    private function loadTestUsers(ObjectManager $manager)
    {
        $faker = Factory::create();
        $existingName = [];
        $existingEmail = [];

        for ($i = 1; $i <= self::AMOUNT_EXTRA_USER; $i++) {
            $username = $faker->userName();
            $email = $faker->email();

            if (\in_array($username, $existingName)) {
                continue;
            }

            if (\in_array($email, $existingEmail)) {
                continue;
            }

            $existingName[] = $username;
            $existingEmail[] = $email;

            $user = new User();
            $user->setAlias($faker->name());
            $user->setTitle(substr($faker->jobTitle(), 0, 49));
            $user->setUserIdentifier($username);
            $user->setEmail($email);
            $user->setRoles([User::ROLE_USER]);
            $user->setEnabled(true);
            $user->setPassword($this->passwordHasher->hashPassword($user, self::DEFAULT_PASSWORD));
            $manager->persist($user);

            $prefs = $this->getUserPreferences($user);
            $user->setPreferences($prefs);
            $manager->persist($prefs[0]);
        }

        $manager->flush();
        $manager->clear();
    }

    /**
     * @return array
     */
    protected function getUserDefinition(): array
    {
        // alias = $userData[0]
        // title = $userData[1]
        // username = $userData[2]
        // email = $userData[3]
        // roles = [$userData[4]]
        // avatar = $userData[5]
        // enabled = $userData[6]
        // timezone = $userData[7]

        return [
            [
                'John Doe',
                'Developer',
                self::USERNAME_USER,
                'john_user@example.com',
                User::ROLE_USER,
                self::DEFAULT_AVATAR,
                true,
                'America/Vancouver',
            ],
            // inactive user to test login
            [
                'Chris Deactive',
                'Developer (left company)',
                'chris_user',
                'chris_user@example.com',
                User::ROLE_USER,
                self::DEFAULT_AVATAR,
                false,
                'Australia/Sydney',
            ],
            [
                'Tony Maier',
                'Head of Sales',
                self::USERNAME_TEAMLEAD,
                'tony_teamlead@example.com',
                User::ROLE_TEAMLEAD,
                'https://en.gravatar.com/userimage/3533186/bf2163b1dd23f3107a028af0195624e9.jpeg',
                true,
                'Asia/Bangkok',
            ],
            // no avatar to test default image macro
            [
                'Anna Smith',
                'Administrator',
                self::USERNAME_ADMIN,
                'anna_admin@example.com',
                User::ROLE_ADMIN,
                null,
                true,
                'Europe/London',
            ],
            // no alias to test twig username macro
            [
                null,
                'Super Administrator',
                self::USERNAME_SUPER_ADMIN,
                'susan_super@example.com',
                User::ROLE_SUPER_ADMIN,
                '/touch-icon-192x192.png',
                true,
                'Europe/Berlin',
            ]
        ];
    }
}
