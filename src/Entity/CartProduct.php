<?php

namespace App\Entity;

use App\Repository\CartProductRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CartProductRepository::class)
 */
class CartProduct
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=Cart::class, inversedBy="cartProducts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Cart_id;

    /**
     * @ORM\ManyToOne(targetEntity=ProductCatalog::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $product_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getCartId(): ?Cart
    {
        return $this->Cart_id;
    }

    public function setCartId(?Cart $Cart_id): self
    {
        $this->Cart_id = $Cart_id;

        return $this;
    }

    public function getProductId(): ?ProductCatalog
    {
        return $this->product_id;
    }

    public function setProductId(?ProductCatalog $product_id): self
    {
        $this->product_id = $product_id;

        return $this;
    }
}
