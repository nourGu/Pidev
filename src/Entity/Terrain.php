<?php

namespace App\Entity;

use App\Repository\TerrainRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @ORM\Entity(repositoryClass=TerrainRepository::class)
 * @Vich\Uploadable
 */
class Terrain
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("terrain")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @var string
     */
    private $imageTerrain;

    /**
     * @Vich\UploadableField(mapping="terrain_directory", fileNameProperty="imageTerrain")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=12)
     * @Assert\NotBlank(message="veuillez remplir le champs num tel")
     * @Assert\Length(
     *      min = 8,
     *      max = 8,
     *      minMessage = "The phone number must be at least {{ limit }} characters long",
     *      maxMessage = "The phone number cannot be longer than {{ limit }} characters"
     * )
     * @Groups("terrain")
     */
    private $numTel;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="veuillez remplir le champs localisation")
     */
    private $localisation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="veuillez remplir le champs description")
     * @Groups("terrain")
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\NotBlank(message="veuillez remplir le champs status")
     */
    private $status;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="veuillez entrez le prix")
     * @Assert\Positive
     * @Groups("terrain")
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity=Type::class, inversedBy="terrains")
     * @Assert\NotBlank(message="veuillez entrez le type de votre terrain")
     *
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=Reservation::class, mappedBy="terrain")
     */
    private $reservations;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $latitude;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $longitude;

    /**
     * @Vich\UploadableField(mapping="terrain_Localisation", fileNameProperty="imageLocalisation")
     * @var File
     */
    private $imageLocalisation;



    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageTerrain(): ?string
    {
        return $this->imageTerrain;
    }

    public function setImageTerrain(?string $imageTerrain): self
    {
        $this->imageTerrain = $imageTerrain;

        return $this;
    }

    public function setImageFile(File $imageTerrain = null)
    {
        $this->imageFile = $imageTerrain;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($imageTerrain) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function getNumTel(): ?string
    {
        return $this->numTel;
    }

    public function setNumTel(string $numTel): self
    {
        $this->numTel = $numTel;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setTerrain($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getTerrain() === $this) {
                $reservation->setTerrain(null);
            }
        }

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(?string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getImageLocalisation(): ?string
    {
        return $this->imageLocalisation;
    }

    public function setImageLocalisation(File $imageLocalisation = null): self
    {
        $this->localisation = $imageLocalisation;
        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($imageLocalisation) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
        return $this;
    }

}
