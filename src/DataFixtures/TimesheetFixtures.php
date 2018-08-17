<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DataFixtures;

use App\Entity\Activity;
use App\Entity\Timesheet;
use App\Entity\User;
use App\Entity\UserPreference;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

/**
 * Defines the sample data to load in the database when running the unit and
 * functional tests or while development.
 *
 * Execute this command to load the data:
 * bin/console doctrine:fixtures:load
 */
class TimesheetFixtures extends Fixture implements DependentFixtureInterface
{
    public const MIN_TIMESHEETS_PER_USER = 50;
    public const MAX_TIMESHEETS_PER_USER = 500;
    public const MAX_TIMESHEETS_TOTAL = 5000;
    public const MIN_RUNNING_TIMESHEETS_PER_USER = 0;
    public const MAX_RUNNING_TIMESHEETS_PER_USER = 3;
    public const TIMERANGE_DAYS = 1095; // 3 years
    public const MIN_MINUTES_PER_ENTRY = 15;
    public const MAX_MINUTES_PER_ENTRY = 840; // 14h

    public const BATCH_SIZE = 100;

    /**
     * @return array
     */
    public function getDependencies()
    {
        return [
            UserFixtures::class,
            CustomerFixtures::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $allUser = $this->getAllUsers($manager);
        $activities = $this->getAllActivities($manager);

        $faker = Factory::create();

        // by using array_pop we make sure that at least one activity has NO entry!
        array_pop($activities);

        foreach ($allUser as $user) {
            // random amount of timesheet entries for every user
            $timesheetForUser = rand(self::MIN_TIMESHEETS_PER_USER, self::MAX_TIMESHEETS_PER_USER);
            for ($i = 1; $i <= $timesheetForUser; $i++) {
                if ($i > self::MAX_TIMESHEETS_TOTAL) {
                    break;
                }

                $description = null;
                if ($i % 3 == 0) {
                    $description = $faker->text;
                } elseif ($i % 7 == 0) {
                    $description = '';
                }

                $entry = $this->createTimesheetEntry(
                    $user,
                    $activities[array_rand($activities)],
                    $description
                );

                $manager->persist($entry);

                if ($i % self::BATCH_SIZE == 0) {
                    //echo '['.$i.'] Timesheets for User ' . $user->getId() . PHP_EOL;
                    $manager->flush();
                    $manager->clear(Timesheet::class);
                }
            }

            // create active recordings for test user
            $activeEntries = rand(self::MIN_RUNNING_TIMESHEETS_PER_USER, self::MAX_RUNNING_TIMESHEETS_PER_USER);
            for ($i = 0; $i < $activeEntries; $i++) {
                $entry = $this->createTimesheetEntry(
                    $user,
                    $activities[array_rand($activities)],
                    null,
                    false
                );
                $manager->persist($entry);
            }

            $manager->flush();
            $manager->clear(Timesheet::class);
        }
        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     * @return User[]
     */
    protected function getAllUsers(ObjectManager $manager)
    {
        $all = [];
        /* @var User[] $entries */
        $entries = $manager->getRepository(User::class)->findAll();
        foreach ($entries as $temp) {
            $all[$temp->getId()] = $temp;
        }

        return $all;
    }

    /**
     * @param ObjectManager $manager
     * @return Activity[]
     */
    protected function getAllActivities(ObjectManager $manager)
    {
        $all = [];
        /* @var User[] $entries */
        $entries = $manager->getRepository(Activity::class)->findAll();
        foreach ($entries as $temp) {
            $all[$temp->getId()] = $temp;
        }

        return $all;
    }

    private function createTimesheetEntry(User $user, Activity $activity, $description, $setEndDate = true)
    {
        $start = new \DateTime();
        $start = $start->modify('- ' . (rand(1, self::TIMERANGE_DAYS)) . ' days');
        $start = $start->modify('- ' . (rand(1, 86400)) . ' seconds');

        $entry = new Timesheet();
        $entry
            ->setActivity($activity)
            ->setDescription($description)
            ->setUser($user)
            ->setBegin($start);

        if ($setEndDate) {
            $end = clone $start;
            $end = $end->modify('+ ' . (rand(self::MIN_MINUTES_PER_ENTRY, self::MAX_MINUTES_PER_ENTRY)) . ' minutes');

            $duration = $end->getTimestamp() - $start->getTimestamp();
            $rate = $user->getPreferenceValue(UserPreference::HOURLY_RATE);

            $entry
                ->setEnd($end)
                ->setRate(round(($duration / 3600) * $rate))
                ->setDuration($duration);
        }

        return $entry;
    }
}
