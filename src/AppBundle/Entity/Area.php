<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Area
 *
 * @ORM\Table(name="neosys.areas")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AreaRepository")
 */
class Area
{
    /**
     * @var int
     *
     * @ORM\Column(name="cod_area", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="nom_area", type="string", length=40)
     * @Assert\NotBlank(message="El nombre del área no puede estar en blanco.")
     * @Assert\Length(
     *     min=1,
     *     max=40,
     *     minMessage="El nombre del área debe tener al menos {{ limit }} caracteres.",
     *     maxMessage="El nombre del área no puede tener más de {{ limit }} caracteres."
     * )
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
     * @return Area
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