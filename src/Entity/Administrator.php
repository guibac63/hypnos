<?php

namespace App\Entity;

use App\Repository\AdministratorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdministratorRepository::class)]
class Administrator
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToMany(mappedBy: 'admin', targetEntity: Etablissement::class)]
    private $etablissements;

    #[ORM\OneToOne(inversedBy: 'administrator', targetEntity: User::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $MainUser;

    #[ORM\OneToMany(mappedBy: 'admin', targetEntity: Manager::class, orphanRemoval: true)]
    private $managers;

    public function __construct()
    {
        $this->etablissements = new ArrayCollection();
        $this->managers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Etablissement>
     */
    public function getEtablissements(): Collection
    {
        return $this->etablissements;
    }

    public function addEtablissement(Etablissement $etablissement): self
    {
        if (!$this->etablissements->contains($etablissement)) {
            $this->etablissements[] = $etablissement;
            $etablissement->setAdmin($this);
        }

        return $this;
    }

    public function removeEtablissement(Etablissement $etablissement): self
    {
        if ($this->etablissements->removeElement($etablissement)) {
            // set the owning side to null (unless already changed)
            if ($etablissement->getAdmin() === $this) {
                $etablissement->setAdmin(null);
            }
        }

        return $this;
    }

    public function getMainUser(): ?User
    {
        return $this->MainUser;
    }

    public function setMainUser(User $MainUser): self
    {
        $this->MainUser = $MainUser;

        return $this;
    }



    /**
     * @return Collection<int, Manager>
     */
    public function getManagers(): Collection
    {
        return $this->managers;
    }

    public function addManager(Manager $manager): self
    {
        if (!$this->managers->contains($manager)) {
            $this->managers[] = $manager;
            $manager->setAdmin($this);
        }

        return $this;
    }

    public function removeManager(Manager $manager): self
    {
        if ($this->managers->removeElement($manager)) {
            // set the owning side to null (unless already changed)
            if ($manager->getAdmin() === $this) {
                $manager->setAdmin(null);
            }
        }

        return $this;
    }
}
