<?php

/*
 * This file is part of the Kimai plugin "Billing report".
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\BillingReportBundle\Controller;

use App\Controller\AbstractController;
use KimaiPlugin\BillingReportBundle\Reporting\BillingReportForm;
use KimaiPlugin\BillingReportBundle\Reporting\BillingReportQuery;
use KimaiPlugin\BillingReportBundle\Reporting\BillingReportService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class BillingReportController extends AbstractController
{
    #[Route(path: '/reporting/billing_report', name: 'report_billing', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function __invoke(Request $request, BillingReportService $service): Response
    {
        $user = $this->getUser();
        $query = new BillingReportQuery($user);
        $form = $this->createFormForGetRequest(BillingReportForm::class, $query, [
            'timezone' => $user->getTimezone()
        ]);
        $form->submit($request->query->all(), false);

        $entries = $service->getReport($query);

        return $this->render('@BillingReport/reporting/billing_report.html.twig', [
            'report_title' => 'report_billing',
            'entries' => $entries,
            'form' => $form->createView(),
        ]);
    }
}
