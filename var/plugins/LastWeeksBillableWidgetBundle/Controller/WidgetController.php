<?php

/*
 * This file is part of the Kimai plugin "Last weeks billable widget".
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\LastWeeksBillableWidgetBundle\Controller;

use App\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route(path: '/widgets/last-weeks-billable')]
#[IsGranted('IS_AUTHENTICATED_REMEMBERED')]
final class WidgetController extends AbstractController
{
    #[Route(path: '/{year}/{month}', requirements: ['year' => '[1-9]\d*', 'month' => '([1-9]|1[0-2])'], name: 'widgets_last_weeks_billable_chart', methods: ['GET'])]
    #[IsGranted('view_own_timesheet')]
    public function chartAction(int $year, int $month): Response
    {
        return $this->render('@LastWeeksBillableWidget/widget/lastweeksbillablechart.html.twig', [
            'user' => $this->getUser(),
            'year' => $year,
            'month' => $month,
        ]);
    }
}
