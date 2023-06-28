<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Base\BaseController;
use AppBundle\Handlers\LoginHandler;
class DefaultController extends BaseController 
{
    private $loginHandler;
    
    public function __construct(LoginHandler $loginHandler)
    {
        $this->loginHandler = $loginHandler;
    }

    public function loginAction(Request $request){
        $params = json_decode($request->getContent(), true);

        $data = array(
            'status' => 'error',
            'data'  => 'Invalid credentials'
        );

        if($params != null){
            $username = (isset($params["username"])) ? $params["username"] : null;
            $password = (isset($params["password"])) ? $params["password"] : null;

            if($username != null && $password != null){

                $signup = $this->loginHandler->signup($username, $password);

                return $this->json($signup);
            }
        }

        return $this->serializer($data);
    }
}
