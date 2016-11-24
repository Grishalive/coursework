<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;

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
    private $creation_date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_change_date", type="date")
     */
    private $last_change_date;

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
    private $sku;

    /**
     * @var array
     *
     * @ORM\Column(name="related_products", type="array", nullable=true)
     */
    private $related_products_id;

    /**
     * @ManyToOne(targetEntity="Category", inversedBy="products")
     * @JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;



    public function __construct()
    {
        $this->creation_date = new \DateTime('now');
        $this->last_change_date = new \DateTime('now');
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
     * @param \DateTime $creation_date
     *
     * @return Product
     */
    public function setCreationDate($creation_date)
    {
        $this->creation_date = $creation_date;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creation_date;
    }

    /**
     * Set lastChangeDate
     *
     * @param \DateTime $last_change_date
     *
     * @return Product
     */
    public function setLastChangeDate($last_change_date)
    {
        $this->last_change_date = $last_change_date;

        return $this;
    }

    /**
     * Get lastChangeDate
     *
     * @return \DateTime
     */
    public function getLastChangeDate()
    {
        return $this->last_change_date;
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
     * Set SKU
     *
     * @param string $sku
     *
     * @return Product
     */
    public function setSKU($sku)
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * Get SKU
     *
     * @return string
     */
    public function getSKU()
    {
        return $this->sku;
    }


    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param array $related_products_id
     */
    public function setRelatedProductsId(array $related_products_id)
    {
        $this->related_products_id = $related_products_id;
    }

    /**
     * Get relatedProductsId
     *
     * @return array
     */
    public function getRelatedProductsId()
    {
        return $this->related_products_id;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     *
     * @return Product
     */
    public function setCategory(Category $category = null)
    {
        $this->category = $category;

        return $this;
    }
}
