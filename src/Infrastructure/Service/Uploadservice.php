<?php
namespace App\Infrastructure\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Psr\Log\LoggerInterface;

class Uploadservice
{
private $params;
private $logger;
private $data = [];

public function __construct(ParameterBagInterface $params, LoggerInterface $logger)
{
$this->params = $params;
$this->logger = $logger;
}

/**
 * @return array
*/
public function getData(): array
{
return $this->data;
}

public function setData(array $data)
{
$this->data = $data;
return $this;
}

/**
* @return array
*/

public function createfile(UploadedFile $file, string $upload_dir)
{
// passer en paramètre le paramètre path du chemin du fichier
// upload le fichier et enregsitrez dans une variable array
if($file instanceof UploadedFile)
{
// contraints sur fichier csv à voir pour la taille selon vos test(je laisse facultatif)
$size = 1000000;
//if($file->getSize())
$array_extension = array('txt','csv');
if(in_array($file->guessExtension(), $array_extension))
{
// on génere un nouveau nom de fichier
$name_fichier  = md5(uniqid()).'.'.$file->guessExtension();
// on copie le fichier sur le dossier 
$file->move(
$this->params->get('upload_dir'),
$name_fichier
);
// return le nom du fichier géneré
// recupération du chemin complet du dossier path
// renvoyé les données sous forme de chaine de caractères
// créer un array en colonne pour lister les données du csv
$files = $this->params->get($upload_dir).'/'.$name_fichier;
$files =  file_get_contents($files);
$fileExtension = pathinfo($files, PATHINFO_EXTENSION);
$lines = explode("\n", $files);
// retourner le tableau avec les données du csv
// recupérer dans un array les données
$this->setData($lines);
}
else{
// si le fichier n'est pas du bon type
// envoi un message 
$this->logger->error('failed to upload image');
throw new FileException('un fichier csv est recommandé');
}

}
}

/**
 * @return array
*/
public function donnees(): array
{
//recupérer les données sous forme de tableau dans la vairable array data
return $this->getData();
}
}




