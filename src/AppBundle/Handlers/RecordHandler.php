<?php

namespace AppBundle\Handlers;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Record;
use Exception;

class RecordHandler extends Controller
{
    private $defaultHandler;

    public function __construct(DefaultHandler $defaultHandler){
        $this->defaultHandler = $defaultHandler;
    }

    //TODO: Este handler lo dejo porque despues las acciones de retiro y devolver provienen de acá
    
    public function findRecord($em, $id){
        $record = $em->getRepository(Record::class)->findOneBy(["id"=>$id]);
        if(is_null($record)){
            throw new Exception("Movimiento no encontrado");
        }

        return $record;
    }

    public function setRecord($data, $record = null){
        $entityManager = $this->getDoctrine()->getManager();

        if(is_null($record)){
            $record = new Record();
        }
        
        //Acá van los setters

        $this->defaultHandler->validateErrors($record);

        $entityManager->persist($record);
        $entityManager->flush();

        return $record;       
    }
}