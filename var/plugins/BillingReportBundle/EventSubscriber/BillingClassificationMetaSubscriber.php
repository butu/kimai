<?php

/*
 * This file is part of the Kimai plugin "Billing report".
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\BillingReportBundle\EventSubscriber;

use App\Entity\ProjectMeta;
use App\Event\ProjectMetaDefinitionEvent;
use App\Event\ProjectMetaDisplayEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\NotNull;

final class BillingClassificationMetaSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            ProjectMetaDefinitionEvent::class => ['loadMeta', 200],
            ProjectMetaDisplayEvent::class => ['displayMeta', 200],
        ];
    }

    public function loadMeta(ProjectMetaDefinitionEvent $event): void
    {
        $definition = (new ProjectMeta())
            ->setName('billing_classification')
            ->setLabel('billingClassification')
            ->setType(ChoiceType::class)
            ->setOptions([
                'choices' => [
                    'billingClassification_flat' => 'flat',
                    'billingClassification_atcost' => 'atcost',
                ],
                'placeholder' => '',
                'required' => true,
            ])
            ->addConstraint(new NotNull())
            ->setIsVisible(true)
            ->setIsRequired(true);

        $event->getEntity()->setMetaField($definition);
    }

    public function displayMeta(ProjectMetaDisplayEvent $event): void
    {
        $definition = (new ProjectMeta())
            ->setName('billing_classification')
            ->setLabel('billingClassification')
            ->setIsVisible(true);

        $event->addField($definition);
    }
}
