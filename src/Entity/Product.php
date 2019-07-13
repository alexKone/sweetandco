<?php

namespace App\Entity;

use App\Service\Handler;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @Vich\Uploadable()
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"category"})
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"category"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"category"})
     */
    private $short_description;

    /**
     * @ORM\Column(type="float")
     * @Groups({"category"})
     */
    private $price;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"category"})
     */
    private $is_active;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

	/**
	 * @var
	 * @ORM\Column(type="string", nullable=false)
	 * @Groups({"category"})
	 */
    private $slug;

	/**
	 * @Groups({"base", "salade"})
	 * @var string|null
	 * @ORM\Column(type="string", length=255, nullable=true)
	 */
	private $filename;

	/**
	 * @var File|null
	 * @Vich\UploadableField(mapping="products", fileNameProperty="filename")
	 */
	private $imageFile;

	/**
	 * @var
	 * @ORM\Column(type="datetime", nullable=true)
	 * @Groups({"base"})
	 */
	private $updatedAt;
    /**
     * @ORM\Column(type="datetime")
     * @Groups({"category"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $stock_qty;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Order", mappedBy="products")
     */
    private $orders;

    public function __construct() {
        $this->createdAt = new \DateTime();
        $slugify = new Slugify();
	    $this->slug = $slugify->slugify($this->name . $this->id);
     $this->orders = new ArrayCollection();
    }

    public function __toString() {
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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): self
    {
        $this->is_active = $is_active;

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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

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
	 * @return Product
	 */
	public function setSlug( $slug ) {
                              		$this->slug = $slug;
                              
                              		return $this;
                              	}

	/**
	 * @return string|null
	 */
	public function getFilename(): ?string {
                              		return $this->filename;
                              	}

	/**
	 * @param string|null $filename
	 *
	 * @return Base
	 */
	public function setFilename( ?string $filename ) {
                              		$this->filename = $filename;
                              
                              		return $this;
                              	}

	/**
	 * @return File|null
	 */
	public function getImageFile(): ?File {
                              		return $this->imageFile;
                              	}

	/**
	 * @param File|null $imageFile
	 *
	 * @return Base
	 * @throws \Exception
	 */
	public function setImageFile( ?File $imageFile = null ): void {
                              		$this->imageFile = $imageFile;
                              		if ($imageFile) {
                              			$this->updatedAt = new \DateTime('now');
                              		}
                              	}

	/**
	 * @return mixed
	 */
	public function getUpdatedAt() {
                              		return $this->updatedAt;
                              	}

	/**
	 * @param mixed $updatedAt
	 *
	 * @return Base
	 */
	public function setUpdatedAt( $updatedAt ) {
                              		$this->updatedAt = $updatedAt;
                              
                              		return $this;
                              	}

    public function getStockQty(): ?int
    {
        return $this->stock_qty;
    }

    public function setStockQty(?int $stock_qty): self
    {
        $this->stock_qty = $stock_qty;

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->addProduct($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
            $order->removeProduct($this);
        }

        return $this;
    }

}
