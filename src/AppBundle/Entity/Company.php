<?php
/**
 * Created by PhpStorm.
 * User: Eligijus Stugys
 * Date: 2016.04.03
 * Time: 10:06
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Company
 *
 * @ORM\Table(name="company")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\CompanyRepository")
 */
class Company extends TimestampedEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=1000, nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="create_by", type="integer", nullable=true)
     */
    private $createBy;

    /**
     * @var integer
     *
     * @ORM\Column(name="modify_by", type="integer", nullable=true)
     */
    private $modifyBy;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
