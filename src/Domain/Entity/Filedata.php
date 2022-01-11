<?php

namespace App\Domain\Entity;

use App\Repository\FileRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=FileRepository::class)
 */
class Filedata

{

/**
 * @ORM\Column(type="string", length=100)
 * 
 */
private $filename;

public function getFilename(): ?string
{
return $this->filename;
}

public function setFilename(string $filename): self
{
$this->filename = $filename;

return $this;
}
}
