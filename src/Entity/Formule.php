<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Controller\FormuleCollectionController;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ApiResource(normalizationContext={"groups"={"formule"}})
 * @ApiFilter(BooleanFilter::class, properties={"has_bagel", "has_panini", "has_boisson", "has_dessert"})
 * @ORM\Entity(repositoryClass="App\Repository\FormuleRepository")
 * @Vich\Uploadable()
 */
class Formule {
	/**
	 * @ORM\Id()
	 * @ORM\GeneratedValue()
	 * @ORM\Column(type="integer")
	 * @Groups({"formule"})
	 */
	private $id;

	/**
	 * @ORM\Column(type="string", length=255)
	 * @ORM\OrderBy({"order"=""})
	 * @Groups({"formule"})
	 */
	private $name;

	/**
	 * @ORM\Column(type="text", nullable=true)
	 * @Groups({"formule"})
	 */
	private $description;

	/**
	 * @ORM\Column(type="string", length=255, nullable=true)
	 * @Groups({"formule"})
	 */
	private $short_description;

	/**
	 * @ORM\Column(type="integer")
	 * @Groups({"formule"})
	 */
	private $limit_base = 1;

	/**
	 * @ORM\Column(type="integer")
	 * @Groups({"formule"})
	 */
	private $limit_ingredient = 4;

	/**
	 * @ORM\Column(type="integer")
	 * @Groups({"formule"})
	 */
	private $limit_sauce = 1;

	/**
	 * @ORM\Column(type="boolean")
	 * @Groups({"formule"})
	 */
	private $has_bagel = false;

	/**
	 * @ORM\Column(type="boolean")
	 * @Groups({"formule"})
	 */
	private $has_panini = false;

	/**
	 * @var string|null
	 * @Groups({"formule"})
	 * @ORM\Column(type="string", length=255, nullable=true, name="formule_filename")
	 */
	private $formuleFilename;

	/**
	 * @var File|null
	 * @Vich\UploadableField(mapping="products", fileNameProperty="formuleFilename")
	 */
	private $imageFile;

	/**
	 * @var
	 * @ORM\Column(type="datetime")
	 * @Groups({"formule"})
	 */
	private $createdAt;

	/**
	 * @var
	 * @ORM\Column(type="datetime", nullable=true)
	 * @Groups({"formule"})
	 */
	private $updatedAt;

	/**
	 * @ORM\Column(type="float")
	 * @Groups({"formule"})
	 */
	private $price;

	/**
	 * @Gedmo\Slug(fields={"name","id"})
	 * @ORM\Column(type="string", length=255, nullable=false)
	 * @Groups({"formule"})
	 */
	private $slug;

	/**
	 * @ORM\ManyToMany(targetEntity="App\Entity\Order", mappedBy="formules")
	 */
	private $orders;

	/**
	 * @Groups({"formule"})
	 * @ORM\Column(type="boolean", nullable=true, options={"default": false})
	 */
	private $has_boisson = false;

	/**
	 * @Groups({"formule"})
	 * @ORM\Column(type="boolean", nullable=true)
	 */
	private $has_dessert = false;


	public function __construct() {
                     		$this->createdAt = new DateTime();
                     		$this->orders    = new ArrayCollection();
                     	}

	public function getId(): ?int {
                     		return $this->id;
                     	}

	public function getName(): ?string {
                     		return $this->name;
                     	}

	public function setName( string $name ): self {
                     		$this->name = $name;

                     		return $this;
                     	}

	public function getDescription(): ?string {
                     		return $this->description;
                     	}

	public function setDescription( ?string $description ): self {
                     		$this->description = $description;

                     		return $this;
                     	}

	public function getShortDescription(): ?string {
                     		return $this->short_description;
                     	}

	public function setShortDescription( ?string $short_description ): self {
                     		$this->short_description = $short_description;

                     		return $this;
                     	}

	public function getLimitBase(): ?int {
                     		return $this->limit_base;
                     	}

	public function setLimitBase( int $limit_base ): self {
                     		$this->limit_base = $limit_base;

                     		return $this;
                     	}

	public function getLimitIngredient(): ?int {
                     		return $this->limit_ingredient;
                     	}

	public function setLimitIngredient( int $limit_ingredient ): self {
                     		$this->limit_ingredient = $limit_ingredient;

                     		return $this;
                     	}

	public function getLimitSauce(): ?int {
                     		return $this->limit_sauce;
                     	}

	public function setLimitSauce( int $limit_sauce ): self {
                     		$this->limit_sauce = $limit_sauce;

                     		return $this;
                     	}

	public function getHasBagel(): ?bool {
                     		return $this->has_bagel;
                     	}

	public function setHasBagel( bool $has_bagel ): self {
                     		$this->has_bagel = $has_bagel;

                     		return $this;
                     	}

	public function getHasPanini(): ?bool {
                     		return $this->has_panini;
                     	}

	public function setHasPanini( bool $has_panini ): self {
                     		$this->has_panini = $has_panini;

                     		return $this;
                     	}


	/**
	 * @return string|null
	 */
	public function getFormuleFilename(): ?string {
                     		return $this->formuleFilename;
                     	}

	/**
	 * @param string|null $filename
	 *
	 * @return Formule
	 */
	public function setFormuleFilename( ?string $filename ) {
                     		$this->formuleFilename = $filename;

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
	 * @return void
	 * @throws \Exception
	 */
	public function setImageFile( ?File $imageFile = null ): void {
                     		$this->imageFile = $imageFile;
                     		if ( $imageFile ) {
                     			$this->updatedAt = new \DateTime( 'now' );
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
	 * @return Formule
	 */
	public function setUpdatedAt( $updatedAt ) {
                     		$this->updatedAt = $updatedAt;

                     		return $this;
                     	}

	public function getCreatedAt(): ?\DateTimeInterface {
                     		return $this->createdAt;
                     	}

	public function setCreatedAt( \DateTimeInterface $createdAt ): self {
                     		$this->createdAt = $createdAt;

                     		return $this;
                     	}

	public function getPrice(): ?float {
                     		return $this->price;
                     	}

	public function setPrice( float $price ): self {
                     		$this->price = $price;

                     		return $this;
                     	}

	public function getSlug(): ?string {
                     		return $this->slug;
                     	}

	public function setSlug( ?string $slug ): self {
                     		$this->slug = $slug;

                     		return $this;
                     	}

	/**
	 * @return Collection|Order[]
	 */
	public function getOrders(): Collection {
                     		return $this->orders;
                     	}

	public function addOrder( Order $order ): self {
                     		if ( ! $this->orders->contains( $order ) ) {
                     			$this->orders[] = $order;
                     			$order->addFormule( $this );
                     		}

                     		return $this;
                     	}

	public function removeOrder( Order $order ): self {
                     		if ( $this->orders->contains( $order ) ) {
                     			$this->orders->removeElement( $order );
                     			$order->removeFormule( $this );
                     		}

                     		return $this;
                     	}

    public function getHasBoisson(): ?bool
    {
        return $this->has_boisson;
    }

    public function setHasBoisson(?bool $has_boisson): self
    {
        $this->has_boisson = $has_boisson;

        return $this;
    }

    public function getHasDessert(): ?bool
    {
        return $this->has_dessert;
    }

    public function setHasDessert(?bool $has_dessert): self
    {
        $this->has_dessert = $has_dessert;

        return $this;
    }
}
