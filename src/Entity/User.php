<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ProfilSolo", inversedBy="user", cascade={"persist", "remove"})
     */
    private $profilSolo;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ProfilClub", inversedBy="users")
     * @ORM\JoinTable(name="user_profil_club")
     */
    private $profilClubs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ParticipationLike", mappedBy="user")
     */
    private $participationLikes;

    public function __construct()
    {
        $this->profilClubs = new ArrayCollection();
        $this->participationLikes = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }


    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }
    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        // $roles[] = 'ROLE_REGISTERED';
        return array_unique($roles);
    }


    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

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
        }

        return $this;
    }

    public function removeProfilClub(ProfilClub $profilClub): self
    {
        if ($this->profilClubs->contains($profilClub)) {
            $this->profilClubs->removeElement($profilClub);
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
            $participationLike->setUser($this);
        }

        return $this;
    }

    public function removeParticipationLike(ParticipationLike $participationLike): self
    {
        if ($this->participationLikes->contains($participationLike)) {
            $this->participationLikes->removeElement($participationLike);
            // set the owning side to null (unless already changed)
            if ($participationLike->getUser() === $this) {
                $participationLike->setUser(null);
            }
        }

        return $this;
    }
}
