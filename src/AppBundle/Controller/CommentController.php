<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\User;
use AppBundle\Form\CommentType;
use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\Pagination\AbstractPagination;
use Knp\Component\Pager\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CommentController extends BaseController
{
    /**
     * CommentController constructor.
     */
    public function __construct()
    {

    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request): Response
    {
        // Define paging required variables:
        $pageSize        = 10;
        $pageNumber      = $request->query->getInt('page', 1);
        $pageStartRecord = ($pageNumber * $pageSize) - $pageSize + 1;
        $pageEndRecord   = ($pageNumber * $pageSize);

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
            'comments'        => $pagination,
            'pageSize'        => $pageSize,
            'pageNumber'      => $pageNumber,
            'pageStartRecord' => $pageStartRecord,
            'pageEndRecord'   => $pageEndRecord > $pagination->getTotalItemCount() ? $pagination->getTotalItemCount() : $pageEndRecord
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
        $form    = $this->createForm(CommentType::class, $comment);
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

        return $this->render('AppBundle:comment:new.html.twig', array(
            'comment' => $comment,
            'form'    => $form->createView(),
        ));
    }

    /**
     * @param Comment $comment
     *
     * @return Response
     */
    public function showAction(Comment $comment): Response
    {
        $deleteForm = $this->createDeleteForm($comment);

        return $this->render('AppBundle:comment:show.html.twig', array(
            'comment'     => $comment,
            'delete_form' => $deleteForm->createView(),
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
//        $authorizationChecker = $this->get('security.authorization_checker');

//        // Check for edit access:
//        if (false === $authorizationChecker->isGranted('EDIT', $comment)) {
//            throw new AccessDeniedException();
//        }

        $deleteForm = $this->createDeleteForm($comment);
        $editForm   = $this->createForm('AppBundle\Form\CommentType', $comment);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('comment_edit', array('id' => $comment->getId()));
        }

        return $this->render('AppBundle:comment:edit.html.twig', array(
            'comment'     => $comment,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @param Request $request
     * @param Comment $comment
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $request, Comment $comment): Response
    {
        $form = $this->createDeleteForm($comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($comment);
            $em->flush();
        }

        return $this->redirectToRoute('comment_index');
    }

    /**
     * Creates a form to delete a Comment entity.
     *
     * @param Comment $comment The Comment entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Comment $comment)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('comment_delete', array('id' => $comment->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
