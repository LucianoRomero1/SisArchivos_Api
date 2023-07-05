<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

use AppBundle\Base\BaseController;
use AppBundle\Entity\Area;
use AppBundle\Handlers\AreaHandler;
use Symfony\Component\HttpFoundation\JsonResponse;

class AreaController extends BaseController
{
    private $areaHandler;

    public function __construct(AreaHandler $areaHandler)
    {
        $this->areaHandler = $areaHandler;
    }

    public function createAction(Request $request)
    {
        $area = array();
        try {
            $data = json_decode($request->getContent(), true);
            if (empty($data)) {
                throw new \Exception("Parámetros inválidos");
            }

            $area = $this->areaHandler->setArea($data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }

        return $this->successResponse($area, BaseController::CREATE_ACTION);
    }

    public function viewAction(PaginatorInterface $paginator, Request $request)
    {
        try {
            $page = $request->query->getInt('page', 1);
            $itemsPerPage = $request->query->getInt('perPage', 10);
            $searchTerm = $request->query->get('search', '');

            $filteredAreas = $this->filterData($searchTerm, Area::class);
            $pagination = $this->paginateData($paginator, $filteredAreas, $page, $itemsPerPage);
            $data = $this->buildResponseData($pagination, $page, $itemsPerPage, 'areas');

            return $this->successResponse($data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function getOneAction($id = null)
    {
        $area = $this->findById($id, Area::class);

        if (is_null($area)) {
            return $this->errorResponse("El área no fue encontrada");
        }

        return $this->successResponse($area);
    }


    public function editAction(Request $request, $id = null)
    {
        $editedArea = array();
        try {
            $em   = $this->getEm();
            $data = json_decode($request->getContent(), true);
            $area  = $this->areaHandler->findArea($em, $id);
            $editedArea  = $this->areaHandler->setArea($data, $area);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }

        return $this->successResponse($editedArea, BaseController::EDIT_ACTION);
    }

    public function deleteAction(Request $request, $id = null)
    {
        $areaDeleted = array();
        try {
            $em = $this->getEm();
            $areaDeleted = $this->areaHandler->findArea($em, $id);
            $em->remove($areaDeleted);
            $em->flush();
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }

        return $this->successResponse($areaDeleted, BaseController::DELETE_ACTION);
    }
}
