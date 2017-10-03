<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entity of this class have actual timestamps of creation and last update.
 *
 * @ORM\MappedSuperclass
 */
abstract class BaseEntity
{
    private const DATE_TIME_STRING_FORMAT = 'Y-m-d H:i:s';

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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createBy;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $modifyBy;

    /**
     * BaseEntity constructor.
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
     * @return string
     */
    public function getCreateDateAsString(): string
    {
        return $this->createDate ? $this->createDate->format(self::DATE_TIME_STRING_FORMAT)  : '';
    }

    /**
     * @param \DateTime $createDate
     *
     * @return BaseEntity
     */
    public function setCreateDate(\DateTime $createDate): BaseEntity
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
     * @return string
     */
    public function getModifyDateAsString(): string
    {
        return $this->modifyDate ? $this->modifyDate->format(self::DATE_TIME_STRING_FORMAT)  : '';
    }

    /**
     * @param \DateTime $modifyDate
     *
     * @return BaseEntity
     */
    public function setModifyDate(\DateTime $modifyDate): BaseEntity
    {
        $this->modifyDate = $modifyDate;
        return $this;
    }

    /**
     * @param User $createBy
     *
     * @return BaseEntity
     */
    public function setCreateBy(User $createBy): BaseEntity
    {
        $this->createBy = $createBy;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getCreateBy(): ?User
    {
        return $this->createBy;
    }

    /**
     * @param User|null $modifyBy
     *
     * @return BaseEntity
     */
    public function setModifyBy(?User $modifyBy): BaseEntity
    {
        $this->modifyBy = $modifyBy;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getModifyBy(): ?User
    {
        return $this->modifyBy;
    }
}
