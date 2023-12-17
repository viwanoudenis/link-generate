<?php

namespace App\Entity;

use App\Repository\AttesstationContentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AttesstationContentRepository::class)]
class AttesstationContent
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text', nullable: true)]
    private $text;

    #[ORM\Column(type: 'array', nullable: true)]
    private $style = [];

    #[ORM\Column(type: 'integer', nullable: true)]
    private $priority;

    #[ORM\ManyToOne(targetEntity: Attesstation::class, inversedBy: 'attesstationContents')]
    private $attestation;

    #[ORM\Column(type: 'text', nullable: true)]
    private $font_style;

    #[ORM\Column(type: 'text', nullable: true)]
    private $modules;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $labelle;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getStyle(): ?array
    {
        return $this->style;
    }

    public function setStyle(?array $style): self
    {
        $this->style = $style;

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(?int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getAttestation(): ?Attesstation
    {
        return $this->attestation;
    }

    public function setAttestation(?Attesstation $attestation): self
    {
        $this->attestation = $attestation;

        return $this;
    }

    public function getFontStyle(): ?string
    {
        return $this->font_style;
    }

    public function setFontStyle(?string $font_style): self
    {
        $this->font_style = $font_style;

        return $this;
    }

    public function getModules(): ?string
    {
        return $this->modules;
    }

    public function setModules(?string $modules): self
    {
        $this->modules = $modules;

        return $this;
    }

    public function getLabelle(): ?string
    {
        return $this->labelle;
    }

    public function setLabelle(?string $labelle): self
    {
        $this->labelle = $labelle;

        return $this;
    }
}
