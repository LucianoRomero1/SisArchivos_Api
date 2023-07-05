<?php

namespace AppBundle\Handlers;

use AppBundle\Base\BaseController;
use Firebase\JWT\JWT;

class LoginHandler extends BaseController
{

    public function signup($username, $password, $getHash = null)
    {
        //Busco que DB estoy actualmente
        $paramValue = $this->getDoctrine()->getConnection()->getHost();

        //Seteo el string de la config de la DB
        $db = '(DESCRIPTION=( ADDRESS_LIST= (ADDRESS= (PROTOCOL=TCP)'
            . ' (HOST=' . $paramValue . ') (PORT=1521)))'
            . '( CONNECT_DATA= (SID=NEOSYS) ))';

        try {
            $conn = oci_connect($username, $password, $db, 'UTF8');
            if ($conn == true) {
                $token = array(
                    'username' => $username,
                    'iat' => time(),
                    //Caduca cada 12 horas
                    'exp' => time() + (12 * 60 * 60)
                );

                $jwt    = JWT::encode($token, $this->key, "HS256");
                $data = [
                    "status" => "success",
                    "code" => 200,
                    "token" => $jwt,
                    "user" => JWT::decode($jwt, $this->key, array("HS256"))
                ];
            }
        } catch (\Exception $e) {
            $data = array(
                'status' => 'error',
                'message' => 'Error al iniciar sesión',
                'error' => $e->getMessage()
            );
        }

        return $data;
    }

    public function validateAuthorization($token)
    {
        $token      = isset($token) ? $token : null;
        $authCheck  = $this->validateToken($token);
        if (!$authCheck) {
            throw new \Exception('Invalid Token');
        }

        return $authCheck;
    }

    public function validateToken($jwt, $getIdentity = false)
    {
        $auth = false;

        try {
            $decoded = JWT::decode($jwt, $this->key, array("HS256"));
        } catch (\Throwable $th) {
            $auth = false;
        }

        //Si existe, es un objeto, es decir se decodifico bien y el ID está definido.
        if (isset($decoded) && is_object($decoded)) {
            $auth = true;
        } else {
            $auth = false;
        }

        if (!$getIdentity) {
            //Devuelve true o false para validar el token
            return $auth;
        } else {
            //Devuelve los datos del user logueado
            $data = json_decode(json_encode($decoded), true);
            return $data;
        }
    }
}
