<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Admin;

use App\Controller\AbstractController;
use App\Entity\Customer;
use App\Entity\Project;
use App\Form\ProjectEditForm;
use App\Form\Toolbar\ProjectToolbarForm;
use App\Repository\Query\ProjectQuery;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller used to manage projects in the admin part of the site.
 *
 * @Route("/admin/project")
 * @Security("is_granted('ROLE_ADMIN')")
 * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
 */
class ProjectController extends AbstractController
{
    /**
     * @return \App\Repository\ProjectRepository
     */
    protected function getRepository()
    {
        return $this->getDoctrine()->getRepository(Project::class);
    }

    /**
     * @Route("/", defaults={"page": 1}, name="admin_project")
     * @Route("/page/{page}", requirements={"page": "[1-9]\d*"}, name="admin_project_paginated")
     * @Method("GET")
     * @Cache(smaxage="10")
     */
    public function indexAction($page, Request $request)
    {
        $query = new ProjectQuery();
        $query->setExclusiveVisibility(true);
        $query->setPage($page);

        $form = $this->getToolbarForm($query);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var ProjectQuery $query */
            $query = $form->getData();
        }

        /* @var $entries Pagerfanta */
        $entries = $this->getDoctrine()->getRepository(Project::class)->findByQuery($query);

        return $this->render('admin/project.html.twig', [
            'entries' => $entries,
            'query' => $query,
            'toolbarForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/create", name="admin_project_create")
     * @Method({"GET", "POST"})
     */
    public function createAction(Request $request)
    {
        return $this->renderProjectForm(new Project(), $request);
    }

    /**
     * @Route("/{id}/edit", name="admin_project_edit")
     * @Method({"GET", "POST"})
     * @Security("is_granted('edit', project)")
     */
    public function editAction(Project $project, Request $request)
    {
        return $this->renderProjectForm($project, $request);
    }

    /**
     * The route to delete an existing entry.
     *
     * @Route("/{id}/delete", name="admin_project_delete")
     * @Method({"GET", "POST"})
     * @Security("is_granted('delete', project)")
     *
     * @param Project $project
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Project $project, Request $request)
    {
        $stats = $this->getRepository()->getProjectStatistics($project);

        $deleteForm = $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_project_delete', ['id' => $project->getId()]))
            ->setMethod('POST')
            ->getForm();

        $deleteForm->handleRequest($request);

        if (0 == $stats->getRecordAmount() || ($deleteForm->isSubmitted() && $deleteForm->isValid())) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($project);
            $entityManager->flush();

            $this->flashSuccess('action.deleted_successfully');

            return $this->redirectToRoute('admin_project');
        }

        return $this->render('admin/project_delete.html.twig', [
            'project' => $project,
            'stats' => $stats,
            'form' => $deleteForm->createView(),
        ]);
    }

    /**
     * @param Project $project
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    protected function renderProjectForm(Project $project, Request $request)
    {
        $editForm = $this->createEditForm($project);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($project);
            $entityManager->flush();

            $this->flashSuccess('action.updated_successfully');

            if ($editForm->has('create_more') && $editForm->get('create_more')->getData() === true) {
                $newProject = new Project();
                $newProject->setCustomer($project->getCustomer());
                $editForm = $this->createEditForm($newProject);
                $editForm->get('create_more')->setData(true);
                $project = $newProject;
            } else {
                return $this->redirectToRoute('admin_project');
            }
        }

        return $this->render('admin/project_edit.html.twig', [
            'project' => $project,
            'form' => $editForm->createView()
        ]);
    }

    /**
     * @param ProjectQuery $query
     * @return \Symfony\Component\Form\FormInterface
     */
    protected function getToolbarForm(ProjectQuery $query)
    {
        return $this->createForm(ProjectToolbarForm::class, $query, [
            'action' => $this->generateUrl('admin_project', [
                'page' => $query->getPage(),
            ]),
            'method' => 'GET',
        ]);
    }

    /**
     * @param Project $project
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createEditForm(Project $project)
    {
        if ($project->getId() === null) {
            $url = $this->generateUrl('admin_project_create');
            $currency = Customer::DEFAULT_CURRENCY;
        } else {
            $url = $this->generateUrl('admin_project_edit', ['id' => $project->getId()]);
            $currency = $project->getCustomer()->getCurrency();
        }

        return $this->createForm(
            ProjectEditForm::class,
            $project,
            [
                'action' => $url,
                'method' => 'POST',
                'currency' => $currency,
            ]
        );
    }
}
