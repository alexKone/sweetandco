<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\FormuleRepository")
 */
class Formule
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $short_description;

    /**
     * @ORM\Column(type="integer")
     */
    private $limit_base = 1;

    /**
     * @ORM\Column(type="integer")
     */
    private $limit_ingredient = 4;

    /**
     * @ORM\Column(type="integer")
     */
    private $limit_sauce = 1;

    /**
     * @ORM\Column(type="boolean")
     */
    private $has_bagel = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $has_panini = false;

	/**
	 * @var
	 * @ORM\Column(type="datetime")
	 */
    private $createdAt;

    public function __construct() {
        $this->createdAt = new \DateTime();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getShortDescription(): ?string
    {
        return $this->short_description;
    }

    public function setShortDescription(?string $short_description): self
    {
        $this->short_description = $short_description;

        return $this;
    }

    public function getLimitBase(): ?int
    {
        return $this->limit_base;
    }

    public function setLimitBase(int $limit_base): self
    {
        $this->limit_base = $limit_base;

        return $this;
    }

    public function getLimitIngredient(): ?int
    {
        return $this->limit_ingredient;
    }

    public function setLimitIngredient(int $limit_ingredient): self
    {
        $this->limit_ingredient = $limit_ingredient;

        return $this;
    }

    public function getLimitSauce(): ?int
    {
        return $this->limit_sauce;
    }

    public function setLimitSauce(int $limit_sauce): self
    {
        $this->limit_sauce = $limit_sauce;

        return $this;
    }

    public function getHasBagel(): ?bool
    {
        return $this->has_bagel;
    }

    public function setHasBagel(bool $has_bagel): self
    {
        $this->has_bagel = $has_bagel;

        return $this;
    }

    public function getHasPanini(): ?bool
    {
        return $this->has_panini;
    }

    public function setHasPanini(bool $has_panini): self
    {
        $this->has_panini = $has_panini;

        return $this;
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
}
