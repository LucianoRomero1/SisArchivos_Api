<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Record
 *
 * @ORM\Table(name="neosys.histarch")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RecordRepository")
 */
class Record
{
    /**
     * @var int
     *
     * @ORM\Column(name="cod_int", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * 
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Folder")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cod_carpet", referencedColumnName="cod_carpet", nullable=true)
     * })
     * @Assert\NotBlank(message="El código carpeta es requerido.")
     */
    private $idFolder;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="f_retiro", type="datetime")
     */
    private $withdrawalDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="f_devuelto", type="datetime")
     */
    private $returnDate;

    /**
     * @var string
     *
     * @ORM\Column(name="leg", type="string", length=20)
     * @Assert\NotBlank(message="El legajo no puede estar en blanco.")
     * @Assert\Length(
     *     min=1,
     *     max=20,
     *     minMessage="El legajo debe tener al menos {{ limit }} caracteres.",
     *     maxMessage="El legajo no puede tener más de {{ limit }} caracteres."
     * )
     */
    private $file;

    /**
     * @var integer
     *
     * @ORM\Column(name="estado", type="integer")
     */
    private $state;


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
     * Set idFolder
     *
     * @param string $idFolder
     *
     * @return Record
     */
    public function setIdFolder($idFolder)
    {
        $this->idFolder = $idFolder;

        return $this;
    }

    /**
     * Get idFolder
     *
     * @return string
     */
    public function getIdFolder()
    {
        return $this->idFolder;
    }

    /**
     * Set withdrawalDate
     *
     * @param \DateTime $withdrawalDate
     *
     * @return Record
     */
    public function setWithdrawalDate($withdrawalDate)
    {
        $this->withdrawalDate = $withdrawalDate;

        return $this;
    }

    /**
     * Get withdrawalDate
     *
     * @return \DateTime
     */
    public function getWithdrawalDate()
    {
        return $this->withdrawalDate;
    }

    /**
     * Set returnDate
     *
     * @param \DateTime $returnDate
     *
     * @return Record
     */
    public function setReturnDate($returnDate)
    {
        $this->returnDate = $returnDate;

        return $this;
    }

    /**
     * Get returnDate
     *
     * @return \DateTime
     */
    public function getReturnDate()
    {
        return $this->returnDate;
    }

    /**
     * Set file
     *
     * @param string $file
     *
     * @return Record
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

     /**
     * Set state
     *
     * @param integer $state
     *
     * @return Record
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
}