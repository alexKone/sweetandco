<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ApiResource(normalizationContext={"groups"={"category"}})
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"category"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"category"})
     */
    private $name;

	/**
	 * @var string
	 * @Gedmo\Slug(fields={"name", "id"})
	 * @ORM\Column(type="string", nullable=false)
	 * @Groups({"category"})
	 */
    private $slug;

	/**
	 * @var int
	 * @ORM\Column(type="smallint")
	 */
    private $position;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="category")
     * @Groups({"category"})
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
//	    $slugify = new Slugify();
//	    $this->slug = $slugify->slugify($this->name . $this->id);
    }

	public function __toString() {
                     		return $this->getName();
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
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getCategory() === $this) {
                $product->setCategory(null);
            }
        }

        return $this;
    }

	/**
	 * @return mixed
	 */
	public function getSlug() {
      		return $this->slug;
      	}

	/**
	 * @param mixed $slug
	 *
	 * @return Category
	 */
	public function setSlug( $slug ) {
      		$this->slug = $slug;
      		return $this;
      	}

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }
}
