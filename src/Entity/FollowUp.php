<?php

namespace App\Entity;

use App\Repository\FollowUpRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FollowUpRepository::class)]
class FollowUp
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $contactName = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $comment = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $callDate = null;

    #[ORM\ManyToOne(inversedBy: 'followUp')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Veterinary $veterinary = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContactName(): ?string
    {
        return $this->contactName;
    }

    public function setContactName(string $contactName): static
    {
        $this->contactName = $contactName;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getCallDate(): ?\DateTimeInterface
    {
        return $this->callDate;
    }

    public function setCallDate(\DateTimeInterface $callDate): static
    {
        $this->callDate = $callDate;

        return $this;
    }

    public function getVeterinary(): ?Veterinary
    {
        return $this->veterinary;
    }

    public function setVeterinary(?Veterinary $veterinary): static
    {
        $this->veterinary = $veterinary;

        return $this;
    }
}
