<?php

namespace App\Entity;

use App\Repository\CinemaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Video;
use App\Entity\User;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CinemaRepository::class)]
class Cinema
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $localisation;

    #[ORM\ManyToMany(targetEntity: video::class, inversedBy: 'cinemas')]
    private $video;

    #[ORM\OneToMany(mappedBy: 'cinema', targetEntity: Projection::class)]
    private $projections;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $image;

    #[ORM\Column(type: 'string', length: 255)]
    private $siteWeb;

    #[ORM\ManyToOne(targetEntity: user::class, inversedBy: 'cinemas')]
    private $user;

    public function __construct()
    {
        $this->video = new ArrayCollection();
        $this->projections = new ArrayCollection();
    }

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

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(?string $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }

    /**
     * @return Collection<int, video>
     */
    public function getVideo(): Collection
    {
        return $this->video;
    }

    public function addVideo(video $video): self
    {
        if (!$this->video->contains($video)) {
            $this->video[] = $video;
        }

        return $this;
    }

    public function removeVideo(video $video): self
    {
        $this->video->removeElement($video);

        return $this;
    }

    /**
     * @return Collection<int, Projection>
     */
    public function getProjections(): Collection
    {
        return $this->projections;
    }

    public function addProjection(Projection $projection): self
    {
        if (!$this->projections->contains($projection)) {
            $this->projections[] = $projection;
            $projection->setCinema($this);
        }

        return $this;
    }

    public function removeProjection(Projection $projection): self
    {
        if ($this->projections->removeElement($projection)) {
            // set the owning side to null (unless already changed)
            if ($projection->getCinema() === $this) {
                $projection->setCinema(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getSiteWeb(): ?string
    {
        return $this->siteWeb;
    }

    public function setSiteWeb(string $siteWeb): self
    {
        $this->siteWeb = $siteWeb;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }
}
