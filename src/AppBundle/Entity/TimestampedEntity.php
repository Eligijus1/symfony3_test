<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entity of this class have actual timestamps of creation and last update.
 *
 * @ORM\MappedSuperclass
 */
abstract class TimestampedEntity
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createDate;

    /**
     * NOTE: Notice! Currently in MySQL migrations should be defined: `DATETIME on update CURRENT_TIMESTAMP`.
     *
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $modifyDate;

    /**
     * TimestampedEntity constructor.
     */
    public function __construct()
    {
        $this->createDate = new \DateTime();
    }

    /**
     * @return \DateTime
     */
    public function getCreateDate(): ?\DateTime
    {
        return $this->createDate;
    }

    /**
     * @param \DateTime $createDate
     *
     * @return TimestampedEntity
     */
    public function setCreateDate(\DateTime $createDate): TimestampedEntity
    {
        $this->createDate = $createDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getModifyDate(): ?\DateTime
    {
        return $this->modifyDate;
    }

    /**
     * @param \DateTime $modifyDate
     *
     * @return TimestampedEntity
     */
    public function setModifyDate(\DateTime $modifyDate): TimestampedEntity
    {
        $this->modifyDate = $modifyDate;
        return $this;
    }
}
