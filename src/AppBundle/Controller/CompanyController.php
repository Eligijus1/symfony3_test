<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Company;
use AppBundle\Entity\Manager\CompanyManager;
use AppBundle\Entity\User;
use AppBundle\Form\CompanyType;
use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\Pagination\AbstractPagination;
use Knp\Component\Pager\Paginator;
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
     * @var CompanyManager
     */
    private $companyManager;

    /**
     * CompanyController constructor.
     *
     * @param TranslatorInterface $translator
     * @param CompanyManager      $companyManager
     */
    public function __construct(TranslatorInterface $translator, CompanyManager $companyManager)
    {
        $this->translator = $translator;
        $this->companyManager = $companyManager;
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

        return $this->render('AppBundle:CRUD:new.html.twig', array(
            'entity' => $company,
            'form' => $form->createView(),
            'page_title' => $this->translator->trans('company.companies'),
            'box_title' => $this->translator->trans('company.actions.new.label'),
            'path_to_list' => $this->generateUrl('company_index')

        ));
    }

    /**
     * @param Company $company
     *
     * @return Response
     */
    public function showAction(Company $company): Response
    {
        $this->denyAccessUnlessGranted('ROLE_CAN_VIEW_COMPANIES');

        return $this->render('AppBundle:CRUD:view.html.twig', array(
            'page_title' => $this->translator->trans('company.companies'),
            'box_title' => $this->translator->trans('company.actions.view.label', ['id' => $company->getId()]),
            'path_to_list' => $this->generateUrl('company_index'),
            'data' => [
                $this->translator->trans('company.id') => $company->getId(),
                $this->translator->trans('company.name') => $company->getName(),
                $this->translator->trans('company.description') => $company->getDescription(),
                $this->translator->trans('system_fields.created_by') => $company->getCreateBy()->getFullName(),
                $this->translator->trans('system_fields.created_date') => $company->getCreateDateAsString(),
                $this->translator->trans('system_fields.modified_by') => $company->getModifyBy()
                    ? $company->getModifyBy()->getFullName() : null,
                $this->translator->trans('system_fields.modify_date') => $company->getModifyDateAsString(),
            ]

        ));
    }

    /**
     * @param Request $request
     * @param Company $company
     *
     * @return Response
     */
    public function editAction(Request $request, Company $company): Response
    {
        /** @var User $user */
        $this->denyAccessUnlessGranted('ROLE_CAN_MANAGE_COMPANIES');

        $user = $this->getUser();

        $editForm = $this->createForm('AppBundle\Form\CompanyType', $company);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $company->setModifyBy($user);
            $company->setModifyDate(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($company);
            $em->flush();

            return $this->redirectToRoute('company_index');
        }

        return $this->render('AppBundle:CRUD:edit.html.twig', array(
            'entity' => $company,
            'form' => $editForm->createView(),
            'page_title' => $this->translator->trans('company.companies'),
            'box_title' => $this->translator->trans('company.actions.edit.label'),
            'path_to_list' => $this->generateUrl('company_index')
        ));
    }

    /**
     * @param int $id
     *
     * @return JsonResponse
     */
    public function deleteAction(int $id): JsonResponse
    {
        try {
            $this->companyManager->deleteById($id);
        } catch (\Throwable $e) {
            return $this->createErrorResponse($this->translator->trans('company.actions.delete.error',
                ['error_message' => $e->getMessage()]));
        }

        $this->addFlash(
            'success',
            $this->translator->trans('company.actions.delete.success', ['id' => $id])
        );

        return $this->createSuccessResponse($this->generateUrl('company_index'));
    }
}
