<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 */
class Category
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
     * @ORM\Column(name="name", type="string", length=30, unique=true)
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive;

    /**
     *
     *
     * @ORM\Column(name="parent_category", type="object", nullable=true)
     */
    private $parent_id;

    /**
     * @var array
     *
     * @ORM\Column(name="products", type="array", nullable=true)
     */
    private $products;

    /**
     * Get id
     *
     * @return int
     */
    public function getID()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Category
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
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Category
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
     * Set products
     *
     * @param array $products
     *
     * @return Category
     */
    public function setProducts($products)
    {
        $this->products = $products;

        return $this;
    }

    /**
     * Get products
     *
     * @return array
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Set parent_id
     *
     * @param int $id
     *
     * @return Category
     */
    public function setParentID(int $id)
    {
        $this->parent_id = $id;
        return $this;
    }

    /**
     * Get parent_id
     *
     * @return int
     */
    public function getParentID()
    {
        return $this->parent_id;
    }
}
