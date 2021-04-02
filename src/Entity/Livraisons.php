<?php

namespace App\Entity;

use App\Repository\LivraisonsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LivraisonsRepository::class)
 */
class Livraisons
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $datelivraison;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $adresse;

    /**
     * @ORM\ManyToOne(targetEntity=Livreurs::class, inversedBy="livraisons")
     */
    private $livreur;

    /**
     * @ORM\OneToMany(targetEntity=Commande::class, mappedBy="livraison")
     */
    private $commandes;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatelivraison(): ?\DateTimeInterface
    {
        return $this->datelivraison;
    }

    public function setDatelivraison(\DateTimeInterface $datelivraison): self
    {
        $this->datelivraison = $datelivraison;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getLivreur(): ?Livreurs
    {
        return $this->livreur;
    }

    public function setLivreur(?Livreurs $livreur): self
    {
        $this->livreur = $livreur;

        return $this;
    }

    /**
     * @return Collection|Commande[]
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setLivraison($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getLivraison() === $this) {
                $commande->setLivraison(null);
            }
        }

        return $this;
    }


}
