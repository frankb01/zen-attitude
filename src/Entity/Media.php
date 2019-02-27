<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MediaRepository")
 */
class Media
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $alt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $taken_at;

    /**
     * @ORM\Column(type="string", length=175, nullable=true)
     */
    private $caption;
    
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getUrl()
    {
        return $this->url;
    }
    public function setUrl($url): self
    {
        $this->url = $url;
        return $this;
    }
    public function getAlt(): ?string
    {
        return $this->alt;
    }
    public function setAlt(?string $alt): self
    {
        $this->alt = $alt;
        return $this;
    }
    public function __toString(){
        return $this->alt;
    }

    public function getTakenAt(): ?\DateTimeInterface
    {
        return $this->taken_at;
    }

    public function setTakenAt(\DateTimeInterface $taken_at): self
    {
        $this->taken_at = $taken_at;

        return $this;
    }

    public function getCaption(): ?string
    {
        return $this->caption;
    }

    public function setCaption(string $caption): self
    {
        $this->caption = $caption;

        return $this;
    }
}