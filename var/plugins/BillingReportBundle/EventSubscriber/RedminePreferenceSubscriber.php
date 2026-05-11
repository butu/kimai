<?php

/*
 * This file is part of the Kimai plugin "Billing report".
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\BillingReportBundle\EventSubscriber;

use App\Entity\UserPreference;
use App\Event\UserPreferenceEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\Range;

final class RedminePreferenceSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            UserPreferenceEvent::class => ['loadRedminePreference', 100],
        ];
    }

    public function loadRedminePreference(UserPreferenceEvent $event): void
    {
        $preference = (new UserPreference('redmine_user_id'))
            ->setLabel('Redmine User ID')
            ->setType(IntegerType::class)
            ->setOptions(['required' => false])
            ->addConstraint(new Range(['min' => 0]))
            ->setOrder(50)
            ->setSection('default');

        $event->addPreference($preference);
    }
}
