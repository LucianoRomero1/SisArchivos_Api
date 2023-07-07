<?php

namespace AppBundle\Base;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BaseController extends AbstractController
{

    const CREATE_ACTION = "create";
    const EDIT_ACTION   = "edit";
    const DELETE_ACTION = "delete";

    protected $key;
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->key = 'b4ss022.3b+';
        $this->validator = $validator;
    }

    public function getEm()
    {
        return $this->getDoctrine()->getManager();
    }

    public function errorResponse($message = null)
    {
        $response = new JsonResponse();
        $response->setData([
            "status"    => 'error',
            "code"      => 400,
            "message"   => $message
        ]);

        return $response;
    }

    public function successResponse($data, $action = null)
    {
        $message = $this->messageByAction($action);
        $response = new JsonResponse();
        $response->setData([
            "status"    => 'success',
            "code"      => 200,
            "message"   => $message,
            "data"      => json_decode($this->serializer($data)->getContent(), true)
        ]);

        return $response;
    }

    public function messageByAction($action)
    {
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

    public function filterData($searchTerm, $entityClass)
    {
        $em = $this->getEm();
        $repository = $em->getRepository($entityClass);
        $entities = $repository->findBy([], ['id' => 'DESC']);

        if (!empty($searchTerm)) {
            $filteredEntities = array_filter($entities, function ($entity) use ($searchTerm) {
                return strpos(strtolower($entity->getName()), strtolower($searchTerm)) !== false;
            });

            return $filteredEntities;
        }

        return $entities;
    }

    public function paginateData($paginator, $filteredItems, $page, $itemsPerPage)
    {
        return $paginator->paginate($filteredItems, $page, $itemsPerPage);
    }

    public function buildResponseData($pagination, $page, $itemsPerPage, $entity)
    {
        return [
            'total_items_count' => $pagination->getTotalItemCount(),
            'actual_page' => $page,
            'items_per_page' => $itemsPerPage,
            'total_pages' => ceil($pagination->getTotalItemCount() / $itemsPerPage),
            $entity => $pagination->getItems()
        ];
    }

    public function serializer($data)
    {
        $normalizers    = array(new GetSetMethodNormalizer());
        $encoders       = array("json" => new JsonEncoder());

        $serializer     = new Serializer($normalizers, $encoders);
        $json           = $serializer->serialize($data, "json");

        $response       = new Response();
        $response->setContent($json);
        $response->headers->set("Content-Type", "application/json");

        return $response;
    }

    public function findById($id, $entity)
    {
        $em = $this->getEm();
        $entityFinded = $em->getRepository($entity)->findOneBy(["id"=>$id]);
        if(is_null($entityFinded)){
            throw new \Exception("Registro no encontrado");
        }

        return $entityFinded;
    }

    public function validateErrors($entity)
    {
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

    public function getActualDate()
    {
        $fechaActual =  new \DateTime(null, new \DateTimeZone('America/Argentina/Buenos_Aires'));

        return $fechaActual;
    }
}
