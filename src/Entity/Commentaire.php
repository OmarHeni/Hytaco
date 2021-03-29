<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Utilisateur;

/**
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 */
class Commentaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="commentaires")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Locaux::class, inversedBy="commentaires")
     */
    private $locaux;

    /**
     * @ORM\OneToMany(targetEntity=Postlike::class, mappedBy="post")
     */
    private $likes;

    public function __construct()
    {
        $this->likes = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getUser(): ?Utilisateur
    {
        return $this->user;
    }

    public function setUser(?Utilisateur $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getLocaux(): ?Locaux
    {
        return $this->locaux;
    }

    public function setLocaux(?Locaux $locaux): self
    {
        $this->locaux = $locaux;

        return $this;
    }

    /**
     * @return Collection|Postlike[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Postlike $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setPost($this);
        }

        return $this;
    }

    public function removeLike(Postlike $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getPost() === $this) {
                $like->setPost(null);
            }
        }

        return $this;
    }
    /**
     * permet de savaoir si cet article est like par un utilisateur
     * @param Utilisateur $user
     * @return boolean
     */
    public function islikedByUser(Utilisateur $user ):bool{
        foreach ($this->likes as $like)
        {
            if ($like->getUser() == $user)
                return true;
        }
        return false;

    }

}
