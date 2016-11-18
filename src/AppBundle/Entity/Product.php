<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 */
class Product
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="date")
     */
    private $creationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_change_date", type="date")
     */
    private $lastChangeDate;

    /**
     * @var bool
     *
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive;

    /**
     * @var string
     *
     * @ORM\Column(name="SKU", type="string", length=255, unique=true)
     */
    private $sKU;

    /**
     * @var array
     *
     * @ORM\Column(name="related_products", type="array", nullable=true)
     */
    private $relatedProducts;


    public function __construct()
    {
        $this->creationDate = new \DateTime('now');
        $this->lastChangeDate = new \DateTime('now');
        $this->isActive = true;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Product
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
     * @return Product
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
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Product
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set lastChangeDate
     *
     * @param \DateTime $lastChangeDate
     *
     * @return Product
     */
    public function setLastChangeDate($lastChangeDate)
    {
        $this->lastChangeDate = $lastChangeDate;

        return $this;
    }

    /**
     * Get lastChangeDate
     *
     * @return \DateTime
     */
    public function getLastChangeDate()
    {
        return $this->lastChangeDate;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Product
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set sKU
     *
     * @param string $sKU
     *
     * @return Product
     */
    public function setSKU($sKU)
    {
        $this->sKU = $sKU;

        return $this;
    }

    /**
     * Get sKU
     *
     * @return string
     */
    public function getSKU()
    {
        return $this->sKU;
    }

    /**
     * Set relatedProducts
     *
     * @param array $relatedProducts
     *
     * @return Product
     */
    public function setRelatedProducts($relatedProducts)
    {
        $this->relatedProducts = $relatedProducts;

        return $this;
    }

    /**
     * Get relatedProducts
     *
     * @return array
     */
    public function getRelatedProducts()
    {
        return $this->relatedProducts;
    }
}

