<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(normalizationContext={"groups"="billing"})
 * @ORM\Entity(repositoryClass="App\Repository\BillingRepository")
 */
class Billing
{
    /**
     * @Groups({"billing"})
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"billing"})
     * @ORM\OneToMany(targetEntity="App\Entity\Salade", mappedBy="billing", cascade={"persist", "remove"})
     */
    private $salade;

    /**
     * @Groups({"billing"})
     * @ORM\ManyToMany(targetEntity="App\Entity\Formule", inversedBy="billings")
     */
    private $formules;

    /**
     * @Groups({"billing"})
     * @ORM\Column(type="string", length=255)
     */
    private $paymentMethod;

    /**
     * @Groups({"billing"})
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Groups({"billing"})
     * @ORM\Column(type="float")
     */
    private $totalPrice;

    /**
     * @Groups({"billing"})
     * @ORM\Column(type="text")
     */
    private $billingAddress;

    /**
     * @Groups({"billing"})
     * @ORM\Column(type="string", length=255)
     */
    private $billingCity;

    /**
     * @Groups({"billing"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $billingZipcode;

    /**
     * @Groups({"billing"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $deliveryMethod;

    /**
     * @Groups({"billing"})
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pickupHour;

    /**
     * @Groups({"billing"})
     * @ORM\ManyToMany(targetEntity="App\Entity\Boisson", inversedBy="billings")
     */
    private $boissons;

    /**
     * @Groups({"billing"})
     * @ORM\ManyToMany(targetEntity="App\Entity\Dessert", inversedBy="billings")
     */
    private $dessert;

    public function __construct()
    {
    	$this->createdAt = new \DateTime();
        $this->salade = new ArrayCollection();
        $this->formules = new ArrayCollection();
        $this->boissons = new ArrayCollection();
        $this->dessert = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Salade[]
     */
    public function getSalade(): Collection
    {
        return $this->salade;
    }

    public function addSalade(Salade $salade): self
    {
        if (!$this->salade->contains($salade)) {
            $this->salade[] = $salade;
            $salade->setBilling($this);
        }

        return $this;
    }

    public function removeSalade(Salade $salade): self
    {
        if ($this->salade->contains($salade)) {
            $this->salade->removeElement($salade);
            // set the owning side to null (unless already changed)
            if ($salade->getBilling() === $this) {
                $salade->setBilling(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Formule[]
     */
    public function getFormules(): Collection
    {
        return $this->formules;
    }

    public function addFormule(Formule $formule): self
    {
        if (!$this->formules->contains($formule)) {
            $this->formules[] = $formule;
        }

        return $this;
    }

    public function removeFormule(Formule $formule): self
    {
        if ($this->formules->contains($formule)) {
            $this->formules->removeElement($formule);
        }

        return $this;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(string $paymentMethod): self
    {
        $this->paymentMethod = $paymentMethod;

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

    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(float $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getBillingAddress(): ?string
    {
        return $this->billingAddress;
    }

    public function setBillingAddress(string $billingAddress): self
    {
        $this->billingAddress = $billingAddress;

        return $this;
    }

    public function getBillingCity(): ?string
    {
        return $this->billingCity;
    }

    public function setBillingCity(string $billingCity): self
    {
        $this->billingCity = $billingCity;

        return $this;
    }

    public function getBillingZipcode(): ?string
    {
        return $this->billingZipcode;
    }

    public function setBillingZipcode(?string $billingZipcode): self
    {
        $this->billingZipcode = $billingZipcode;

        return $this;
    }

    public function getDeliveryMethod(): ?string
    {
        return $this->deliveryMethod;
    }

    public function setDeliveryMethod(?string $deliveryMethod): self
    {
        $this->deliveryMethod = $deliveryMethod;

        return $this;
    }

    public function getPickupHour(): ?string
    {
        return $this->pickupHour;
    }

    public function setPickupHour(string $pickupHour): self
    {
        $this->pickupHour = $pickupHour;

        return $this;
    }

    /**
     * @return Collection|Boisson[]
     */
    public function getBoissons(): Collection
    {
        return $this->boissons;
    }

    public function addBoisson(Boisson $boisson): self
    {
        if (!$this->boissons->contains($boisson)) {
            $this->boissons[] = $boisson;
        }

        return $this;
    }

    public function removeBoisson(Boisson $boisson): self
    {
        if ($this->boissons->contains($boisson)) {
            $this->boissons->removeElement($boisson);
        }

        return $this;
    }

    /**
     * @return Collection|Dessert[]
     */
    public function getDessert(): Collection
    {
        return $this->dessert;
    }

    public function addDessert(Dessert $dessert): self
    {
        if (!$this->dessert->contains($dessert)) {
            $this->dessert[] = $dessert;
        }

        return $this;
    }

    public function removeDessert(Dessert $dessert): self
    {
        if ($this->dessert->contains($dessert)) {
            $this->dessert->removeElement($dessert);
        }

        return $this;
    }
}
