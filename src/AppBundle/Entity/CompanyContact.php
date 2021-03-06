<?php
/**
 * Created by PhpStorm.
 * User: Eligijus Stugys
 * Date: 2016.04.03
 * Time: 10:07
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CompanyContact
 *
 * @ORM\Table(name="company_contact", indexes={@ORM\Index(name="fk_company_contact_to_company", columns={"company_id"})})
 * @ORM\Entity
 */
class CompanyContact
{
    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=false)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255, nullable=false)
     */
    private $lastName;

    /**
     * @var integer
     *
     * @ORM\Column(name="create_by", type="integer", nullable=false)
     */
    private $createBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="create_date", type="datetime", nullable=false)
     */
    private $createDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="modify_by", type="integer", nullable=true)
     */
    private $modifyBy;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modify_date", type="datetime", nullable=true)
     */
    private $modifyDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Company
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Company")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     * })
     */
    private $company;



    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return CompanyContact
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return CompanyContact
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set createBy
     *
     * @param integer $createBy
     *
     * @return CompanyContact
     */
    public function setCreateBy($createBy)
    {
        $this->createBy = $createBy;

        return $this;
    }

    /**
     * Get createBy
     *
     * @return integer
     */
    public function getCreateBy()
    {
        return $this->createBy;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     *
     * @return CompanyContact
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * Get createDate
     *
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * Set modifyBy
     *
     * @param integer $modifyBy
     *
     * @return CompanyContact
     */
    public function setModifyBy($modifyBy)
    {
        $this->modifyBy = $modifyBy;

        return $this;
    }

    /**
     * Get modifyBy
     *
     * @return integer
     */
    public function getModifyBy()
    {
        return $this->modifyBy;
    }

    /**
     * Set modifyDate
     *
     * @param \DateTime $modifyDate
     *
     * @return CompanyContact
     */
    public function setModifyDate($modifyDate)
    {
        $this->modifyDate = $modifyDate;

        return $this;
    }

    /**
     * Get modifyDate
     *
     * @return \DateTime
     */
    public function getModifyDate()
    {
        return $this->modifyDate;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set company
     *
     * @param \AppBundle\Entity\Company $company
     *
     * @return CompanyContact
     */
    public function setCompany(\AppBundle\Entity\Company $company = null)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return \AppBundle\Entity\Company
     */
    public function getCompany()
    {
        return $this->company;
    }
}
