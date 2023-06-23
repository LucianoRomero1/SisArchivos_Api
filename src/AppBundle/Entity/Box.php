<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Box
 *
 * @ORM\Table(name="neosys.depcajas")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BoxRepository")
 */
class Box
{
    /**
     * @var int
     *
     * @ORM\Column(name="cod_caja", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * 
     * @ORM\Column(name="cod_estant", type="integer", nullable=true)
     * @Assert\Range(
     *      min = 1,
     *      max = 99999,
     *      minMessage = "El código estante debe ser mayor a 1",
     *      maxMessage = "El código estante debe ser menor a 99999"
     * )
     */
    private $shelfCode;

    /**
     * @var string
     *
     * @ORM\Column(name="cod_lado", type="integer", nullable=true)
     * @Assert\Range(
     *      min = 1,
     *      max = 99999,
     *      minMessage = "El código lado debe ser mayor a 1",
     *      maxMessage = "El código lado debe ser menor a 99999"
     * )
     */
    private $sideCode;

    /**
     * @var string
     *
     * @ORM\Column(name="columna", type="integer", nullable=true)
     * @Assert\Range(
     *      min = 1,
     *      max = 99999,
     *      minMessage = "La columna debe ser mayor a 1",
     *      maxMessage = "La columna debe ser menor a 99999"
     * )
     */
    private $column;

    /**
     * @var string
     *
     * @ORM\Column(name="piso", type="integer", nullable=true)
     * @Assert\Range(
     *      min = 1,
     *      max = 99999,
     *      minMessage = "El piso debe ser mayor a 1",
     *      maxMessage = "El piso debe ser menor a 99999"
     * )
     */
    private $floor;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Area")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cod_area", referencedColumnName="cod_area", nullable=true)
     * })
     * @Assert\NotBlank(message="El código área es requerido.")
     */
    private $idArea;

    /**
     * @var string
     *
     * @ORM\Column(name="tituloCaja", type="string", length=200)
     * @Assert\NotBlank(message="El título de la caja no puede estar en blanco.")
     * @Assert\Length(
     *     min=1,
     *     max=100,
     *     minMessage="El título de la caja debe tener al menos {{ limit }} caracteres.",
     *     maxMessage="El título de la caja no puede tener más de {{ limit }} caracteres."
     * )
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="n_des_caja", type="integer", nullable=true)
     * @Assert\Range(
     *      min = 1,
     *      max = 99999,
     *      minMessage = "El n° desde debe ser mayor a 1",
     *      maxMessage = "El n° desde debe ser menor a 99999"
     * )
     */
    private $numberFrom;

    /**
     * @var string
     *
     * @ORM\Column(name="n_has_caja", type="integer", nullable=true)
     * @Assert\Range(
     *      min = 1,
     *      max = 99999,
     *      minMessage = "El n° hasta debe ser mayor a 1",
     *      maxMessage = "El n° hasta debe ser menor a 99999"
     * )
     */
    private $numberTo;

    /**
     * @var string
     *
     * @ORM\Column(name="observa", type="string", length=1000, nullable=true)
     * @Assert\Length(
     *     min=1,
     *     max=10,
     *     minMessage="La observación debe tener al menos {{ limit }} caracteres.",
     *     maxMessage="La observación no puede tener más de {{ limit }} caracteres."
     * )
     */
    private $observation;

    /**
     * @var int
     *
     * @ORM\Column(name="estado", type="integer")
     */
    private $state;

    /**
     * @var int
     *
     * @ORM\Column(name="nro_caja", type="integer", nullable=true)
     * @Assert\Range(
     *      min = 1,
     *      max = 99999,
     *      minMessage = "El n° hasta debe ser mayor a 1",
     *      maxMessage = "El n° hasta debe ser menor a 99999"
     * )
     */
    private $numberBox;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="f_des_caja", type="datetime")
     */
    private $dateFrom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="f_has_caja", type="datetime")
     */
    private $dateTo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="arch_hasta", type="datetime")
     */
    private $archivedUntil;


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
     * Set shelfCode
     *
     * @param integer $shelfCode
     *
     * @return Box
     */
    public function setShelfCode($shelfCode)
    {
        $this->shelfCode = $shelfCode;

        return $this;
    }

    /**
     * Get shelfCode
     *
     * @return int
     */
    public function getShelfCode()
    {
        return $this->shelfCode;
    }

    /**
     * Set sideCode
     *
     * @param integer $sideCode
     *
     * @return Box
     */
    public function setSideCode($sideCode)
    {
        $this->sideCode = $sideCode;

        return $this;
    }

    /**
     * Get sideCode
     *
     * @return int
     */
    public function getSideCode()
    {
        return $this->sideCode;
    }

    /**
     * Set column
     *
     * @param integer $column
     *
     * @return Box
     */
    public function setColumn($column)
    {
        $this->column = $column;

        return $this;
    }

    /**
     * Get column
     *
     * @return int
     */
    public function getColumn()
    {
        return $this->column;
    }

    /**
     * Set floor
     *
     * @param integer $floor
     *
     * @return Box
     */
    public function setFloor($floor)
    {
        $this->floor = $floor;

        return $this;
    }

    /**
     * Get floor
     *
     * @return int
     */
    public function getFloor()
    {
        return $this->floor;
    }

    /**
     * Set idArea
     *
     * @param string $idArea
     *
     * @return Box
     */
    public function setIdArea($idArea)
    {
        $this->idArea = $idArea;

        return $this;
    }

    /**
     * Get idArea
     *
     * @return string
     */
    public function getIdArea()
    {
        return $this->idArea;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Box
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set numberFrom
     *
     * @param integer $numberFrom
     *
     * @return Box
     */
    public function setNumberFrom($numberFrom)
    {
        $this->numberFrom = $numberFrom;

        return $this;
    }

    /**
     * Get numberFrom
     *
     * @return int
     */
    public function getNumberFrom()
    {
        return $this->numberFrom;
    }

    /**
     * Set numberTo
     *
     * @param integer $numberTo
     *
     * @return Box
     */
    public function setNumberTo($numberTo)
    {
        $this->numberTo = $numberTo;

        return $this;
    }

    /**
     * Get numberTo
     *
     * @return int
     */
    public function getNumberTo()
    {
        return $this->numberTo;
    }

    /**
     * Set observation
     *
     * @param string $observation
     *
     * @return Box
     */
    public function setObservation($observation)
    {
        $this->observation = $observation;

        return $this;
    }

    /**
     * Get observation
     *
     * @return string
     */
    public function getObservation()
    {
        return $this->observation;
    }

    /**
     * Set state
     *
     * @param integer $state
     *
     * @return Box
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

     /**
     * Set numberBox
     *
     * @param integer $numberBox
     *
     * @return Box
     */
    public function setNumberBox($numberBox)
    {
        $this->numberBox = $numberBox;

        return $this;
    }

    /**
     * Get numberBox
     *
     * @return int
     */
    public function getNumberBox()
    {
        return $this->numberBox;
    }

    /**
     * Set dateFrom
     *
     * @param \DateTime $dateFrom
     *
     * @return Box
     */
    public function setDateFrom($dateFrom)
    {
        $this->dateFrom = $dateFrom;

        return $this;
    }

    /**
     * Get dateFrom
     *
     * @return \DateTime
     */
    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    /**
     * Set dateTo
     *
     * @param \DateTime $dateTo
     *
     * @return Box
     */
    public function setDateTo($dateTo)
    {
        $this->dateTo = $dateTo;

        return $this;
    }

    /**
     * Get dateTo
     *
     * @return \DateTime
     */
    public function getDateTo()
    {
        return $this->dateTo;
    }

    /**
     * Set archivedUntil
     *
     * @param \DateTime $archivedUntil
     *
     * @return Box
     */
    public function setArchivedUntil($archivedUntil)
    {
        $this->archivedUntil = $archivedUntil;

        return $this;
    }

    /**
     * Get archivedUntil
     *
     * @return \DateTime
     */
    public function getArchivedUntil()
    {
        return $this->archivedUntil;
    }
}