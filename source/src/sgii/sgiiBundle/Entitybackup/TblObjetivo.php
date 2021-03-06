<?php

namespace sgii\sgiiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TblObjetivo
 *
 * @ORM\Table(name="tbl_objetivo")
 * @ORM\Entity
 */
class TblObjetivo
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="obj_objetivo", type="string", length=250, nullable=false)
     */
    private $objObjetivo;

    /**
     * @var boolean
     *
     * @ORM\Column(name="obj_estado", type="boolean", nullable=false)
     */
    private $objEstado;

    /**
     * @var integer
     *
     * @ORM\Column(name="proyecto_id", type="integer", nullable=false)
     */
    private $proyectoId;

    /**
     * @var integer
     *
     * @ORM\Column(name="estado_objetivo_id", type="integer", nullable=false)
     */
    private $estadoObjetivoId;

    /**
     * @var integer
     *
     * @ORM\Column(name="objetivo_id", type="integer", nullable=true)
     */
    private $objetivoId;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set objObjetivo
     *
     * @param string $objObjetivo
     * @return TblObjetivo
     */
    public function setObjObjetivo($objObjetivo)
    {
        $this->objObjetivo = $objObjetivo;
    
        return $this;
    }

    /**
     * Get objObjetivo
     *
     * @return string 
     */
    public function getObjObjetivo()
    {
        return $this->objObjetivo;
    }

    /**
     * Set objEstado
     *
     * @param boolean $objEstado
     * @return TblObjetivo
     */
    public function setObjEstado($objEstado)
    {
        $this->objEstado = $objEstado;
    
        return $this;
    }

    /**
     * Get objEstado
     *
     * @return boolean 
     */
    public function getObjEstado()
    {
        return $this->objEstado;
    }

    /**
     * Set proyectoId
     *
     * @param integer $proyectoId
     * @return TblObjetivo
     */
    public function setProyectoId($proyectoId)
    {
        $this->proyectoId = $proyectoId;
    
        return $this;
    }

    /**
     * Get proyectoId
     *
     * @return integer 
     */
    public function getProyectoId()
    {
        return $this->proyectoId;
    }

    /**
     * Set estadoObjetivoId
     *
     * @param integer $estadoObjetivoId
     * @return TblObjetivo
     */
    public function setEstadoObjetivoId($estadoObjetivoId)
    {
        $this->estadoObjetivoId = $estadoObjetivoId;
    
        return $this;
    }

    /**
     * Get estadoObjetivoId
     *
     * @return integer 
     */
    public function getEstadoObjetivoId()
    {
        return $this->estadoObjetivoId;
    }

    /**
     * Set objetivoId
     *
     * @param integer $objetivoId
     * @return TblObjetivo
     */
    public function setObjetivoId($objetivoId)
    {
        $this->objetivoId = $objetivoId;
    
        return $this;
    }

    /**
     * Get objetivoId
     *
     * @return integer 
     */
    public function getObjetivoId()
    {
        return $this->objetivoId;
    }
}