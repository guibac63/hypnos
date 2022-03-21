<?php

namespace App\Entity;

use App\Repository\GalleryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GalleryRepository::class)]
class Gallery
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $file;

    #[ORM\ManyToOne(targetEntity: Suite::class, inversedBy: 'galleries')]
    #[ORM\JoinColumn(nullable: false)]
    private $suite_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(string $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getSuiteId(): ?Suite
    {
        return $this->suite_id;
    }

    public function setSuiteId(?Suite $suite_id): self
    {
        $this->suite_id = $suite_id;

        return $this;
    }
}
