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
    private ?int $id;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $quantity;

    /**
     * @var Cart
     * @ORM\ManyToOne(targetEntity=Cart::class, inversedBy="cart")
     * @ORM\JoinColumn(nullable=false)
     */
    private Cart $Cart;

    /**
     * @var ProductCatalog
     * @ORM\ManyToOne(targetEntity=ProductCatalog::class, inversedBy="ProductCatalog")
     * @ORM\JoinColumn(nullable=false)
     */
    private ProductCatalog $product;

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
        return $this->Cart;
    }

    /**
     * @param Cart $Cart
     * @return $this
     */
    public function setCartId($Cart): self
    {
        $this->Cart = $Cart;

        return $this;
    }

    public function getProductId(): ?ProductCatalog
    {
        return $this->product;
    }

    /**
     * @param ProductCatalog $product
     * @return $this
     */
    public function setProductId( $product): self
    {
        $this->product = $product;

        return $this;
    }
}