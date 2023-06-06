<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Services\Helpers;
use AppBundle\Services\JwtAuth;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        
    }
}
