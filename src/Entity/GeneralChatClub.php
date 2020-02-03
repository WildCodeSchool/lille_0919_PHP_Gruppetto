<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GeneralChatClubRepository")
 */
class GeneralChatClub
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateMessage;

    /**
     * @ORM\Column(type="text")
     */
    private $contentMessage;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProfilClub", inversedBy="generalChatClub", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $profilClub;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProfilSolo", inversedBy="generalChatClub")
     */
    private $profilSolo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateMessage(): ?\DateTimeInterface
    {
        return $this->dateMessage;
    }

    public function setDateMessage(\DateTimeInterface $dateMessage): self
    {
        $this->dateMessage = $dateMessage;

        return $this;
    }

    public function getContentMessage(): ?string
    {
        return $this->contentMessage;
    }

    public function setContentMessage(?string $contentMessage): self
    {
        $this->contentMessage = $contentMessage;

        return $this;
    }

    public function getProfilClub(): ?ProfilClub
    {
        return $this->profilClub;
    }

    public function setProfilClub(ProfilClub $profilClub): self
    {
        $this->profilClub = $profilClub;

        return $this;
    }
    public function getProfilSolo(): ?ProfilSolo
    {
        return $this->profilSolo;
    }

    public function setProfilSolo(?ProfilSolo $profilSolo): self
    {
        $this->profilSolo = $profilSolo;

        return $this;
    }
}
