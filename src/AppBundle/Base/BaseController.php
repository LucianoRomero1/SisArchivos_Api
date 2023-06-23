<?php

namespace AppBundle\Base;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

use AppBundle\Handlers\LoginHandler;

class BaseController extends AbstractController {

    protected $key;
    private $validator; 

    public function __construct(ValidatorInterface $validator){
        $this->key = 'b4ss022.3b+';
        $this->validator = $validator;
    }

    public function getEm(){
        return $this->getDoctrine()->getManager();
    }

    public function errorResponse($message = null){
        $response = new JsonResponse();
        $response->setData([
            "status"    => 'error',
            "code"      => 400,
            "message"   => $message
        ]);

        return $response;
    }

    public function successResponse($data, $action){
        $message = $this->messageByAction($action);
        $response = new JsonResponse();
        $response->setData([
            "status"    => 'success',
            "code"      => 200,
            "message"   => $message,
            "data"      => $this->serializer($data)
        ]);

        return $response;
    }

    public function serializer($entity){
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getName();
        });
        
        $serializer = new Serializer([$normalizer], [$encoder]);

        return json_decode($serializer->serialize($entity, 'json'));
    }

    public function messageByAction($action){
        $message = '';
        switch ($action) {
            case 'create':
                $message = 'El registro se creó correctamente';
                break;
            case 'edit':
                $message = 'El registro se editó correctamente';
                break;
            case 'delete':
                $message = 'El registro se eliminó correctamente';
                break;
        }

        return $message;
    }

    public function validateErrors($entity){
        // Validar la entidad
        $errors = $this->validator->validate($entity);

        // Verificar si hay errores de validación (estas validaciones están en las entidades)
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }

            throw new \Exception(implode(', ', $errorMessages));
        } 

        return true;
    }

    public function paginateData($query, $paginator, $request)
    {
        $page               = $request->query->getInt('page', 1);

        $items_per_page     = 10;

        $pagination         = $paginator->paginate($query, $page, $items_per_page);
        $total_items_count  = $pagination->getTotalItemCount();

        $data               = array(
            'total_items_count'         => $total_items_count,
            'actual_page'               => $page,
            'items_per_page'            => $items_per_page,
            'total_pages'               => ceil($total_items_count / $items_per_page),
            'data'                      => $pagination
        );

        return $data;
    }

    public function getActualDate(){
        $fechaActual=  new \DateTime(null, new \DateTimeZone('America/Argentina/Buenos_Aires'));
                
        return $fechaActual;
    }
}