<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

use AppBundle\Entity\Folder;
use AppBundle\Handlers\FolderHandler;

class FolderController extends Controller{
    
    private $folderHandler;

    public function __construct(FolderHandler $folderHandler){
        $this->folderHandler = $folderHandler;
    }

    public function createAction(Request $request){
        try {
            $data = $request->request->all();
            $folder = $this->folderHandler->setFolder($data);
        } catch (\Exception $e) {
            $response = $this->errorResponse($e->getMessage());
            return $response;
        }

        return $this->successResponse($folder, 'create');
    }

    // public function viewAction(PaginatorInterface $paginator, Request $request){
    //     try {
    //         $em = $this->getEm();
    //         $query = $em->getRepository(Folder::class)->findAll();
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
    //         $folder  = $this->folderHandler->findFolder($em, $id);
    //         $editedFolder  = $this->folderHandler->setFolder($data, $folder);
    //     } catch (\Exception $e) {
    //         $response = $this->errorResponse($e->getMessage());
    //         return $response;
    //     }

    //     return $this->successResponse($editedFolder, 'edit');
    // }

    // public function deleteAction($id = null){
    //     try {
    //         $em = $this->getEm();
    //         $folder = $this->folderHandler->findFolder($em, $id);
    //         $em->remove($folder);
    //         $em->flush();
    //     } catch (\Exception $e) {
    //         $response = $this->errorResponse($e->getMessage());
    //         return $response;
    //     }

    //     return $this->successResponse($folder, 'delete');
    // }
}