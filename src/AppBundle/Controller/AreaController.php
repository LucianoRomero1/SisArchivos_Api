<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

use AppBundle\Entity\Area;
use AppBundle\Handlers\AreaHandler;
use AppBundle\Handlers\DefaultHandler;

class AreaController extends Controller{

    private $areaHandler;
    private $defaultHandler;

    public function __construct(AreaHandler $areaHandler, DefaultHandler $defaultHandler){
        $this->areaHandler    = $areaHandler;
        $this->defaultHandler = $defaultHandler;
    }

    public function createAction(Request $request){
        try {
            $params = $this->defaultHandler->validateRequest($request);
            dump($params);
            die;
            $data = $request->request->all();
            $area = $this->areaHandler->setArea($data);
        } catch (\Exception $e) {
            $response = $this->defaultHandler->errorResponse($e->getMessage());
            return $response;
        }

        return $this->defaultHandler->successResponse($area, 'create');
    }

    // public function viewAction(PaginatorInterface $paginator, Request $request){
    //     try {
    //         $em = $this->getEm();
    //         $query = $em->getRepository(Area::class)->findAll();
    //         $data = $this->paginateData($query, $paginator, $request);
    //     } catch (\Exception $e) {
    //         $response = $this->errorResponse($e->getMessage());
    //         return $response;
    //     }

    //     return $this->successResponse($data, "success");
    // }

    // public function editAction(Request $request, $id = null){
    //     try {
    //         $em   = $this->getEm();
    //         $data = $request->request->all();
    //         $area  = $this->areaHandler->findArea($em, $id);
    //         $editedArea  = $this->areaHandler->setArea($data, $area);
    //     } catch (\Exception $e) {
    //         $response = $this->errorResponse($e->getMessage());
    //         return $response;
    //     }

    //     return $this->successResponse($editedArea, 'edit');
    // }

    // public function deleteAction($id = null){
    //     try {
    //         $em = $this->getEm();
    //         $area = $this->areaHandler->findArea($em, $id);
    //         $em->remove($area);
    //         $em->flush();
    //     } catch (\Exception $e) {
    //         $response = $this->errorResponse($e->getMessage());
    //         return $response;
    //     }

    //     return $this->successResponse($area, 'delete');
    // }
}