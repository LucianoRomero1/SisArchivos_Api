<?php

namespace AppBundle\Handlers;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Box;
use AppBundle\Entity\Folder;
use Exception;

class FolderHandler extends Controller{

    private $defaultHandler;

    public function __construct(DefaultHandler $defaultHandler){
        $this->defaultHandler = $defaultHandler;
    }

    public function findFolder($em, $id){
        $folder = $em->getRepository(Folder::class)->findOneBy(["id"=>$id]);
        if(is_null($folder)){
            throw new Exception("Carpeta no encontrada");
        }

        return $folder;
    }

    public function setFolder($data, $folder = null){
        $entityManager = $this->getDoctrine()->getManager();

        if(is_null($folder)){
            $folder = new Folder();
        }
        
        $box = $entityManager->getRepository(Box::class)->find($data["idBox"]);
        if($box == null){
            throw new Exception("No se encontró una caja con ese código");
        }

        $folder->setFolderNumber($data['folderNumber']);
        $folder->setTitle($data['title']);
        $folder->setIdBox($box);
        $folder->setDateFrom(new \DateTime($data['dateFrom']));
        $folder->setDateTo(new \DateTime($data['dateTo']));
        $folder->setStateNumber($data['stateNumber']);

        $this->defaultHandler->validateErrors($folder);

        $entityManager->persist($folder);
        $entityManager->flush();

        return $folder;       
    }
}