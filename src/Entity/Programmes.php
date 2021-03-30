<?php

namespace App\Entity;

use App\Repository\ProgrammesRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntityValidator;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=ProgrammesRepository::class)
 */
class Programmes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank(message="Nom obligatoire")
     */
    private $nom;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThan("today")
     */
    private $date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\NotBlank(message="Duree obligatoire")
     */
    private $duree;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Assert\NotBlank(message="Details obligatoire")
     */
    private $details;

    /**
     * @ORM\ManyToOne(targetEntity=Transporteur::class, inversedBy="programmes")
     */
    private $transporteur;

    /**
     * @ORM\OneToMany(targetEntity=Alerts::class, mappedBy="programme")
     */
    private $alerts;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(?int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(?string $details): self
    {
        $this->details = $details;

        return $this;
    }

    public function getTransporteur(): ?Transporteur
    {
        return $this->transporteur;
    }

    public function setTransporteur(?Transporteur $transporteur): self
    {
        $this->transporteur = $transporteur;

        return $this;
    }






    public function __construct()
    {
        $this->alerts = new ArrayCollection();
    }



    /**
     * @return Collection|Alerts[]
     */
    public function getAlerts(): Collection
    {
        return $this->alerts;
    }

    public function addAlert(Alerts $alert): self
    {
        if (!$this->alerts->contains($alert)) {
            $this->alerts[] = $alert;
            $alert->setProgramme($this);
        }

        return $this;
    }

    public function removeAlert(Alerts $alert): self
    {
        if ($this->alerts->removeElement($alert)) {
            // set the owning side to null (unless already changed)
            if ($alert->getProgramme() === $this) {
                $alert->setProgramme(null);
            }
        }

        return $this;
    }
}
