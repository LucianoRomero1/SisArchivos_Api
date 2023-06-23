<?php

namespace AppBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Firebase\JWT\JWT;

use AppBundle\Entity\User;

class JwtAuth {
    
    private $manager;
    private $key;
    private $container;

    public function __construct($manager, ContainerInterface $container)
    {
        $this->manager = $manager;
        $this->key = 'b4ss022.3b+';
        $this->container = $container;
    }

    public function signup($username, $password, $getHash = null){
        //Busco que DB estoy actualmente
        $paramValue = $this->container->getParameter('database_host');

        //Seteo el string de la config de la DB
        $db = '(DESCRIPTION=( ADDRESS_LIST= (ADDRESS= (PROTOCOL=TCP)'
        . ' (HOST='.$paramValue.') (PORT=1521)))'
        . '( CONNECT_DATA= (SID=NEOSYS) ))';
        
        try {
            $conn = oci_connect($username, $password, $db, 'UTF8');
            if($conn == true){
                $user = $this->manager->getRepository(User::class)->findOneBy(["username" => $username]);
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