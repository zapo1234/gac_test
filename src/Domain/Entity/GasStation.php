<?php
namespace App\Domain\Entity;

use App\Domain\Repository\GasStationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GasStationRepository::class)
 */
class GasStation
{
/**
 * @ORM\Id
 * @ORM\GeneratedValue
 * @ORM\Column(type="integer")
 */
private $id;

/**
 * @ORM\Column(type="string", length=100)
 */
private $description;

/**
 * @ORM\Column(type="string", length=100)
 */
private $coordinate;

/**
 *@ORM\ManyToOne(targetEntity=expense::class, inversedBy="GasStation")
*/
private $expense;

public function getId(): ?int
{
return $this->id;
}

public function getDescription(): ?string
{
return $this->description;
}

public function setDescription(string $description): self
{
$this->description = $description;

return $this;
}

public function getCoordinate(): ?string
{
return $this->coordinate;
}

public function setCoordinate(string $coordinate): self
{
$this->coordinate = $coordinate;

return $this;
}

public function getExpense(): ?Expense
{
return $this->expense;
}

public function setExpense(?Expense $expense): self
{
$this->expense = $expense;

return $this;
}


}
