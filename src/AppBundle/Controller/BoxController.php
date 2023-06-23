<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

use AppBundle\Base\BaseController;
use AppBundle\Entity\Box;
use AppBundle\Handlers\BoxHandler;

class BoxController extends BaseController{
    
    private $boxHandler;

    public function __construct(BoxHandler $boxHandler){
        $this->boxHandler = $boxHandler;
    }

    public function createAction(Request $request){
        try {
            $data = $request->request->all();
            $box  = $this->boxHandler->setBox($data);
        } catch (\Exception $e) {
            $response = $this->errorResponse($e->getMessage());
            return $response;
        }

        return $this->successResponse($box, 'create');
    }

    public function viewAction(PaginatorInterface $paginator, Request $request){
        try {
            $em = $this->getEm();
            $query = $em->getRepository(Box::class)->findAll();
            $data  = $this->paginateData($query, $paginator, $request);
        } catch (\Exception $e) {
            $response = $this->errorResponse($e->getMessage());
            return $response;
        }

        return $this->successResponse($data, "success");
    }

    public function editAction(Request $request, $id = null){
        try {
            $em    = $this->getEm();
            $data  = $request->request->all();
            $box   = $this->boxHandler->findBox($em, $id);
            $editedBox  = $this->boxHandler->setBox($data, $box);
        } catch (\Exception $e) {
            $response = $this->errorResponse($e->getMessage());
            return $response;
        }

        return $this->successResponse($editedBox, 'edit');
    }

    public function deleteAction($id = null){
        try {
            $em = $this->getEm();
            $box = $this->boxHandler->findBox($em, $id);
            $em->remove($box);
            $em->flush();
        } catch (\Exception $e) {
            $response = $this->errorResponse($e->getMessage());
            return $response;
        }

        return $this->successResponse($box, 'delete');
    }
}