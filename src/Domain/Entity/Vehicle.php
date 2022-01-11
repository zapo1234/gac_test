<?php

namespace App\Domain\Entity;

use App\Domain\Repository\VehicleRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass=VehicleRepository::class)
 */
class Vehicle
{
/**
 * @ORM\Id
 * @ORM\GeneratedValue
 * @ORM\Column(type="integer")
 */
private $id;

/**
 * @ORM\Column(type="string", length=20)
 */
private $plateNumber;

/**
 * @ORM\Column(type="string", length=100)
 */
private $brand;

/**
 * @ORM\Column(type="string", length=100)
 */
private $model;

/**
 * @ORM\OneToMany(targetEntity=expense::class, mappedBy="Vehicle")
 */
private $vehicle;

public function __construct()
{
$this->vehicle = new ArrayCollection();
}

public function getId(): ?int
{
return $this->id;
}

public function getPlateNumber(): ?string
{
return $this->plateNumber;
}

public function setPlateNumber(string $plateNumber): self
{
$this->plateNumber = $plateNumber;

return $this;
}

public function getBrand(): ?string
{
return $this->brand;
}

public function setBrand(string $brand): self
{
$this->brand = $brand;

return $this;
}

public function getModel(): ?string
{
return $this->model;
}

public function setModel(string $model): self
{
$this->model = $model;

return $this;
}

public function addExpense(Expense $expense): self
{
if (!$this->expense->contains($expense)) {
    $this->expense[] = $expense;
    $vehicle->setVehicle($this);
}

return $this;
}

public function removeExpense(Expense $expense): self
{
if ($this->vehicle->removeElement($expense)) {
    if ($vehicle->getVehicle() === $this) {
        $vehicle->setVehicle(null);
    }
}

return $this;
}
}
