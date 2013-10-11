<?php

namespace sgii\sgiiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TblModulo
 *
 * @ORM\Table(name="tbl_modulo")
 * @ORM\Entity
 */
class TblModulo
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
     * @ORM\Column(name="mod_nombre", type="string", length=255, nullable=false)
     */
    private $modNombre;

    /**
     * @var boolean
     *
     * @ORM\Column(name="mod_estado", type="boolean", nullable=false)
     */
    private $modEstado;



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
     * Set modNombre
     *
     * @param string $modNombre
     * @return TblModulo
     */
    public function setModNombre($modNombre)
    {
        $this->modNombre = $modNombre;
    
        return $this;
    }

    /**
     * Get modNombre
     *
     * @return string 
     */
    public function getModNombre()
    {
        return $this->modNombre;
    }

    /**
     * Set modEstado
     *
     * @param boolean $modEstado
     * @return TblModulo
     */
    public function setModEstado($modEstado)
    {
        $this->modEstado = $modEstado;
    
        return $this;
    }

    /**
     * Get modEstado
     *
     * @return boolean 
     */
    public function getModEstado()
    {
        return $this->modEstado;
    }
}