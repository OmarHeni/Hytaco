<?php

namespace App\Entity;

use App\Repository\AlertsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AlertsRepository::class)
 */
class Alerts
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=50)
     */
    private $localisation;

    /**
     * @ORM\Column(type="date")
     */
    private $date;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $rapport;

    /**
     * @ORM\Column(type="integer")
     */
    private $telephone;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="alerts")
     */
    private $utilisateur;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $mail;

    /**
     * @ORM\ManyToOne(targetEntity=Programmes::class, inversedBy="alerts")
     */
    private $programme;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getRapport(): ?string
    {
        return $this->rapport;
    }

    public function setRapport(string $rapport): self
    {
        $this->rapport = $rapport;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getProgramme(): ?Programmes
    {
        return $this->programme;
    }

    public function setProgramme(?Programmes $programme): self
    {
        $this->programme = $programme;

        return $this;
    }
}
