<?php
namespace App\Http\Controller;

use App\Domain\Entity\Filedata;
use App\Domain\Entity\Vehicle;
use App\Domain\Entity\Expense;
use App\Http\Form\UploadfileType;
use App\Infrastructure\Service\Uploadservice;
use App\Infrastructure\Service\VehicleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class FileUploadController extends AbstractController
{

private $uploadservice;

private $vehicle;

public function __construct(Uploadservice $uploadservice, VehicleService $vehicle)
{
$this->uploadservice = $uploadservice;

$this->vehicle = $vehicle;
}

/**
 * @Route("/file/upload", name="upload")
 */

public function upload(Request $request, Vehicle $vehicle, Expense $expense)
{
$filedata = new Filedata();
// on pass les données du form pour le fichier csv
$form = $this->createForm(UploadfileType::class, $filedata);
$form->handleRequest($request);
// récupération du fichier upload
$file = $form->get('filename')->getData();
if ($form->isSubmitted() && $form->isValid()) {
if(!empty($file))
{
// on appelle la fonction pour upload via le l'infrastructure de service uploadservice
  $upload_dir = 'upload_dir';
  $this->uploadservice->createFile($file,$upload_dir);
// insert des données du fichier in bdd
$this->vehicle->saveVehicle($vehicle,$expense);
}
// en cas de succes renvoi sur le vue dashbord
return $this->redirectToRoute('dashbord');
}

// renvoi la vue pour le fomrs csv
return $this->render('upload/new.html.twig', [
'form' => $form->createView(),
]);

}

/**
 * @Route("/dashbord", name="dashbord")
 */
public function view()
{
// recupérer le total de dépense
$total = $this->vehicle->getTotal();
if(is_null($total))
{
$total =0;
}
// recupérer les informations sur les vehicles top 10
$vehicles = $this->vehicle->getDataVehicle();
if(empty($vehicles))
{
// si les données entre les dates sont vide
return $this->redirectToRoute('dashbord');
$vehicles =[];
}

// renvoi la vue pour sur le dashbord csv
return $this->render('dashbord/view.html.twig', [
'total'=>$total,
'vehicles'=>$vehicles
]);

}

/**
 * @Route("/recher", name="rechers")
 */
public function recherdashbord(Request $request)
{

// recupérer le total de dépense sur la période
$total = $this->vehicle->getTotal($date_start,$date_end);
if(is_null($total))
{
$total =0;
}
$vehicles = $this->vehicle->getDataVehicle($date_start,$date_end);
if(empty($vehicles))
{
// si les données entre les dates sont vide
return $this->redirectToRoute('dashbord');
$vehicles =[];
}

// renvoi la vue pour sur le dashbord csv
return $this->render('dashbord/recher_data.html.twig', [
'total'=>$total,
'vehicles'=>$vehicles,
'date_start' => $date_start,
'date_end' => $date_end
]);

}

}



