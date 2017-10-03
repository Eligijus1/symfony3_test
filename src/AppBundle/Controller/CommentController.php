<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Manager\CommentManager;
use AppBundle\Entity\User;
use AppBundle\Form\CommentType;
use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\Pagination\AbstractPagination;
use Knp\Component\Pager\Paginator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\TranslatorInterface;

class CommentController extends BaseController
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var CommentManager
     */
    private $commentManager;

    /**
     * CompanyController constructor.
     *
     * @param TranslatorInterface $translator
     * @param CommentManager      $commentManager
     */
    public function __construct(TranslatorInterface $translator, CommentManager $commentManager)
    {
        $this->translator = $translator;
        $this->commentManager = $commentManager;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request): Response
    {
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
        $qb->from(Comment::class, "entity");
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

        return $this->render('AppBundle:comment:index.html.twig', array(
            'comments' => $pagination,
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
        $user = $this->getUser();

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setCreateBy($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

//            // Creating the ACL:
//            /** @var MutableAclProvider $aclProvider */
//            $aclProvider    = $this->get('security.acl.provider');
//            $objectIdentity = ObjectIdentity::fromDomainObject($comment);
//            $acl            = $aclProvider->createAcl($objectIdentity);
//
//            // Retrieving the security identity of the currently logged-in user
//            $tokenStorage     = $this->get('security.token_storage');
//            $user             = $tokenStorage->getToken()->getUser();
//            $securityIdentity = UserSecurityIdentity::fromAccount($user);
//
//            // Grant owner access
//            $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OWNER);
//            $aclProvider->updateAcl($acl);

            return $this->redirectToRoute('comment_index');
        }

        return $this->render('AppBundle:CRUD:new.html.twig', array(
            'entity' => $comment,
            'form' => $form->createView(),
            'page_title' => 'Comments',
            'box_title' => 'Comment create',
            'path_to_list' => $this->generateUrl('comment_index')

        ));
    }

    /**
     * @param Comment $comment
     *
     * @return Response
     */
    public function showAction(Comment $comment): Response
    {
        return $this->render('AppBundle:CRUD:view.html.twig', array(
            'page_title' => $this->translator->trans('comment.comments'),
            'box_title' => $this->translator->trans('comment.actions.view.label', ['id' => $comment->getId()]),
            'path_to_list' => $this->generateUrl('comment_index'),
            'data' => [
                $this->translator->trans('company.id') => $comment->getId(),
                $this->translator->trans('company.description') => $comment->getComment(),
                $this->translator->trans('system_fields.created_by') => $comment->getCreateBy()->getFullName(),
                $this->translator->trans('system_fields.created_date') => $comment->getCreateDateAsString(),
                $this->translator->trans('system_fields.modified_by') => $comment->getModifyByFullName(),
                $this->translator->trans('system_fields.modify_date') => $comment->getModifyDateAsString(),
            ]
        ));
    }

    /**
     * @param Request $request
     * @param Comment $comment
     *
     * @return Response
     */
    public function editAction(Request $request, Comment $comment): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $editForm = $this->createForm(CommentType::class, $comment);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $comment->setModifyDate(new \DateTime());
            $comment->setModifyBy($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('comment_index');
        }

        return $this->render('AppBundle:CRUD:edit.html.twig', array(
            'entity' => $comment,
            'form' => $editForm->createView(),
            'page_title' => 'Comments',
            'box_title' => 'Comment edit',
            'path_to_list' => $this->generateUrl('comment_index')
        ));
    }

    /**
     * @param Comment $comment
     *
     * @return Response
     */
    public function deleteAction(Comment $comment): Response
    {
        $id = $comment->getId();

        try {
            $this->commentManager->delete($comment);
        } catch (\Throwable $e) {
            return $this->createErrorResponse($this->translator->trans('comment.actions.delete.error',
                ['error_message' => $e->getMessage()]));
        }

        $this->addFlash(
            'success',
            $this->translator->trans('comment.actions.delete.success', ['id' => $id])
        );

        return $this->createSuccessResponse($this->generateUrl('comment_index'));
    }
}
