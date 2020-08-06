<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AddressRepository")
 */
class Address
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
    private ?string $address;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private ?string $postal_number;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="user")
     * @ORM\JoinColumn(nullable=false)
     */
    private User $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalNumber(): ?string
    {
        return $this->postal_number;
    }

    public function setPostalNumber(string $postal_number): self
    {
        $this->postal_number = $postal_number;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser($user): self
    {
        $this->user = $user;

        return $this;
    }
}