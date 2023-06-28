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
            'data'  => 'Se necesita un JSON'
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
                    'data'  => 'Credenciales inválidas'
                );
            }
        }

        return $this->serializer($data);
    }
}
