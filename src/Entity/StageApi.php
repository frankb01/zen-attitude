<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StageApiRepository")
 */
class StageApi
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_api;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Carsharing", mappedBy="stage_api", cascade={"persist", "remove"})
     */
    private $carsharings;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $animator;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $date;

    public function __construct()
    {
        $this->carsharings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdApi(): ?int
    {
        return $this->id_api;
    }

    public function setIdApi(int $id_api): self
    {
        $this->id_api = $id_api;

        return $this;
    }

    /**
     * @return Collection|Carsharing[]
     */
    public function getCarsharings(): Collection
    {
        return $this->carsharings;
    }

    public function addCarsharing(Carsharing $carsharing): self
    {
        if (!$this->carsharings->contains($carsharing)) {
            $this->carsharings[] = $carsharing;
            $carsharing->setStageApi($this);
        }

        return $this;
    }

    public function removeCarsharing(Carsharing $carsharing): self
    {
        if ($this->carsharings->contains($carsharing)) {
            $this->carsharings->removeElement($carsharing);
            // set the owning side to null (unless already changed)
            if ($carsharing->getStageApi() === $this) {
                $carsharing->setStageApi(null);
            }
        }

        return $this;
    }

    public function getAnimator(): ?string
    {
        return $this->animator;
    }

    public function setAnimator(string $animator): self
    {
        $this->animator = $animator;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function __toString(){
        // return 'Stage de ' . $this->animator . ' le ' . $this->date;
        return 'Stage de ' . $this->animator . ' ' . $this->date;
    }
}
