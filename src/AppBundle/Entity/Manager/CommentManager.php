<?php

namespace AppBundle\Entity\Manager;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Repository\CommentRepository;
use AppBundle\Entity\Repository\CompanyRepository;
use Doctrine\ORM\EntityManager;

/**
 * Class CompanyManager
 * @package AppBundle\Entity\Manager
 */
class CommentManager
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var CompanyRepository
     */
    private $companyRepository;

    /**
     * CommentManager constructor.
     *
     * @param EntityManager     $em
     * @param CommentRepository $companyRepository
     */
    public function __construct(EntityManager $em, CommentRepository $companyRepository)
    {
        $this->em = $em;
        $this->companyRepository = $companyRepository;
    }

    /**
     * @param Comment $comment
     */
    public function delete(Comment $comment) : void
    {
        $this->em->remove($comment);
        $this->em->flush();
    }
}
