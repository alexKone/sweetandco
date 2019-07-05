<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(normalizationContext={"groups"={"sauce"}})
 * @ORM\Entity(repositoryClass="App\Repository\SauceRepository")
 */
class Sauce
{
    /**
     * @Groups({"sauce"})
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"sauce", "salade"})
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Salade", mappedBy="sauce")
     */
    private $salades;

    public function __construct()
    {
        $this->salades = new ArrayCollection();
    }

	public function __toString(  ) {
		return $this->name;
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
            $salade->setSauce($this);
        }

        return $this;
    }

    public function removeSalade(Salade $salade): self
    {
        if ($this->salades->contains($salade)) {
            $this->salades->removeElement($salade);
            // set the owning side to null (unless already changed)
            if ($salade->getSauce() === $this) {
                $salade->setSauce(null);
            }
        }

        return $this;
    }
}
