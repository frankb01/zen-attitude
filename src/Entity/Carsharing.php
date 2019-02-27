<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CarsharingRepository")
 */
class Carsharing
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\StageApi", inversedBy="carsharings")
     */
    private $stage_api;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="driver_carsharings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $driver;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="passenger_carsharings")
     */
    private $passengers;

    /**
     * @ORM\Column(type="time")
     */
    private $appointment_at;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $appointment_to;

    /**
     * @ORM\Column(type="integer")
     */
    private $seat_number;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $comment;

    public function __construct()
    {
        $this->passengers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStageApi(): ?StageApi
    {
        return $this->stage_api;
    }

    public function setStageApi(?StageApi $stage_api): self
    {
        $this->stage_api = $stage_api;

        return $this;
    }

    public function getDriver(): ?User
    {
        return $this->driver;
    }

    public function setDriver(?User $driver): self
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getPassengers(): Collection
    {
        return $this->passengers;
    }

    public function addPassenger(User $passenger): self
    {
        if (!$this->passengers->contains($passenger)) {
            $this->passengers[] = $passenger;
        }

        return $this;
    }

    public function removePassenger(User $passenger): self
    {
        if ($this->passengers->contains($passenger)) {
            $this->passengers->removeElement($passenger);
        }

        return $this;
    }

    public function getAppointmentAt(): ?\DateTimeInterface
    {
        return $this->appointment_at;
    }

    public function setAppointmentAt(\DateTimeInterface $appointment_at): self
    {
        $this->appointment_at = $appointment_at;

        return $this;
    }

    public function getAppointmentTo(): ?string
    {
        return $this->appointment_to;
    }

    public function setAppointmentTo(string $appointment_to): self
    {
        $this->appointment_to = $appointment_to;

        return $this;
    }

    public function getSeatNumber(): ?int
    {
        return $this->seat_number;
    }

    public function setSeatNumber(int $seat_number): self
    {
        $this->seat_number = $seat_number;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function __toString(){
        return 'covoiturage pour le ' . $this->stage_api;
    }
}
