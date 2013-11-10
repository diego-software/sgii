<?php

namespace sgii\sgiiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TblLog
 *
 * @ORM\Table(name="tbl_log")
 * @ORM\Entity
 */
class TblLog
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
     * @var \DateTime
     *
     * @ORM\Column(name="log_fecha", type="datetime", nullable=false)
     */
    private $logFecha;

    /**
     * @var string
     *
     * @ORM\Column(name="log_ip", type="string", length=50, nullable=false)
     */
    private $logIp;

    /**
     * @var string
     *
     * @ORM\Column(name="log_descripcion", type="text", nullable=false)
     */
    private $logDescripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="log_modulo", type="string", length=45, nullable=true)
     */
    private $logModulo;

    /**
     * @var integer
     *
     * @ORM\Column(name="log_usuario_id", type="integer", nullable=true)
     */
    private $logUsuarioId;



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
     * Set logFecha
     *
     * @param \DateTime $logFecha
     * @return TblLog
     */
    public function setLogFecha($logFecha)
    {
        $this->logFecha = $logFecha;
    
        return $this;
    }

    /**
     * Get logFecha
     *
     * @return \DateTime 
     */
    public function getLogFecha()
    {
        return $this->logFecha;
    }

    /**
     * Set logIp
     *
     * @param string $logIp
     * @return TblLog
     */
    public function setLogIp($logIp)
    {
        $this->logIp = $logIp;
    
        return $this;
    }

    /**
     * Get logIp
     *
     * @return string 
     */
    public function getLogIp()
    {
        return $this->logIp;
    }

    /**
     * Set logDescripcion
     *
     * @param string $logDescripcion
     * @return TblLog
     */
    public function setLogDescripcion($logDescripcion)
    {
        $this->logDescripcion = $logDescripcion;
    
        return $this;
    }

    /**
     * Get logDescripcion
     *
     * @return string 
     */
    public function getLogDescripcion()
    {
        return $this->logDescripcion;
    }

    /**
     * Set logModulo
     *
     * @param string $logModulo
     * @return TblLog
     */
    public function setLogModulo($logModulo)
    {
        $this->logModulo = $logModulo;
    
        return $this;
    }

    /**
     * Get logModulo
     *
     * @return string 
     */
    public function getLogModulo()
    {
        return $this->logModulo;
    }

    /**
     * Set logUsuarioId
     *
     * @param integer $logUsuarioId
     * @return TblLog
     */
    public function setLogUsuarioId($logUsuarioId)
    {
        $this->logUsuarioId = $logUsuarioId;
    
        return $this;
    }

    /**
     * Get logUsuarioId
     *
     * @return integer 
     */
    public function getLogUsuarioId()
    {
        return $this->logUsuarioId;
    }
}