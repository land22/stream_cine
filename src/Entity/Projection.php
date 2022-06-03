<?php

namespace App\Entity;

use App\Repository\ProjectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Cinema;
use App\Entity\Video;
use App\Entity\User;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectionRepository::class)]
class Projection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $heureProjection;

    #[ORM\ManyToOne(targetEntity: video::class, inversedBy: 'projections')]
    private $video;

    #[ORM\ManyToOne(targetEntity: cinema::class, inversedBy: 'projections')]
    private $cinema;

    #[ORM\ManyToOne(targetEntity: user::class, inversedBy: 'projections')]
    private $user;

    #[ORM\OneToMany(mappedBy: 'projection', targetEntity: Reservation::class)]
    private $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHeureProjection(): ?\DateTimeInterface
    {
        return $this->heureProjection;
    }

    public function setHeureProjection(\DateTimeInterface $heureProjection): self
    {
        $this->heureProjection = $heureProjection;

        return $this;
    }

    public function getVideo(): ?video
    {
        return $this->video;
    }

    public function setVideo(?video $video): self
    {
        $this->video = $video;

        return $this;
    }

    public function getCinema(): ?cinema
    {
        return $this->cinema;
    }

    public function setCinema(?cinema $cinema): self
    {
        $this->cinema = $cinema;

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
            $reservation->setProjection($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getProjection() === $this) {
                $reservation->setProjection(null);
            }
        }

        return $this;
    }
}
