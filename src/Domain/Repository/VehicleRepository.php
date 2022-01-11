<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Vehicle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Vehicle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vehicle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vehicle[]    findAll()
 * @method Vehicle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehicleRepository extends ServiceEntityRepository
{
public function __construct(ManagerRegistry $registry)
{
parent::__construct($registry, Vehicle::class);
}

// requete sql afficher pour les véhicules (top 10 ddépenses) à partir du plate_number
public function getCheckVehicleName(string $values)
{
$rawSql = "SELECT plate_number FROM vehicle WHERE id IN($values) ";
$stmt = $this->getEntityManager()->getConnection()->query($rawSql);
return $stmt->fetchAll();
}
}
