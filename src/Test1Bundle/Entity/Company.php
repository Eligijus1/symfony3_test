<?php

namespace Test1Bundle\Entity;

/**
 * Company
 */
class Company
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

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
     * Set name
     *
     * @param string $name
     *
     * @return Company
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Company
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createBy
     *
     * @param integer $createBy
     *
     * @return Company
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
     * @return Company
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
     * @return Company
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
     * @return Company
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
}

