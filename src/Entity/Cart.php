<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CartRepository::class)
 */
class Cart
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Shopper::class, inversedBy="carts")
     */
    private $shopper_id;

    /**
     * @ORM\ManyToOne(targetEntity=Shop::class, inversedBy="carts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $shop_id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="carts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $delivery_start;

    /**
     * @ORM\Column(type="datetime")
     */
    private $delivery_end;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="float")
     */
    private $total;

    /**
     * @ORM\ManyToOne(targetEntity=Address::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $address_id;

    /**
     * @ORM\OneToMany(targetEntity=CartProduct::class, mappedBy="Cart_id", orphanRemoval=true)
     */
    private $cartProducts;

    /**
     * @ORM\Column(type="datetime")
     */
    private $buy_date;

    /**
     * @ORM\Column(type="datetime")
     */
    private $delivery_date;

    public function __construct()
    {
        $this->cartProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShopperId(): ?Shopper
    {
        return $this->shopper_id;
    }

    public function setShopperId(?Shopper $shopper_id): self
    {
        $this->shopper_id = $shopper_id;

        return $this;
    }

    public function getShopId(): ?Shop
    {
        return $this->shop_id;
    }

    public function setShopId(?Shop $shop_id): self
    {
        $this->shop_id = $shop_id;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getDeliveryStart(): ?\DateTimeInterface
    {
        return $this->delivery_start;
    }

    public function setDeliveryStart(\DateTimeInterface $delivery_start): self
    {
        $this->delivery_start = $delivery_start;

        return $this;
    }

    public function getDeliveryEnd(): ?\DateTimeInterface
    {
        return $this->delivery_end;
    }

    public function setDeliveryEnd(\DateTimeInterface $delivery_end): self
    {
        $this->delivery_end = $delivery_end;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getAddressId(): ?Address
    {
        return $this->address_id;
    }

    public function setAddressId(?Address $address_id): self
    {
        $this->address_id = $address_id;

        return $this;
    }

    /**
     * @return Collection|CartProduct[]
     */
    public function getCartProducts(): Collection
    {
        return $this->cartProducts;
    }

    public function addCartProduct(CartProduct $cartProduct): self
    {
        if (!$this->cartProducts->contains($cartProduct)) {
            $this->cartProducts[] = $cartProduct;
            $cartProduct->setCartId($this);
        }

        return $this;
    }

    public function removeCartProduct(CartProduct $cartProduct): self
    {
        if ($this->cartProducts->contains($cartProduct)) {
            $this->cartProducts->removeElement($cartProduct);
            // set the owning side to null (unless already changed)
            if ($cartProduct->getCartId() === $this) {
                $cartProduct->setCartId(null);
            }
        }

        return $this;
    }

    public function getBuyDate(): ?\DateTimeInterface
    {
        return $this->buy_date;
    }

    public function setBuyDate(\DateTimeInterface $buy_date): self
    {
        $this->buy_date = $buy_date;

        return $this;
    }

    public function getDeliveryDate(): ?\DateTimeInterface
    {
        return $this->delivery_date;
    }

    public function setDeliveryDate(\DateTimeInterface $delivery_date): self
    {
        $this->delivery_date = $delivery_date;

        return $this;
    }
}
