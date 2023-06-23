<?php

namespace AppBundle\Handlers;

use AppBundle\Base\BaseController;
use AppBundle\Entity\Record;
use Exception;

class RecordHandler extends BaseController
{
    //TODO: Este handler lo dejo porque despues las acciones de retiro y devolver provienen de acá
    
    public function findRecord($em, $id){
        $record = $em->getRepository(Record::class)->findOneBy(["id"=>$id]);
        if(is_null($record)){
            throw new Exception("Movimiento no encontrado");
        }

        return $record;
    }

    public function setRecord($data, $record = null){
        $entityManager = $this->getEm();

        if(is_null($record)){
            $record = new Record();
        }
        
        //Acá van los setters

        $this->validateErrors($record);

        $entityManager->persist($record);
        $entityManager->flush();

        return $record;       
    }
}