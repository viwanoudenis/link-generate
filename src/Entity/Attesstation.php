<?php

namespace App\Entity;

use App\Repository\AttesstationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AttesstationRepository::class)]
class Attesstation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\OneToMany(mappedBy: 'attestation', targetEntity: AttesstationContent::class)]
    private $attesstationContents;

    public function __construct()
    {
        $this->attesstationContents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, AttesstationContent>
     */
    public function getAttesstationContents(): Collection
    {
        return $this->attesstationContents;
    }

    public function addAttesstationContent(AttesstationContent $attesstationContent): self
    {
        if (!$this->attesstationContents->contains($attesstationContent)) {
            $this->attesstationContents[] = $attesstationContent;
            $attesstationContent->setAttestation($this);
        }

        return $this;
    }

    public function removeAttesstationContent(AttesstationContent $attesstationContent): self
    {
        if ($this->attesstationContents->removeElement($attesstationContent)) {
            // set the owning side to null (unless already changed)
            if ($attesstationContent->getAttestation() === $this) {
                $attesstationContent->setAttestation(null);
            }
        }

        return $this;
    }
}
