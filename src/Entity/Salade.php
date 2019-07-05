<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Controller\CreateSaladeBase;

/**
 * @ApiResource(
 *     itemOperations={
 *          "get",
 *          "post_base"={
 *              "method"="POST",
 *              "path"="/salades/{id}/base",
 *              "controller"=CreateSaladeBase::class,
 *          }
 *     },
 *     normalizationContext={"groups"={"salade"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\SaladeRepository")
 */
class Salade
{
    /**
     * @Groups({"salade"})
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"salade"})
     * @ORM\ManyToOne(targetEntity="App\Entity\Base", inversedBy="salades")
     */
    private $base;

    /**
     * @Groups({"salade"})
     * @ORM\ManyToMany(targetEntity="App\Entity\Ingredient", inversedBy="salades")
     */
    private $ingredients;

    /**
     * @Groups({"salade"})
     * @ORM\ManyToOne(targetEntity="App\Entity\Sauce", inversedBy="salades")
     */
    private $sauce;

    /**
     * @Groups({"salade"})
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;


    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    public function __toString() {
		return 'Salade';
    }

	public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getBase(): ?Base
    {
        return $this->base;
    }

    public function setBase(?Base $base): self
    {
        $this->base = $base;

        return $this;
    }

    /**
     * @return Collection|Ingredient[]
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredient $ingredient): self
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients[] = $ingredient;
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): self
    {
        if ($this->ingredients->contains($ingredient)) {
            $this->ingredients->removeElement($ingredient);
        }

        return $this;
    }

    public function getSauce(): ?Sauce
    {
        return $this->sauce;
    }

    public function setSauce(?Sauce $sauce): self
    {
        $this->sauce = $sauce;

        return $this;
    }
}
