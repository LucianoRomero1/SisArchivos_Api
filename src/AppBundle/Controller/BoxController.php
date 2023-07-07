<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

use AppBundle\Base\BaseController;
use AppBundle\Entity\Box;
use AppBundle\Handlers\BoxHandler;

class BoxController extends BaseController
{

    private $boxHandler;

    public function __construct(BoxHandler $boxHandler)
    {
        $this->boxHandler = $boxHandler;
    }

    public function createAction(Request $request)
    {
        $box = array();
        try {
            $data = json_decode($request->getContent(), true);
            if (empty($data)) {
                throw new \Exception("Parámetros inválidos");
            }

            $box = $this->boxHandler->setBox($data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }

        return $this->successResponse($box, BaseController::CREATE_ACTION);
    }

    public function viewAction(PaginatorInterface $paginator, Request $request)
    {
        try {
            $page = $request->query->getInt('page', 1);
            $itemsPerPage = $request->query->getInt('perPage', 10);
            $searchTerm = $request->query->get('search', '');

            $filteredBoxes = $this->filterData($searchTerm, Box::class);
            $pagination = $this->paginateData($paginator, $filteredBoxes, $page, $itemsPerPage);
            $data = $this->buildResponseData($pagination, $page, $itemsPerPage, 'boxes');

            return $this->successResponse($data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function getOneAction($id = null)
    {
        try {
            $box = $this->findById($id, Box::class);
            return $this->successResponse($box);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }


    public function editAction(Request $request, $id = null)
    {
        $editedBox = array();
        try {
            $box = $this->findById($id, Box::class);
            $data = json_decode($request->getContent(), true);
            $editedBox  = $this->boxHandler->setBox($data, $box);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }

        return $this->successResponse($editedBox, BaseController::EDIT_ACTION);
    }

    public function deleteAction($id = null)
    {
        $box = array();
        try {
            $em = $this->getEm();
            $box = $this->findById($id, Box::class);
            $em->remove($box);
            $em->flush();
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }

        return $this->successResponse($box, BaseController::DELETE_ACTION);
    }
}
