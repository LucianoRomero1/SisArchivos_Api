<?php

namespace AppBundle\Handlers;

use AppBundle\Base\BaseController;
use AppBundle\Entity\Area;
use Exception;

class AreaHandler extends BaseController
{
    public function setArea($data, $area = null){
        $entityManager = $this->getEm();

        if(is_null($area)){
            $area = new Area();
        }

        $area->setName(strtoupper($data["name"]));

        $this->validateErrors($area);

        $entityManager->persist($area); 
        $entityManager->flush();

        return $area;       
    }
}