<?php

namespace Test1Bundle\Entity;

/**
 * CompanyContact
 */
class CompanyContact
{
    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var integer
     */
    private $createBy;

    /**
     * @var \DateTime
     */
    private $createDate;

    /**
     * @var integer
     */
    private $modifyBy;

    /**
     * @var \DateTime
     */
    private $modifyDate;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Test1Bundle\Entity\Company
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
     * @param \Test1Bundle\Entity\Company $company
     *
     * @return CompanyContact
     */
    public function setCompany(\Test1Bundle\Entity\Company $company = null)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return \Test1Bundle\Entity\Company
     */
    public function getCompany()
    {
        return $this->company;
    }
}

