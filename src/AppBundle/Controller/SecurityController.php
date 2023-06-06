<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Services\Helpers;
use AppBundle\Services\JwtAuth;

class SecurityController extends Controller
{
    public function loginAction(Request $request){
        $helpers = $this->get(Helpers::class);
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

                $jwt_auth = $this->get(JwtAuth::class);

                $signup = $jwt_auth->signup($username, $password);

                return $this->json($signup);
            }else{
                $data = array(
                    'status' => 'error',
                    'data'  => 'Invalid credentials'
                );
            }
        }

        return $helpers->json($data);
    }

    //TODO: Esto es de prueba
    public function newAction(Request $request, $id = null){
        $helpers    = $this->get(Helpers::class);
        $jwt_auth   = $this->get(JwtAuth::class); 

        $token      = $request->get('authorization', null);
        $authCheck  = $jwt_auth->validateToken($token);

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

        return $helpers->json($data);
    }
}
