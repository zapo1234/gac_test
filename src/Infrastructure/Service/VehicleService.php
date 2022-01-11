<?php

namespace App\Infrastructure\Service;
use App\Domain\Entity\Vehicle;
use App\Domain\Entity\Expense;
use App\Domain\Entity\GasStation;
use App\Domain\Repository\ExpenseRepository;
use App\Domain\Repository\VehicleRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Infrastructure\Service\Vehicl;
use App\Infrastructure\Service\Uploadservice;
use Symfony\Component\Validator\Constraints\DateTime;

class VehicleService implements Vehicl
{
private $entityManager;

private $uploadservice;

private $expenseRepository;

private $vehicleRepository;

private $donnes = [];

public function __construct(
EntityManagerInterface $entityManager,
Uploadservice $uploadservice,
ExpenseRepository $expenseRepository,
VehicleRepository $vehicleRepository
)

{
$this->entityManager = $entityManager;
$this->uploadservice = $uploadservice;
$this->expenseRepository = $expenseRepository;
$this->vehicleRepository = $vehicleRepository;
}

public function  saveVehicle(Vehicle $vehicle, Expense $expense) : void
{
// recupérer les données du fichier csv dans le service
$datas = $this->uploadservice->donnees();
// tranformer le tableau dans un tableau multidimentionnel($values)
// boucle pour recupérer les données dans un array
foreach($datas as $key => $values)
{
$values = explode(';', $values);
// si le nombre de ligne de colone du fichier supérieur à 14 selon le fichier csv donné
if(count($values) > 14)
{
// initilisé des array pour insert relation entre les entités
$expenses = [];
$gasstation =[];
$vehicles = [];
// insert datas du vehicle
$vehicle = new Vehicle;
if (!key_exists($values[1], $vehicles)) {
$vehicle->setPlateNumber($values['1']);
$vehicle->setBrand($values['2']);
$vehicle->setModel($values['3']);
$vehicles[$values['1']] = $vehicle;
$this->entityManager->persist($vehicle);
}
else{
   $vehicle = $vehicles[$values[1]];
}
// insert datas 
// recupére la date sous forme de chaine de caractère du csv en object
// tranformer en version anglaise pour insert in bdd
$datetime = $values[9];// recupére les dates via le csv et les tranformer en  data object.
$date = explode(' ', $datetime);
$dat = explode('/',$date[0]);
$date_new = $dat[2].'-'.$dat[1].'-'.$dat[0].' '.$date[1];
$date_new = new \DateTime('@'.strtotime($date_new));

// convertir en integer les valeurs de type decimale expenseNumber,invoiceNumber
//taxRate en chaine de caractère
$expenseNumber = (int)($values[11]);
$invoiceNumber = (int)($values[10]);
$valueTi = (int)($values[8]);
$taxRate = (int)($values[7]);
$valueTe = (int)($values[6]);


if(!key_exists($values[4], $expenses)) {
$expense = new Expense();
$expense->setExpenseNumber($expenseNumber);
$expense->setInvoiceNumber($invoiceNumber);
$expense->setIssuedOn($date_new);
$expense->setCategory($values['4']);
$expense->setValueTe($valueTe);
$expense->setTaxRate($taxRate);
$expense->setValueTi($valueTi);
//lié la relation entre les entités vehicle et expense
$expense->setVehicle($vehicle);
$expenses[$values['1']] = $expense;
$this->entityManager->persist($expense);
   }
else{
   $expense = $expenses[$values[1]];
}

//insert data dans gasStation
$gasStation = new GasStation();
$gasStation->setDescription($values['12']);
$gasStation->setCoordinate($values['13']);
$gasStation->setExpense($expense);
$this->entityManager->persist($gasStation);
}
} 
// flush into bdd vehicle,expense,gasStation
$this->entityManager->flush();
}

/**
* @return integer
*/
public function getTotal() : int
{

$data = $this->expenseRepository->findAll();
$array_values =[];
foreach($data as $val)
{
  $array_values[] = $val->getValueTe();
}
 // somme la valeur dans un array pour return int
 $total = array_sum($array_values);
 return $total;
}

/**
 * @return integer
*/
public function getTotalCategory(Expense $expense) :int
{
// recupérer la somme total des dépenses effectuées par categories
$category = $expense->getCategory();
$data = $this->expenseRepository->findByOne(['category'=>$category]);
$donnees = [];
foreach($data as $values)
{
// recupérer les valeurs dans un array
$donnees[] = $values->getValueTe();
}
// renvoyer la somme du tableau des valeurs du tableau
$total = array_sum($donnees);
return $total;
}

//ecrire des getteur et setteur pour la variable array donnes
public function getDonnes()
{
   return $this->donnes;
}

public function setDonnes(array $donnes)
{
  $this->donnes = $donnees;
  return $this;
}

/**
 * @return array
*/
public function getTotalTop10(): array
{
// recupérer le tableau contenant les valeurs des vehicle_id du top 10 dans expense
// trier par ordre croissant le tableau
$datas = $this->expenseRepository->getDatataDate();
//insérer les valeurs dans un array indexé numériquement
$array_values = [];
foreach($datas as $key => $values)
{
   foreach($values as $val)
   {
      $array_values[] = $val;
   }
}
// tranformer sous forme de chaine de caractère l'array pour la requete sql
$values = "'". implode("' , '",$array_values) ."'";
// recupérer les vehicles_id associés aux valeurs value_te top 10 expense
return $this->expenseRepository->getCheckExpenseid($values);

}

/**
 * @return array
*/
public function getVehicleTop10() :array
{
// recupérer brand and model des vehicles qui dépenses plus (top10) 
// à partir des vehicle_id obtenus dans expense
$data = $this->getTotalTop10();
// recupérer les données vehicle_id dans un array indexé numériquement
$array_values =[];
foreach($data as $values)
{
   foreach($values as $valeur)
   {
      $array_values[] = $valeur;
   }
}

// recupére un tableau unique de valeur id pour la table vehicle
$array_values = array_unique($array_values);
// tranformer sous forme de chaine de caractère l'array requete sql
$values = "'". implode("' , '",$array_values) ."'";
// recupérer les données  du véhicule associés aux valeurs vehicle_id dans la requete 
return $this->vehicleRepository->getCheckVehicleName($values);

}

public function getDataVehicle() :array
{
// récupérer dans un tableau numérique indexé les réferences plate_number des vehicules top 10
$donnees =[];
foreach($this->getVehicleTop10() as $keys => $values)
{
foreach($values as $valeur)
{
 $donnees[]=$valeur;
}
}
// extraire les éventuels doublons  sur le place_number du vehicule et renvoi un unique array
$donnees = array_unique($donnees);
return $donnees;
}
}
