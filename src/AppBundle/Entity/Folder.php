<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Folder
 *
 * @ORM\Table(name="neosys.carpecaja")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FolderRepository")
 */
class Folder
{
    /**
     * @var int
     *
     * @ORM\Column(name="cod_carpet", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

     /**
     * @var string
     *
     * @ORM\Column(name="nro_carpet", type="string", length=15)
     * @Assert\NotBlank(message="El n° de la carpeta no puede estar en blanco.")
     * @Assert\Length(
     *     min=1,
     *     max=10,
     *     minMessage="El n° de la carpeta debe tener al menos {{ limit }} caracteres.",
     *     maxMessage="El n° de la carpeta no puede tener más de {{ limit }} caracteres."
     * )
     */
    private $folderNumber;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Box")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cod_caja", referencedColumnName="cod_caja", nullable=true)
     * })
     * @Assert\NotBlank(message="El código caja es requerido.")
     */
    private $idBox;

    /**
     * @var string
     *
     * @ORM\Column(name="titulocarp", type="string", length=100)
     * @Assert\NotBlank(message="El titulo de la carpeta no puede estar en blanco.")
     * @Assert\Length(
     *     min=1,
     *     max=100,
     *     minMessage="El n° de la carpeta debe tener al menos {{ limit }} caracteres.",
     *     maxMessage="El n° de la carpeta no puede tener más de {{ limit }} caracteres."
     * )
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="f_des_carp", type="datetime")
     */
    private $dateFrom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="f_has_carp", type="datetime")
     */
    private $dateTo;

    /**
     * @var integer
     *
     * @ORM\Column(name="n_estado", type="integer")
     * @Assert\NotBlank(message="El n° estado es requerido.")
     */
    private $stateNumber;


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
     * Set folderNumber
     *
     * @param string $folderNumber
     *
     * @return Folder
     */
    public function setFolderNumber($folderNumber)
    {
        $this->folderNumber = $folderNumber;

        return $this;
    }

    /**
     * Get folderNumber
     *
     * @return string
     */
    public function getFolderNumber()
    {
        return $this->folderNumber;
    }

    /**
     * Set idBox
     *
     * @param string $idBox
     *
     * @return Folder
     */
    public function setIdBox($idBox)
    {
        $this->idBox = $idBox;

        return $this;
    }

    /**
     * Get idBox
     *
     * @return string
     */
    public function getIdBox()
    {
        return $this->idBox;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Folder
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
     * Set dateFrom
     *
     * @param \DateTime $dateFrom
     *
     * @return Folder
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
     * @return Folder
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
     * Set stateNumber
     *
     * @param integer $stateNumber
     *
     * @return Folder
     */
    public function setStateNumber($stateNumber)
    {
        $this->stateNumber = $stateNumber;

        return $this;
    }

    /**
     * Get stateNumber
     *
     * @return int
     */
    public function getStateNumber()
    {
        return $this->stateNumber;
    }
}