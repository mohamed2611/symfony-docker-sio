<?php

namespace App\Entity;

use App\Repository\ActivityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActivityRepository::class)]
class Activity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    /**
     * @var Collection<int, Veterinary>
     */
    #[ORM\ManyToMany(targetEntity: Veterinary::class, mappedBy: 'activities')]
    private Collection $veterinaries;

    public function __construct()
    {
        $this->veterinaries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Veterinary>
     */
    public function getVeterinaries(): Collection
    {
        return $this->veterinaries;
    }

   

    public function addVeterinary(Veterinary $veterinary): static
    {
        if (!$this->veterinaries->contains($veterinary)) {
            $this->veterinaries->add($veterinary);
            $veterinary->addActivity($this);
        }

        return $this;
    }

    public function removeVeterinary(Veterinary $veterinary): static
    {
        if ($this->veterinaries->removeElement($veterinary)) {
            $veterinary->removeActivity($this);
        }

        return $this;
    }
}
