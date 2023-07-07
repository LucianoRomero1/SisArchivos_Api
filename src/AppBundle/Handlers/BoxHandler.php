<?php

namespace AppBundle\Handlers;

use AppBundle\Base\BaseController;
use AppBundle\Entity\Area;
use AppBundle\Entity\Box;
use Exception;

class BoxHandler extends BaseController
{
    public function setBox($data, $box = null){
        $entityManager = $this->getDoctrine()->getManager();

        if(is_null($box)){
            $box = new Box();
        }

        $area = $entityManager->getRepository(Area::class)->find($data["idArea"]);
        if($area == null){
            throw new Exception("No se encontró una área con ese código");
        }

        $numberBox   = isset($data['numberBox'])   ? $data['numberBox']   : null;
        $shelfCode   = isset($data['shelfCode'])   ? $data['shelfCode']   : null;
        $sideCode    = isset($data['sideCode'])    ? $data['sideCode']    : null;
        $column      = isset($data['column'])      ? $data['column']      : null;
        $floor       = isset($data['floor'])       ? $data['floor']       : null;
        $numberFrom  = isset($data['numberFrom'])  ? $data['numberFrom']  : null;
        $numberTo    = isset($data['numberTo'])    ? $data['numberTo']    : null;
        $observation = isset($data['observation']) ? $data['observation'] : null;
        $state       = isset($data['state'])       ? $data['state']       : 0;

        $box->setNumberBox($numberBox);
        $box->setShelfCode($shelfCode);
        $box->setSideCode($sideCode);
        $box->setColumn($column);
        $box->setFloor($floor);
        $box->setNumberFrom($numberFrom);
        $box->setNumberTo($numberTo);
        $box->setObservation($observation);
        $box->setState($state);
        $box->setTitle($data["title"]);
        $box->setDateFrom(new \DateTime($data["dateFrom"]));
        $box->setDateTo(new \DateTime($data["dateTo"]));
        $box->setArchivedUntil(new \DateTime($data["archivedUntil"]));
        $box->setIdArea($area);

        $this->validateErrors($box);

        $entityManager->persist($box);
        $entityManager->flush();

        return $box;       
    }
}