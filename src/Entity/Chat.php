<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ChatRepository")
 */
class Chat
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
    private $contentMessage;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateMessage;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ProfilSolo", inversedBy="chat", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $profilSolo;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Friend", inversedBy="chat", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $friend;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContentMessage(): ?string
    {
        return $this->contentMessage;
    }

    public function setContentMessage(string $contentMessage): self
    {
        $this->contentMessage = $contentMessage;

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

    public function getProfilSolo(): ?ProfilSolo
    {
        return $this->profilSolo;
    }

    public function setProfilSolo(ProfilSolo $profilSolo): self
    {
        $this->profilSolo = $profilSolo;

        return $this;
    }

    public function getFriend(): ?Friend
    {
        return $this->friend;
    }

    public function setFriend(Friend $friend): self
    {
        $this->friend = $friend;

        return $this;
    }
}
