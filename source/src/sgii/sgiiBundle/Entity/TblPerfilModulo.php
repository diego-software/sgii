<?php

namespace sgii\sgiiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TblPerfilModulo
 *
 * @ORM\Table(name="tbl_perfil_modulo")
 * @ORM\Entity
 */
class TblPerfilModulo
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
     * @var integer
     *
     * @ORM\Column(name="perfil_id", type="integer", nullable=false)
     */
    private $perfilId;

    /**
     * @var integer
     *
     * @ORM\Column(name="modulo_id", type="integer", nullable=false)
     */
    private $moduloId;



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
     * Set perfilId
     *
     * @param integer $perfilId
     * @return TblPerfilModulo
     */
    public function setPerfilId($perfilId)
    {
        $this->perfilId = $perfilId;
    
        return $this;
    }

    /**
     * Get perfilId
     *
     * @return integer 
     */
    public function getPerfilId()
    {
        return $this->perfilId;
    }

    /**
     * Set moduloId
     *
     * @param integer $moduloId
     * @return TblPerfilModulo
     */
    public function setModuloId($moduloId)
    {
        $this->moduloId = $moduloId;
    
        return $this;
    }

    /**
     * Get moduloId
     *
     * @return integer 
     */
    public function getModuloId()
    {
        return $this->moduloId;
    }
}