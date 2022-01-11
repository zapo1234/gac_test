<?php

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FilterdateRepository::class)
 */
class Filterdate
{

/**
 * @ORM\Column(type="datetime")
 */
private $datestart;

/**
 * @ORM\Column(type="datetime")
 */
private $dateend;

public function getDatestart(): ?\DateTimeInterface
{
return $this->datestart;
}

public function setDatestart(\DateTimeInterface $datestart): self
{
$this->datestart = $datestart;

return $this;
}

public function getDateend(): ?\DateTimeInterface
{
return $this->dateend;
}

public function setDateend(\DateTimeInterface $dateend): self
{
$this->dateend = $dateend;

return $this;
}
}
