<?php

/*
 * This file is part of the Kimai plugin "Billing report".
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\BillingReportBundle\EventSubscriber;

use App\Event\ReportingEvent;
use App\Reporting\Report;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final class BillingReportSubscriber implements EventSubscriberInterface
{
    public function __construct(private AuthorizationCheckerInterface $security)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ReportingEvent::class => ['onReportingEvent', 100],
        ];
    }

    public function onReportingEvent(ReportingEvent $event): void
    {
        if ($this->security->isGranted('ROLE_ADMIN')) {
            $event->addReport(new Report('billing_report', 'report_billing', 'report_billing', 'coin'));
        }
    }
}
