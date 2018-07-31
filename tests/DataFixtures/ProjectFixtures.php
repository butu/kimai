<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\DataFixtures;

use App\Entity\Customer;
use App\Entity\Project;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

/**
 * Defines the sample data to load in during controller tests.
 */
class ProjectFixtures extends Fixture
{
    /**
     * @var int
     */
    protected $amount = 0;

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     * @return ProjectFixtures
     */
    public function setAmount(int $amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $customers = $this->getAllCustomers($manager);
        $faker = Factory::create();

        for ($i = 0; $i < $this->amount; $i++) {
            $visible = 0 != $i % 3;
            $entity = new Project();
            $entity
                ->setName($faker->catchPhrase . ($visible ? '' : ' (x)'))
                ->setBudget(rand(0, 10000))
                ->setComment($faker->text)
                ->setCustomer($customers[array_rand($customers)])
                ->setVisible($visible)
            ;

            $manager->persist($entity);
        }

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     * @return Customer[]
     */
    protected function getAllCustomers(ObjectManager $manager)
    {
        $all = [];
        /* @var User[] $entries */
        $entries = $manager->getRepository(Customer::class)->findAll();
        foreach ($entries as $temp) {
            $all[$temp->getId()] = $temp;
        }

        return $all;
    }
}
