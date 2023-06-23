<?php

namespace AppBundle\Handlers;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Area;
use AppBundle\Handlers\DefaultHandler;
use Exception;

class AreaHandler extends Controller
{
    private $defaultHandler;

    public function __construct(DefaultHandler $defaultHandler){
        $this->defaultHandler = $defaultHandler;
    }

    public function findArea($em, $id){
        $area = $em->getRepository(Area::class)->findOneBy(["id"=>$id]);
        if(is_null($area)){
            throw new Exception("Area no encontrada");
        }

        return $area;
    }

    public function setArea($data, $area = null){
        $entityManager = $this->getDoctrine()->getManager();

        if(is_null($area)){
            $area = new Area();
        }
        $area->setName($data["name"]);

        $this->defaultHandler->validateErrors($area);

        $entityManager->persist($area);
        $entityManager->flush();

        return $area;       
    }
}