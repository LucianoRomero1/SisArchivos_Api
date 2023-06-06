<?php

namespace AppBundle\Handlers;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

class DefaultHandler extends Controller{
    private $manager;

    public function __construct($manager){
        $this->manager = $manager;
    }
}