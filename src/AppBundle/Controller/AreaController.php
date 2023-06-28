<?php

namespace AppBundle\Controller;

use AppBundle\Base\BaseController;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\Area;
use AppBundle\Handlers\AreaHandler;
use AppBundle\Handlers\LoginHandler;

class AreaController extends BaseController{

    private $areaHandler;
    private $loginHandler;

    public function __construct(AreaHandler $areaHandler, LoginHandler $loginHandler){
        $this->areaHandler = $areaHandler; 
        $this->loginHandler = $loginHandler; 
    }
    
    public function createAction(Request $request){
        //TODO: Enviar el authorization por el HEADER
        //$request->getHeader(); o algo asi
        try {
            $data = json_decode($request->getContent(), true);
            if($this->loginHandler->validateAuthorization($data)){
                $area = $this->areaHandler->setArea($data["params"]);
            }  
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }

        return $this->successResponse($area, 'create');
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