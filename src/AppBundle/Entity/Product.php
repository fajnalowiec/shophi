<?php

// src/AppBundle/Entity/Product.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 * @ORM\Table(name="product")
 * @UniqueEntity(fields="name", message="Product with this name already exists")
 */
class Product
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     *
     * @Assert\NotBlank(
     *      message = "Name field should not be blank"
     * )
     * @Assert\Length(
     *      max = 100,
     *      maxMessage = "Name field should not be longer than {{ limit }} characters"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="decimal", scale=2)
     *
     * @Assert\Regex(
     *     pattern = "/^\d+(\.\d{1}\d?)?$/",
     *     message = "Price field should be a valid currency value (e.g. 12.34, 0.5, 367)"
     * )
     * @Assert\GreaterThan(
     *     value = 0,
     *     message = "Price field should be a positive number"
     * )
     *
     */
    private $price;

    /**
     * @ORM\Column(type="text")
     *
     * * @Assert\NotBlank(
     *      message = "Description field should not be blank"
     * )
     * @Assert\Length(
     *      min = 100,
     *      minMessage = "Description field should be longer than {{ limit }} characters"
     * )
     */
    private $description;

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
     * Set price
     *
     * @param string $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
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

}
