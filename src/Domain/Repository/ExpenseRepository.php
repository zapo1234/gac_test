<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Expense;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Expense|null find($id, $lockMode = null, $lockVersion = null)
 * @method Expense|null findOneBy(array $criteria, array $orderBy = null)
 * @method Expense[]    findAll()
 * @method Expense[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExpenseRepository extends ServiceEntityRepository
{
public function __construct(ManagerRegistry $registry)
{
parent::__construct($registry, Expense::class);
}

// recupérer les données entre deux dates entrées pour le filter pour les 10 top dépenses
public function getDatataDate()
{
$rawSql = "SELECT value_te FROM expense WHERE  value_te ORDER BY value_te DESC LIMIT 10";
$stmt = $this->getEntityManager()->getConnection()->query($rawSql);
return $stmt->fetchAll();
}
// requete pour recupérer les vehicle_id correspondant au top 10 des dépenses les plus élevés
public function getCheckExpenseid(string $val)
{
$rawSql = "SELECT vehicle_id FROM expense WHERE value_te IN($val) ";
$stmt = $this->getEntityManager()->getConnection()->query($rawSql);
return $stmt->fetchAll();
}

}
