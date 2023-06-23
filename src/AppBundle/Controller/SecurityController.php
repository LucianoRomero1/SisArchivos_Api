<?php

namespace AppBundle\Controller;

use AppBundle\Base\BaseController;
use AppBundle\Handlers\LoginHandler;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends BaseController
{
    private $loginHandler;
    
    public function __construct(LoginHandler $loginHandler)
    {
        $this->loginHandler = $loginHandler;
    }

    public function loginAction(Request $request){
        $json = $request->get('json', null);

        $data = array(
            'status' => 'error',
            'data'  => 'Send json via post!!!'
        );

        if($json != null){
            $params = json_decode($json);

            $username = (isset($params->username)) ? $params->username : null;
            $password = (isset($params->password)) ? $params->password : null;

            if($username != null && $password != null){

                $signup = $this->loginHandler->signup($username, $password);

                return $this->json($signup);
            }else{
                $data = array(
                    'status' => 'error',
                    'data'  => 'Invalid credentials'
                );
            }
        }

        return $this->serializer($data);
    }

    //Esto es de prueba
    public function newAction(Request $request, $id = null){
        $token      = $request->get('authorization', null);
        $authCheck  = $this->loginHandler->validateToken($token);

        if($authCheck){
            $data   = array(
                'status' => 'success',
                'code'   => 200,
                'msg'    => 'Valid'
            );
        }else{
            $data       = array(
                'status' => 'error',
                'code'   => 400,
                'msg'    => 'Authorization not valid'
            );
        }

        return $this->serializer($data);
    }
}
