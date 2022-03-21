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

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'managers')]
    #[ORM\JoinColumn(nullable: false)]
    private $user_id;

    #[ORM\ManyToOne(targetEntity: Administrator::class, inversedBy: 'managers')]
    #[ORM\JoinColumn(nullable: false)]
    private $admin_id;

    #[ORM\OneToOne(mappedBy: 'manager_id', targetEntity: Etablissement::class, cascade: ['persist', 'remove'])]
    private $etablissement;

    #[ORM\OneToMany(mappedBy: 'manager_id', targetEntity: Suite::class)]
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
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getAdminId(): ?Administrator
    {
        return $this->admin_id;
    }

    public function setAdminId(?Administrator $admin_id): self
    {
        $this->admin_id = $admin_id;

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
