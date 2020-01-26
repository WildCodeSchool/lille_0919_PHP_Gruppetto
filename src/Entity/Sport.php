<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SportRepository")
 */
class Sport
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
    private $sportName;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ProfilClub", mappedBy="sports")
     */
    private $profilClubs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Event", mappedBy="sport")
     */
    private $events;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ProfilSolo", mappedBy="sport")
     */
    private $profilSolos;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SportCategory", inversedBy="sports")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sportCategory;

    public function __construct()
    {
        $this->profilClubs = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->profilSolos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSportName(): ?string
    {
        return $this->sportName;
    }

    public function setSportName(string $sportName): self
    {
        $this->sportName = $sportName;

        return $this;
    }

    /**
     * @return Collection|ProfilClub[]
     */
    public function getProfilClubs(): Collection
    {
        return $this->profilClubs;
    }

    public function addProfilClub(ProfilClub $profilClub): self
    {
        if (!$this->profilClubs->contains($profilClub)) {
            $this->profilClubs[] = $profilClub;
            $profilClub->setSport($this);
        }

        return $this;
    }

    public function removeProfilClub(ProfilClub $profilClub): self
    {
        if ($this->profilClubs->contains($profilClub)) {
            $this->profilClubs->removeElement($profilClub);
            $profilClub->removeSport($this);
        }

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->setSport($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
            // set the owning side to null (unless already changed)
            if ($event->getSport() === $this) {
                $event->setSport(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ProfilSolo[]
     */
    public function getProfilSolos(): Collection
    {
        return $this->profilSolos;
    }

    public function addProfilSolo(ProfilSolo $profilSolo): self
    {
        if (!$this->profilSolos->contains($profilSolo)) {
            $this->profilSolos[] = $profilSolo;
            $profilSolo->addSport($this);
        }

        return $this;
    }

    public function removeProfilSolo(ProfilSolo $profilSolo): self
    {
        if ($this->profilSolos->contains($profilSolo)) {
            $this->profilSolos->removeElement($profilSolo);
            $profilSolo->removeSport($this);
        }

        return $this;
    }

    public function getSportCategory(): ?SportCategory
    {
        return $this->sportCategory;
    }

    public function setSportCategory(?SportCategory $sportCategory): self
    {
        $this->sportCategory = $sportCategory;

        return $this;
    }
    public function __toString()
    {
        return $this->sportName;
    }
}
