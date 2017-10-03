<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Company;
use AppBundle\Entity\Manager\CompanyManager;
use AppBundle\Entity\User;
use AppBundle\Form\CompanyType;
use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\Pagination\AbstractPagination;
use Knp\Component\Pager\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\TranslatorInterface;

class CompanyController extends BaseController
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * CompanyController constructor.
     *
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_CAN_VIEW_COMPANIES');

        // Define paging required variables:
        $pageSize = 10;
        $pageNumber = $request->query->getInt('page', 1);
        $pageStartRecord = ($pageNumber * $pageSize) - $pageSize + 1;
        $pageEndRecord = ($pageNumber * $pageSize);

        // Get entity manager:
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        // Prepare query:
        $qb = $em->createQueryBuilder();
        $qb->select("entity");
        $qb->from(Company::class, "entity");
        $query = $em->createQuery($qb->getQuery()->getDQL());

        // Prepare paginator:
        /** @var Paginator $paginator */
        $paginator = $this->get('knp_paginator');
        /** @var AbstractPagination $pagination */
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $pageSize/*limit per page*/
        );

        // Return prepared list:
        return $this->render('AppBundle:Company:index.html.twig', array(
            'companies' => $pagination,
            'pageSize' => $pageSize,
            'pageNumber' => $pageNumber,
            'pageStartRecord' => $pageStartRecord,
            'pageEndRecord' => $pageEndRecord > $pagination->getTotalItemCount() ? $pagination->getTotalItemCount() : $pageEndRecord
        ));
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function newAction(Request $request): Response
    {
        /** @var User $user */
        $this->denyAccessUnlessGranted('ROLE_CAN_MANAGE_COMPANIES');

        $user = $this->getUser();
        $company = new Company();
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Add user information:
            $company->setCreateBy($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($company);
            $em->flush();

            /*
            $this->addFlash(
                'success',
                $translator->trans(
                    'price_rule_names.actions.new.success',
                    ['name_id' => $saleItemPriceRuleName->getId()]
                )
            );
            */
            $this->addFlash(
                'success',
                'Added new record.'
            );

            //return $this->redirectToRoute('company_show', array('id' => $company->getId()));
            return $this->redirectToRoute('company_index');
        }

        return $this->render('AppBundle:Company:new.html.twig', array(
            'company' => $company,
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Company $company
     *
     * @return Response
     */
    public function showAction(Company $company)
    {
        $this->denyAccessUnlessGranted('ROLE_CAN_VIEW_COMPANIES');

        $deleteForm = $this->createDeleteForm($company);

        return $this->render('AppBundle:Company:show.html.twig', array(
            'company' => $company,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Company entity.
     *
     * @Route("/{id}/edit", name="company_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Company $company
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Company $company)
    {
        /** @var User $user */
        $this->denyAccessUnlessGranted('ROLE_CAN_MANAGE_COMPANIES');

        $user = $this->getUser();

        $deleteForm = $this->createDeleteForm($company);
        $editForm = $this->createForm('AppBundle\Form\CompanyType', $company);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $company->setModifyBy($user);
            $company->setModifyDate(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($company);
            $em->flush();

            // return $this->redirectToRoute('company_edit', array('id' => $company->getId()));
            return $this->redirectToRoute('company_index');
        }

        return $this->render('AppBundle:Company:edit.html.twig', array(
            'company' => $company,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @param int $id
     *
     * @Route("/{id}", name="company_delete")
     *
     * @return JsonResponse
     */
    public function deleteAction(int $id) : JsonResponse
    {
        try {
            /** @var CompanyManager $companyManager */
            $companyManager = $this->get('manager.company');
            $companyManager->deleteById($id);
        } catch (\Throwable $e) {
            return $this->createErrorResponse($this->translator->trans('price_rule_names.actions.delete.error'));
        }

        $this->addFlash(
            'success',
            $this->translator->trans('price_rule_names.actions.delete.success', ['name_id' => $id])
        );

        return $this->createSuccessResponse($this->generateUrl('company_index'));
    }

    /**
     * Creates a form to delete a Company entity.
     *
     * @param Company $company The Company entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Company $company)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('company_delete', array('id' => $company->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
