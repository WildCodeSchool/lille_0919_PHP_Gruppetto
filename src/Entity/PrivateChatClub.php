<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PrivateChatClubRepository")
 */
class PrivateChatClub
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateMessage;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ProfilClub", inversedBy="privateChatClub", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $profilClub;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ProfilSolo", inversedBy="privateChatClub", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $profilSolo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
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

    public function setProfilSolo(ProfilSolo $profilSolo): self
    {
        $this->profilSolo = $profilSolo;

        return $this;
    }
}
