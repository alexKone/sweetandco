<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\PaniniRepository")
 * @Vich\Uploadable()
 */
class Panini
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
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Slug(fields={"name","id"})
     */
    private $slug;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

	/**
	 * @var string|null
	 * @Groups({"bagel"})
	 * @ORM\Column(type="string",length=255, nullable=true, name="filename")
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
	 */
	private $updatedAt;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

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

	public function getFilename(): ?string
	{
		return $this->filename;
	}

	public function setFilename(?string $filename): self
	{
		$this->filename = $filename;

		return $this;
	}

	/**
	 * @param File|null $imageFile
	 *
	 * @throws \Exception
	 */
	public function setImageFile( ?File $imageFile ): void {
		$this->imageFile = $imageFile;
		if ($imageFile) {
			$this->updatedAt = new \DateTime('now');
		}
	}

	/**
	 * @return File|null
	 */
	public function getImageFile(): ?File {
		return $this->imageFile;
	}

	public function getUpdatedAt(): ?\DateTimeInterface
	{
		return $this->updatedAt;
	}

	public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
	{
		$this->updatedAt = $updatedAt;

		return $this;
	}


}
