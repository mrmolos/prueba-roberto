<?php

namespace App\Entity;

use App\Repository\ProductCatalogRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductCatalogRepository::class)
 */
class ProductCatalog
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $description;

    /**
     * @ORM\Column(type="float")
     */
    private ?float $price;

    /**
     * @var Shop
     * @ORM\ManyToOne(targetEntity=Shop::class, inversedBy="shop")
     * @ORM\JoinColumn(nullable=false)
     */
    private Shop $shop;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getShop(): ?Shop
    {
        return $this->shop;
    }

    /**
     * @param Shop $shop
     * @return $this
     */
    public function setShop( $shop): self
    {
        $this->shop = $shop;

        return $this;
    }
}