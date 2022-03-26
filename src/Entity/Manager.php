<?php

namespace App\Entity;

use App\Repository\ManagerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ManagerRepository::class)]
class Manager
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToOne(mappedBy: 'manager', targetEntity: Etablissement::class, cascade: ['persist', 'remove'])]
    private $etablissement;

    #[ORM\OneToMany(mappedBy: 'manager', targetEntity: Suite::class)]
    private $suites;

    #[ORM\OneToOne(inversedBy: 'manager', targetEntity: User::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $MainUser;

    #[ORM\ManyToOne(targetEntity: Administrator::class, inversedBy: 'managers')]
    #[ORM\JoinColumn(nullable: false)]
    private $admin;

    public function __construct()
    {
        $this->suites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtablissement(): ?Etablissement
    {
        return $this->etablissement;
    }

    public function setEtablissement(Etablissement $etablissement): self
    {
        // set the owning side of the relation if necessary
        if ($etablissement->getManager() !== $this) {
            $etablissement->setManager($this);
        }

        $this->etablissement = $etablissement;

        return $this;
    }

    /**
     * @return Collection<int, Suite>
     */
    public function getSuites(): Collection
    {
        return $this->suites;
    }

    public function addSuite(Suite $suite): self
    {
        if (!$this->suites->contains($suite)) {
            $this->suites[] = $suite;
            $suite->setManager($this);
        }

        return $this;
    }

    public function removeSuite(Suite $suite): self
    {
        if ($this->suites->removeElement($suite)) {
            // set the owning side to null (unless already changed)
            if ($suite->getManager() === $this) {
                $suite->setManager(null);
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

    public function getAdmin(): ?Administrator
    {
        return $this->admin;
    }

    public function setAdmin(?Administrator $admin): self
    {
        $this->admin = $admin;

        return $this;
    }

    public function __toString()
    {
        return ($this->getMainUser()->getFirstName().' '.$this->getMainUser()->getLastName());
    }
}
