<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Veterinary>
     */
    #[ORM\OneToMany(targetEntity: Veterinary::class, mappedBy: 'category')]
    private Collection $veterinaries;

    public function __construct()
    {
        $this->veterinaries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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
            $veterinary->setCategory($this);
        }

        return $this;
    }

    public function removeVeterinary(Veterinary $veterinary): static
    {
        if ($this->veterinaries->removeElement($veterinary)) {
            // set the owning side to null (unless already changed)
            if ($veterinary->getCategory() === $this) {
                $veterinary->setCategory(null);
            }
        }

        return $this;
    }
}
