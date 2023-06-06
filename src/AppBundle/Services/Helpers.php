<?php

namespace AppBundle\Services;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

class Helpers{

    private $manager;

    public function __construct($manager){
        $this->manager = $manager;
    }

    public function getActualDate(){
        $fechaActual=  new \DateTime(null, new \DateTimeZone('America/Argentina/Buenos_Aires'));
                
        return $fechaActual;
    }

    public function createResponse($status, $code, $dataOrError, $isError = false){
        $response = new JsonResponse();
        
        if ($isError) {
            $response->setData([
                'status' => $status,
                'code' => $code,
                'error' => $dataOrError,
            ]);
        } else {
            $response->setData([
                'status' => $status,
                'code' => $code,
                'data' => $dataOrError,
            ]);
        }
        
        return $response;
        //La llamo asi 
        //$response = $this->createResponse('success', 200, $data);
    }
    

    public function json($data){
        $normalizers    = array(new GetSetMethodNormalizer());
        $encoders       = array("json"=> new JsonEncoder());
        
        $serializer     = new Serializer($normalizers, $encoders);
        $json           = $serializer->serialize($data, "json");

        $response       = new Response();
        $response->setContent($json);
        $response->headers->set("Content-Type", "application/json");

        return $response;
    }

    public function getMaxId($table){
        //TODO: Esto funciona solamente si la PK se llama codigo
        $connection = $this->manager->getConnection();
        $statement = $connection->prepare(
            "SELECT NVL(MAX(t.codigo), 0) + 1 AS lastId FROM $table t"
        );

        $statement->execute();
        $resultado = $statement->fetchAll();

        $resultado = $resultado[0]["LASTID"];

        return intval($resultado);
    }

}