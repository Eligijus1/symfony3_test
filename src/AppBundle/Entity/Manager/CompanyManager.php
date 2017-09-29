<?php

namespace AppBundle\Entity\Manager;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Company;
use AppBundle\Entity\Repository\CompanyRepository;

/**
 * Class CompanyManager
 * @package AppBundle\Entity\Manager
 */
class CompanyManager
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
     * Manager constructor.
     *
     * @param EntityManager     $em
     * @param CompanyRepository $companyRepository
     */
    public function __construct(EntityManager $em, CompanyRepository $companyRepository)
    {
        $this->em = $em;
        $this->companyRepository = $companyRepository;
    }

    /**
     * @param Company $company
     */
    public function add(Company $company) : void
    {
        $this->em->persist($company);
        $this->em->flush();
    }

    /**
     * @param Company $company
     */
    public function update(Company $company) : void
    {
        $this->add($company);
    }

    /**
     * @param Company $company
     */
    public function delete(Company $company) : void
    {
        $this->em->remove($company);
        $this->em->flush();
    }

    /**
     * @param int $companyId
     */
    public function deleteById(int $companyId) : void
    {
        /** @var Company $company */
        $company = $this->companyRepository->find($companyId);
        $this->delete($company);
    }
}
