<?php

namespace App\Entity;

use App\Repository\InterventionUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InterventionUserRepository::class)]
class InterventionUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Intervention $intervention = null;

    #[ORM\OneToMany(mappedBy: 'interventionUser', targetEntity: User::class)]
    private Collection $user;

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntervention(): ?Intervention
    {
        return $this->intervention;
    }

    public function setIntervention(Intervention $intervention): self
    {
        $this->intervention = $intervention;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
            $user->setInterventionUser($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->user->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getInterventionUser() === $this) {
                $user->setInterventionUser(null);
            }
        }

        return $this;
    }
}
