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

    #[ORM\ManyToOne(targetEntity: User::class,cascade: ['persist', 'remove'], inversedBy: 'managers')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\ManyToOne(targetEntity: Administrator::class, inversedBy: 'managers')]
    #[ORM\JoinColumn(nullable: false)]
    private $admin;

    #[ORM\OneToOne(mappedBy: 'manager', targetEntity: Etablissement::class, cascade: ['persist', 'remove'])]
    private $etablissement;

    #[ORM\OneToMany(mappedBy: 'manager', targetEntity: Suite::class)]
    private $suites;

    public function __construct()
    {
        $this->suites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user;
    }

    public function setUserId(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getAdminId(): ?Administrator
    {
        return $this->admin;
    }

    public function setAdminId(?Administrator $admin): self
    {
        $this->admin = $admin;

        return $this;
    }

    public function getEtablissement(): ?Etablissement
    {
        return $this->etablissement;
    }

    public function setEtablissement(Etablissement $etablissement): self
    {
        // set the owning side of the relation if necessary
        if ($etablissement->getManagerId() !== $this) {
            $etablissement->setManagerId($this);
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
            $suite->setManagerId($this);
        }

        return $this;
    }

    public function removeSuite(Suite $suite): self
    {
        if ($this->suites->removeElement($suite)) {
            // set the owning side to null (unless already changed)
            if ($suite->getManagerId() === $this) {
                $suite->setManagerId(null);
            }
        }

        return $this;
    }
}
