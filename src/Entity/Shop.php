<?php

namespace App\Entity;

use App\Repository\ShopRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ShopRepository::class)
 */
class Shop
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity=Shopper::class, mappedBy="shop_id")
     */
    private $shoppers;

    /**
     * @ORM\OneToMany(targetEntity=ProductCatalog::class, mappedBy="shop_id", orphanRemoval=true)
     */
    private $productCatalogs;

    /**
     * @ORM\OneToMany(targetEntity=Cart::class, mappedBy="shop_id", orphanRemoval=true)
     */
    private $carts;

    public function __construct()
    {
        $this->shoppers = new ArrayCollection();
        $this->productCatalogs = new ArrayCollection();
        $this->carts = new ArrayCollection();
    }

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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection|Shopper[]
     */
    public function getShoppers(): Collection
    {
        return $this->shoppers;
    }

    public function addShopper(Shopper $shopper): self
    {
        if (!$this->shoppers->contains($shopper)) {
            $this->shoppers[] = $shopper;
            $shopper->setShopId($this);
        }

        return $this;
    }

    public function removeShopper(Shopper $shopper): self
    {
        if ($this->shoppers->contains($shopper)) {
            $this->shoppers->removeElement($shopper);
            // set the owning side to null (unless already changed)
            if ($shopper->getShopId() === $this) {
                $shopper->setShopId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProductCatalog[]
     */
    public function getProductCatalogs(): Collection
    {
        return $this->productCatalogs;
    }

    public function addProductCatalog(ProductCatalog $productCatalog): self
    {
        if (!$this->productCatalogs->contains($productCatalog)) {
            $this->productCatalogs[] = $productCatalog;
            $productCatalog->setShopId($this);
        }

        return $this;
    }

    public function removeProductCatalog(ProductCatalog $productCatalog): self
    {
        if ($this->productCatalogs->contains($productCatalog)) {
            $this->productCatalogs->removeElement($productCatalog);
            // set the owning side to null (unless already changed)
            if ($productCatalog->getShopId() === $this) {
                $productCatalog->setShopId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Cart[]
     */
    public function getCarts(): Collection
    {
        return $this->carts;
    }

    public function addCart(Cart $cart): self
    {
        if (!$this->carts->contains($cart)) {
            $this->carts[] = $cart;
            $cart->setShopId($this);
        }

        return $this;
    }

    public function removeCart(Cart $cart): self
    {
        if ($this->carts->contains($cart)) {
            $this->carts->removeElement($cart);
            // set the owning side to null (unless already changed)
            if ($cart->getShopId() === $this) {
                $cart->setShopId(null);
            }
        }

        return $this;
    }
}
