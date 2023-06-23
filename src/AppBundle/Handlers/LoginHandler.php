<?php

namespace AppBundle\Handlers;

use AppBundle\Base\BaseController;
use Firebase\JWT\JWT;

use AppBundle\Entity\User;

class LoginHandler extends BaseController {
    
    public function signup($username, $password, $getHash = null){
        $entityManager = $this->getEm();

        //Busco que DB estoy actualmente
        $paramValue = $this->getDoctrine()->getConnection()->getHost();

        //Seteo el string de la config de la DB
        $db = '(DESCRIPTION=( ADDRESS_LIST= (ADDRESS= (PROTOCOL=TCP)'
        . ' (HOST='.$paramValue.') (PORT=1521)))'
        . '( CONNECT_DATA= (SID=NEOSYS) ))';
        
        try {
            $conn = oci_connect($username, $password, $db, 'UTF8');
            if($conn == true){
                $user = $entityManager->getRepository(User::class)->findOneBy(["username" => $username]);
                $token = array(
                    'user' => $user,
                    'iat' => time(),
                    //Caduca una vez a la semana
                    'exp' => time() + (7 * 24 * 60 * 60)
                );
    
                $jwt    = JWT::encode($token, $this->key, "HS256");
                $data = $jwt;
                // //Si quiero la información decodificada se hace asi
                // $decoded    = JWT::decode($jwt, $this->key, array("HS256"));
                // $data       = $decoded;
            }else{
                $data = array(
                    'status' => 'error',
                    'data' => 'Login failed'
                );
            }
        } catch (\Throwable $th) {
            $data = array(
                'status' => 'error',
                'data' => 'Login failed'
            );
        }
        
        return $data;
    }

    public function validateAuthorization($data)
    {           
        $token      = isset($data['authorization']) ? $data['authorization'] : null;
        $authCheck  = $this->validateToken($token);
        if (!$authCheck) {
            throw new \Exception('Authorization not valid');
        }

        return $authCheck;
    }

    public function validateToken($jwt, $getIdentity = false){
        $auth = false;

        try {
            $decoded= JWT::decode($jwt, $this->key, array("HS256"));
        } catch (\Throwable $th) {
            $auth = false;
        }

        //Si existe, es un objeto, es decir se decodifico bien y el ID está definido.
        if(isset($decoded) && is_object($decoded)){
            $auth = true;
        }else{
            $auth = false;
        }

        if(!$getIdentity){
            //Devuelve true o false para validar el token
            return $auth;
        }else{
            //Devuelve los datos del user logueado
            return $decoded;
        }
    }
}