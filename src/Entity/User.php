<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity; # permet que l'utilisateur créé en BDD soit unique et donc n'existe pas déjà (annotation : unique=true à ajouter sur les propriétés concernées)

/**
 * @ORM\Table(name="app_users")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields="name", message="Ce nom utilisateur est déjà pris")
 * @UniqueEntity(fields="email", message="Cet email est déjà pris")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $firstname;

    /**
     * @ORM\Column(type="datetime")
     */
    private $birthdate;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=64, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=64, unique=true)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=16, nullable=true)
     */
    private $license;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $responsability;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Role", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $role;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Grade", inversedBy="users")
     */
    private $grades;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Technique", inversedBy="users")
     */
    private $technics;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $teacher_comment;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Carsharing", mappedBy="passengers")
     */
    private $passenger_carsharings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Carsharing", mappedBy="driver", cascade={"persist", "remove"})
     */
    private $driver_carsharings;

    public function __construct()
    {
        $this->grades = new ArrayCollection();
        $this->technics = new ArrayCollection();
        $this->carsharings = new ArrayCollection();
        $this->driver_carsharings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getLicense(): ?string
    {
        return $this->license;
    }

    public function setLicense(?string $license): self
    {
        $this->license = $license;

        return $this;
    }

    public function getResponsability(): ?string
    {
        return $this->responsability;
    }

    public function setResponsability(string $responsability): self
    {
        $this->responsability = $responsability;

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection|Grade[]
     */
    public function getGrades(): Collection
    {
        return $this->grades;
    }

    public function setGrades()
    {
        $this->grades = $grade;

        return $this;
    }

    public function addGrade(Grade $grade): self
    {
        if (!$this->grades->contains($grade)) {
            $this->grades[] = $grade;
        }

        return $this;
    }

    public function removeGrade(Grade $grade): self
    {
        if ($this->grades->contains($grade)) {
            $this->grades->removeElement($grade);
        }

        return $this;
    }

    /**
     * @return Collection|Technique[]
     */
    public function getTechnics(): Collection
    {
        return $this->technics;
    }

    public function addTechnic(Technique $technic): self
    {
        if (!$this->technics->contains($technic)) {
            $this->technics[] = $technic;
        }

        return $this;
    }

    public function removeTechnic(Technique $technic): self
    {
        if ($this->technics->contains($technic)) {
            $this->technics->removeElement($technic);
        }

        return $this;
    }

    public function getTeacherComment(): ?string
    {
        return $this->teacher_comment;
    }

    public function setTeacherComment(?string $teacher_comment): self
    {
        $this->teacher_comment = $teacher_comment;

        return $this;
    }

    // Ajouté pour le bon fonctionnement de l'encodage à l'aide de UserPasswordEncoderInterface
    public function getSalt()
    {
        return null;
    }

    public function getRoles(){
        return [$this->getRole()->getCode()];
    }

    public function getUsername(){
        return $this->name;
    }

    public function eraseCredentials(){
    }

    /**
     * @return Collection|Carsharing[]
     */
    public function getPassengerCarsharings(): Collection
    {
        return $this->passenger_carsharings;
    }

    public function addPassengerCarsharing(Carsharing $passengerCarsharing): self
    {
        if (!$this->passenger_carsharings->contains($passengerCarsharing)) {
            $this->passenger_carsharings[] = $passengerCarsharing;
            $passengerCarsharing->addPassenger($this);
        }

        return $this;
    }

    public function removePassengerCarsharing(Carsharing $passengerCarsharing): self
    {
        if ($this->passenger_carsharings->contains($passengerCarsharing)) {
            $this->passenger_carsharings->removeElement($passengerCarsharing);
            $passengerCarsharing->removePassenger($this);
        }

        return $this;
    }

    /**
     * @return Collection|Carsharing[]
     */
    public function getDriverCarsharings(): Collection
    {
        return $this->driver_carsharings;
    }

    public function addDriverCarsharing(Carsharing $driverCarsharing): self
    {
        if (!$this->driver_carsharings->contains($driverCarsharing)) {
            $this->driver_carsharings[] = $driverCarsharing;
            $driverCarsharing->setDriver($this);
        }

        return $this;
    }

    public function removeDriverCarsharing(Carsharing $driverCarsharing): self
    {
        if ($this->driver_carsharings->contains($driverCarsharing)) {
            $this->driver_carsharings->removeElement($driverCarsharing);
            // set the owning side to null (unless already changed)
            if ($driverCarsharing->getDriver() === $this) {
                $driverCarsharing->setDriver(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
