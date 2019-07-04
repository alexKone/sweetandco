<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BaseRepository")
 */
class Base
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
     * @ORM\OneToMany(targetEntity="App\Entity\Salade", mappedBy="base")
     */
    private $salades;

    public function __construct()
    {
        $this->salades = new ArrayCollection();
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

    /**
     * @return Collection|Salade[]
     */
    public function getSalades(): Collection
    {
        return $this->salades;
    }

    public function addSalade(Salade $salade): self
    {
        if (!$this->salades->contains($salade)) {
            $this->salades[] = $salade;
            $salade->setBase($this);
        }

        return $this;
    }

    public function removeSalade(Salade $salade): self
    {
        if ($this->salades->contains($salade)) {
            $this->salades->removeElement($salade);
            // set the owning side to null (unless already changed)
            if ($salade->getBase() === $this) {
                $salade->setBase(null);
            }
        }

        return $this;
    }
}
