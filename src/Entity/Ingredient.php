<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(normalizationContext={"groups"={"ingredient"}})
 * @ORM\Entity(repositoryClass="App\Repository\IngredientRepository")
 */
class Ingredient
{
    /**
     * @Groups({"ingredient"})
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"ingredient", "salade"})
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Salade", mappedBy="ingredients")
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
            $salade->addIngredient($this);
        }

        return $this;
    }

    public function removeSalade(Salade $salade): self
    {
        if ($this->salades->contains($salade)) {
            $this->salades->removeElement($salade);
            $salade->removeIngredient($this);
        }

        return $this;
    }
}
