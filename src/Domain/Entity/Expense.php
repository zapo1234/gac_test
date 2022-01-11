<?php

namespace App\Domain\Entity;

use App\Domain\Repository\ExpenseRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass=ExpenseRepository::class)
 */
class Expense
{
/**
 * @ORM\Id
 * @ORM\GeneratedValue
 * @ORM\Column(type="integer")
 */
private $id;

/**
 * @ORM\Column(type="string", length=64)
 */
private $expenseNumber;

/**
 * @ORM\Column(type="string", length=100)
 */
private $invoiceNumber;

/**
 * @ORM\Column(type="datetime")
 */
private $issuedOn;

/**
 * @ORM\Column(type="string", length=100)
 * @ORM\Column(type="string", type="string", columnDefinition="enum('gazoline', 'disel', 'electricity_charge','hydrogen)")
 */
private $category;

/**
 * @ORM\Column(type="decimal", precision=10, scale=3)
 */
private $valueTe;

/**
 * @ORM\Column(type="decimal", precision=5, scale=3)
 */
private $taxRate;

/**
 * @ORM\Column(type="decimal", precision=10, scale=3)
 */
private $valueTi;

/**
*@ORM\OneToMany(targetEntity=GasStation::class, mappedBy="GasStation", orphanRemoval=true)
* @ORM\JoinColumn(nullable=false)
*/
private $gasStation;

/**
 *@ORM\ManyToOne(targetEntity=Vehicle::class, inversedBy="expense")
*/
private $vehicle;

public function __construct()
{
$this->gasStation = new ArrayCollection();
}

public function getId()
{
return $this->id;
}

public function setId(int $id)
{
$this->id = $id;
return $this;
}

public function getExpenseNumber(): ?string
{
return $this->expenseNumber;
}

public function setExpenseNumber(string $expenseNumber)
{
$this->expenseNumber = $expenseNumber;

return $this;
}

public function getInvoiceNumber()
{
return $this->invoiceNumber;
}

public function setInvoiceNumber(string $invoiceNumber): self
{
$this->invoiceNumber = $invoiceNumber;

return $this;
}

public function getIssuedOn()
{
return $this->issuedOn;
}

public function setIssuedOn(\DateTimeInterface $issuedOn)
{
$this->issuedOn = $issuedOn;

return $this;
}

public function getCategory()
{
return $this->category;
}

public function setCategory(string $category)
{
$this->category = $category;

return $this;
}

public function getValueTe(): ?string
{
return $this->valueTe;
}

public function setValueTe(string $valueTe): self
{
$this->valueTe = $valueTe;

return $this;
}

public function getTaxRate(): ?string
{
return $this->taxRate;
}

public function setTaxRate(string $taxRate): self
{
$this->taxRate = $taxRate;

return $this;
}

public function getValueTi(): ?string
{
return $this->valueTi;
}

public function setValueTi(string $valueTi): self
{
$this->valueTi = $valueTi;

return $this;
}

public function addExpense(expense $expense): self
{
if (!$this->expense->contains($expense)) {
    $this->expense[] = $expense;
    $expense->setGasStation($this);
}

return $this;
}

public function removeExpense(expense $expense): self
{
if ($this->expense->removeElement($expense)) {
    if ($expense->getGasStation() === $this) {
        $expense->setGasStation(null);
    }
}

return $this;
}

public function getVehicle(): ? Vehicle
{
return $this->vehicle;
}

public function setVehicle(?Vehicle $vehicle): self
{
$this->vehicle = $vehicle;

return $this;
}


}
