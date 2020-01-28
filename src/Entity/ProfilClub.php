<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfilClubRepository")
 */
class ProfilClub
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
    private $nameClub;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cityClub;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logoClub;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $descriptionClub;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Sport", inversedBy="profilClubs")
     */
    private $sports;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\GeneralChatClub", mappedBy="profilClub")
     */
    private $generalChatClub;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\PrivateChatClub", mappedBy="profilClub", cascade={"persist", "remove"})
     */
    private $privateChatClub;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="profilClubs")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Event", mappedBy="creatorClub")
     */
    private $events;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProfilSolo", mappedBy="profilClub", fetch="EAGER")
     */
    private $profilSolos;

    public function __construct()
    {
        $this->sports = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->profilSolos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameClub(): ?string
    {
        return $this->nameClub;
    }

    public function setNameClub(string $nameClub): self
    {
        $this->nameClub = $nameClub;

        return $this;
    }

    public function getCityClub(): ?string
    {
        return $this->cityClub;
    }

    public function setCityClub(string $cityClub): self
    {
        $this->cityClub = $cityClub;

        return $this;
    }
    /* For logo file*/

    public function getLogoClub(): ?string
    {
        return $this->logoClub;
    }

    public function setLogoClub(string $logoClub): self
    {
        $this->logoClub = $logoClub;

        return $this;
    }

    public function getDescriptionClub(): ?string
    {
        return $this->descriptionClub;
    }

    public function setDescriptionClub(?string $descriptionClub): self
    {
        $this->descriptionClub = $descriptionClub;

        return $this;
    }

    /**
     * @return Collection|Sport[]
     */
    public function getSport(): Collection
    {
        return $this->sports;
    }

    public function setSport(Sport $sports): self
    {
        if (!$this->sports->contains($sports)) {
            $this->sports[] = $sports;
        }

        return $this;
    }

    public function removeSport(Sport $sports): self
    {
        if ($this->sports->contains($sports)) {
            $this->sports->removeElement($sports);
        }

        return $this;
    }

    public function getGeneralChatClub(): ?GeneralChatClub
    {
        return $this->generalChatClub;
    }


    public function setGeneralChatClub(GeneralChatClub $generalChatClub): self
    {
        $this->generalChatClub = $generalChatClub;

        // set the owning side of the relation if necessary
        if ($generalChatClub->getProfilClub() !== $this) {
            $generalChatClub->setProfilClub($this);
        }

        return $this;
    }

    public function getPrivateChatClub(): ?PrivateChatClub
    {
        return $this->privateChatClub;
    }

    public function setPrivateChatClub(PrivateChatClub $privateChatClub): self
    {
        $this->privateChatClub = $privateChatClub;

        // set the owning side of the relation if necessary
        if ($privateChatClub->getProfilClub() !== $this) {
            $privateChatClub->setProfilClub($this);
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addProfilClub($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeProfilClub($this);
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
            $event->setCreatorClub($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
            // set the owning side to null (unless already changed)
            if ($event->getCreatorClub() === $this) {
                $event->setCreatorClub(null);
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
            $profilSolo->setProfilClub($this);
        }

        return $this;
    }

    public function removeProfilSolo(ProfilSolo $profilSolo): self
    {
        if ($this->profilSolos->contains($profilSolo)) {
            $this->profilSolos->removeElement($profilSolo);
            // set the owning side to null (unless already changed)
            if ($profilSolo->getProfilClub() === $this) {
                $profilSolo->setProfilClub(null);
            }
        }

        return $this;
    }
}
