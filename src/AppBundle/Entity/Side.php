<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Side
 *
 * @ORM\Table(name="neosys.lados")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SideRepository")
 */
class Side
{
    const DERECHO   = 1;
    const IZQUIERDO = 2;

    /**
     * @var int
     *
     * @ORM\Column(name="cod_lado", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_lado", type="string", length=40)
     */
    private $name;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Side
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}