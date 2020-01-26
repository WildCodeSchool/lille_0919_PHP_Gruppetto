<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
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
    private $nameEvent;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $levelEvent;

    /**
     * @ORM\Column(type="date")
     */
    private $dateEvent;

    /**
     * @ORM\Column(type="time")
     */
    private $timeEvent;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $participantLimit;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $placeEvent;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Sport", inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sport;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="event")
     */
    private $comments;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProfilSolo", inversedBy="events")
     */
    private $creatorSolo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProfilClub", inversedBy="events")
     */
    private $creatorClub;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RegistrationEvent", mappedBy="event")
     */
    private $registrationEvent;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Booking", mappedBy="events")
     */
    private $bookings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ParticipationLike", mappedBy="event")
     */
    private $participationLikes;

    public function __construct()
    {
        $this->participationLikes = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->registrationEvent = new ArrayCollection();
        $this->bookings = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameEvent(): ?string
    {
        return $this->nameEvent;
    }

    public function setNameEvent(?string $nameEvent): ?self
    {
        $this->nameEvent = $nameEvent;

        return $this;
    }

    public function getLevelEvent(): ?int
    {
        return $this->levelEvent;
    }

    public function setLevelEvent(?int $levelEvent): self
    {
        $this->levelEvent = $levelEvent;

        return $this;
    }

    public function getDateEvent(): ?\DateTimeInterface
    {
        return $this->dateEvent;
    }

    public function setDateEvent(\DateTimeInterface $dateEvent): self
    {
        $this->dateEvent = $dateEvent;

        return $this;
    }

    public function getTimeEvent(): ?\DateTimeInterface
    {
        return $this->timeEvent;
    }

    public function setTimeEvent(\DateTimeInterface $timeEvent): self
    {
        $this->timeEvent = $timeEvent;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getParticipantLimit(): ?int
    {
        return $this->participantLimit;
    }

    public function setParticipantLimit(?int $participantLimit): self
    {
        $this->participantLimit = $participantLimit;

        return $this;
    }

    public function getPlaceEvent()
    {
        return $this->placeEvent;
    }

    public function setPlaceEvent(?string $placeEvent): self
    {
        $this->placeEvent = $placeEvent;

        return $this;
    }

    public function getSport(): ?Sport
    {
        return $this->sport;
    }

    public function setSport(?Sport $sport): self
    {
        $this->sport = $sport;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setEvent($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getEvent() === $this) {
                $comment->setEvent(null);
            }
        }

        return $this;
    }

    public function getCreatorSolo(): ?ProfilSolo
    {
        return $this->creatorSolo;
    }

    public function setCreatorSolo(?ProfilSolo $creatorSolo): self
    {
        $this->creatorSolo = $creatorSolo;

        return $this;
    }

    public function getCreatorClub(): ?ProfilClub
    {
        return $this->creatorClub;
    }

    public function setCreatorClub(?ProfilClub $creatorClub): self
    {
        $this->creatorClub = $creatorClub;

        return $this;
    }

    /**
     * @return Collection|RegistrationEvent[]
     */
    public function getRegistrationEvent(): Collection
    {
        return $this->registrationEvent;
    }

    public function addRegistrationEvent(RegistrationEvent $registrationEvent): self
    {
        if (!$this->registrationEvent->contains($registrationEvent)) {
            $this->registrationEvent[] = $registrationEvent;
            $registrationEvent->setEvent($this);
        }

        return $this;
    }

    public function removeRegistrationEvent(RegistrationEvent $registrationEvent): self
    {
        if ($this->registrationEvent->contains($registrationEvent)) {
            $this->registrationEvent->removeElement($registrationEvent);
            // set the owning side to null (unless already changed)
            if ($registrationEvent->getEvent() === $this) {
                $registrationEvent->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Booking[]
     */
    public function getBooking(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->addEvent($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->contains($booking)) {
            $this->bookings->removeElement($booking);
            $booking->removeEvent($this);
        }

        return $this;
    }

    /**
     * @return Collection|ParticipationLike[]
     */
    public function getParticipationLikes(): Collection
    {
        return $this->participationLikes;
    }

    public function addParticipationLike(ParticipationLike $participationLike): self
    {
        if (!$this->participationLikes->contains($participationLike)) {
            $this->participationLikes[] = $participationLike;
            $participationLike->setEvent($this);
        }

        return $this;
    }

    public function removeParticipationLike(ParticipationLike $participationLike): self
    {
        if ($this->participationLikes->contains($participationLike)) {
            $this->participationLikes->removeElement($participationLike);
            // set the owning side to null (unless already changed)
            if ($participationLike->getEvent() === $this) {
                $participationLike->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * Lets you know if the user is participating
     * @param User $user
     * @return bool
     */
    public function isParticipationByUser(User $user) : bool
    {
        foreach ($this->participationLikes as $participationLike) {
            if ($participationLike->getUser() === $user) {
                return true;
            }
        }
            return false;
    }
}
