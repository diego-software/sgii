<?php

namespace sgii\sgiiBundle\Services;

/**
 * Servicio para obtener resultados de queries usadas en toda la aplicacion
 * 
 * @author Diego Malagón <diego-software@hotmail.com>
 */
class GenericQueriesService
{
    protected $doctrine;
    protected $session;
    protected $em;
    
    function __construct($doctrine, $session) 
    {
        $this->doctrine = $doctrine;
        $this->session = $session;
        $this->em = $doctrine->getManager();
    }
    
    /**
     * Funcion que obtiene las organizaciones
     * 
     * @author Diego Malagón <diego-software@hotmail.com>
     * @param integer $id id de organizacion si busca una en especifico
     * @return array
     */
    public function getOrganizaciones($id = null)
    {
        $return = false;
        
        $dql = "SELECT 
                    o.id,
                    o.orgNombre,
                    o.orgDescripcion,
                    o.orgSitioWeb
                FROM 
                    sgiiBundle:TblOrganizacion o
        ";
        
        if($id != null)
        {
            $dql .= "WHERE o.id = :id";
        }
        
        $query = $this->em->createQuery($dql);
        
        if($id != null)
        {
            $query->setParameter('id', $id);
            $query->setMaxResults(1);
        }
        $result = $query->getResult();
        
        if(count($result)>0)
        {
            if($id != null)
            {
                $return = $result[0];
            }
            else
            {
                $return = $result;
            }
        }
        
        return $return;
    }
    
    /**
     * Funcion que obtiene los cargos
     * 
     * @author Diego Malagón <diego-software@hotmail.com>
     * @param integer $id id de cargo uno en especifico
     * @return array
     */
    public function getCargos($id = null)
    {
        $return = false;
        
        $dql = "SELECT 
                    c.id,
                    c.carNombre,
                    c.carDescripcion
                FROM 
                    sgiiBundle:TblCargo c
        ";
        
        if($id != null)
        {
            $dql .= "WHERE c.id = :id";
        }
        
        $query = $this->em->createQuery($dql);
        
        if($id != null)
        {
            $query->setParameter('id', $id);
            $query->setMaxResults(1);
        }
        $result = $query->getResult();
        
        if(count($result)>0)
        {
            if($id != null)
            {
                $return = $result[0];
            }
            else
            {
                $return = $result;
            }
        }
        
        return $return;
    }
    
    /**
     * Funcion que obtiene los departamentos/areas
     * 
     * @author Diego Malagón <diego-software@hotmail.com>
     * @param integer $id id de departamento si busca uno en especifico
     * @return array
     */
    public function getDepartamentos($id = null)
    {
        $return = false;
        
        $dql = "SELECT 
                    d.id,
                    d.depNombre,
                    d.depDescripcion
                FROM 
                    sgiiBundle:TblDepartamento d
        ";
        
        if($id != null)
        {
            $dql .= "WHERE d.id = :id";
        }
        
        $query = $this->em->createQuery($dql);
        
        if($id != null)
        {
            $query->setParameter('id', $id);
            $query->setMaxResults(1);
        }
        $result = $query->getResult();
        
        if(count($result)>0)
        {
            if($id != null)
            {
                $return = $result[0];
            }
            else
            {
                $return = $result;
            }
        }
        
        return $return;
    }
    
    /**
     * Funcion que obtiene los niveles
     * 
     * @author Diego Malagón <diego-software@hotmail.com>
     * @param integer $id id de nivel si busca uno en especifico
     * @return array
     */
    public function getNiveles($id = null)
    {
        $return = false;
        
        $dql = "SELECT 
                    n.id,
                    n.nivNombre,
                    n.nivDescripcion
                FROM 
                    sgiiBundle:TblNivel n
        ";
        
        if($id != null)
        {
            $dql .= "WHERE n.id = :id";
        }
        
        $query = $this->em->createQuery($dql);
        
        if($id != null)
        {
            $query->setParameter('id', $id);
            $query->setMaxResults(1);
        }
        $result = $query->getResult();
        
        if(count($result)>0)
        {
            if($id != null)
            {
                $return = $result[0];
            }
            else
            {
                $return = $result;
            }
        }
        
        return $return;
    }
    
    /**
     * Funcion que verifica si un usuario existe por medio del correo electronico y/o cedula
     * - Acceso desde TblUsuarioController
     * 
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @version 1
     * @param String $email Correo a validar si existe
     * @param Int $documento Número de cédula a validar si existe
     * @param Int $id Id del usuario
     * @return Boolean
     */
    public function existUser($email, $documento, $id = null)
    {
        $return = true;
        $dql = "SELECT u.id FROM sgiiBundle:TblUsuario u WHERE (u.usuLog =:email OR u.usuCedula =:documento)";
        if($id != null)
        {
            $dql .= " AND u.id != :id";
        }
        $query = $this->em->createQuery($dql);
        $query->setParameter('email', $email);
        $query->setParameter('documento', $documento);
        if($id != null)
        {
            $query->setParameter('id', $id);
        }
        $query->setMaxResults(1);
        $result = $query->getResult();
        if (COUNT($result)>0) {
            $return = false;
        }
        return $return;
    }
    
            
    /**
     * Funcion que verifica si existe un usuario registrado con el email
     *     
     * @author Diego Malagón <diego-software@hotmail.com>
     * @param string $email email a verificar
     * @param integer $id id de usuario, se usa en caso de verificar que no exista un usuario con el mismo correo a excepcion del usuario con este id
     */
    public function existsEmail($email, $id = null)
    {
        $dql = "SELECT COUNT(u.id) c FROM sgiiBundle:TblUsuario u WHERE u.usuLog = :email ";
        if($id != null)
        {
            $dql .= " AND u.id != :id";
        }
        $query = $this->em->createQuery($dql);
        $query->setParameter('email', $email);
        if($id != null)
        {
            $query->setParameter('id', $id);
        }
        $query->setMaxResults(1);
        $result = $query->getResult();
        
        if(isset($result[0]['c']) && $result[0]['c'] >= 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    /**
     * Listado de errores registrados en la aplicación
     * - acceso desde TblLogController
     * 
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @version 1
     * @return Array Arreglo de errores registrados en la aplicación
     */
    public function getErrores()
    {
        $dql = 'SELECT l.logFecha, l.logIp, l.logDescripcion, l.logModulo,
                    u.usuNombre
                FROM sgiiBundle:TblLog l
                LEFT JOIN sgiiBundle:TblUsuario u WITH u.id = l.logUsuarioId';
        $query = $this->em->createQuery($dql);
        return $query->getResult();
    }
    
    /**
     * Listado de acciones auditables registrados en la aplicación
     * - acceso desde TblAuditoriaController
     * 
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @version 1
     * @return Array Arreglo de acciones auditables registrados en la aplicación
     */
    public function getAuditoria()
    {
        $dql = 'SELECT a.audFecha, a.audAccion, a.audIpAcceso,
                    u.usuNombre
                FROM sgiiBundle:TblAuditoria a
                LEFT JOIN sgiiBundle:TblUsuario u WITH u.id = a.audUsuarioId';
        $query = $this->em->createQuery($dql);
        return $query->getResult();
    }
    
    /**
     * Listado de Perfiles Activos
     * 
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @version 1
     * @return Array Arreglo de perfiles activos
     */
    public function getPerfiles()
    {
        $dql = "SELECT p.id, p.perPerfil, p.perEstado
            FROM sgiiBundle:TblPerfil p
            WHERE p.perEstado = 1";
        $query = $this->em->createQuery($dql);
        return $query->getResult();
    }
    
    /**
     * Perfil del usuario que ingresa por Id
     * - Acceso desde TblUsuarioController
     * 
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @version 1
     * @param Int $usuarioId Id del usuario
     * @param String $valor Valor que retorna del perfil, por default, el ID.
     * @return Array Arreglo de perfiles del usuario
     */
    public function getPerfilUsuario($usuarioId, $valor = 'id')
    {
        $dql = "SELECT up.perfilId, p.perPerfil
            FROM sgiiBundle:TblUsuarioPerfil up
            JOIN sgiiBundle:TblPerfil p WITH p.id = up.perfilId
            WHERE up.usuarioId =:usuario";
        $query = $this->em->createQuery($dql);
        $query->setParameter('usuario', $usuarioId);
        $perfilUser = $query->getResult();
        
        $perfil = false;
        if ($valor == 'id') {
            $perfil = ($perfilUser) ? $perfilUser[0]['perfilId'] : 0;
        }
        elseif ($valor == 'nombre') {
            $perfil = ($perfilUser) ? $perfilUser[0]['perPerfil'] : 0;
        }
        return $perfil;
    }
    
    /**
     * Borrar perfiles del usuario
     * 
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @version 1
     * @param Int $usuarioId Id del usuario
     */
    public function deletPerfilesUsuario($usuarioId)
    {
        $dql = "DELETE FROM sgiiBundle:TblUsuarioPerfil up
            WHERE up.usuarioId =:usuario";
        $query = $this->em->createQuery($dql);
        $query->setParameter('usuario', $usuarioId);
        $query->getResult();
    }
    
    /**
     * Borrar Usuarios del proyecto
     * - Acceso desde tblProyectos
     * 
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @version 1
     * @param Int $proyectoId Id del proyecto
     */
    public function deleteUsuariosProyecto($proyectoId)
    {
        $dql = "DELETE FROM sgiiBundle:TblUsuarioProyecto up
            WHERE up.proyectoId =:proyectoId";
        $query = $this->em->createQuery($dql);
        $query->setParameter('proyectoId', $proyectoId);
        $query->getResult();
    }
    
    /**
     * Borrar Objetivos
     * - Acceso desde tblProyectos
     * 
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @version 1
     * @param Int $proyectoId Id del proyecto
     */
    public function deleteObjetivos($proyectoId)
    {
        $dql = "DELETE FROM sgiiBundle:TblObjetivo o
            WHERE o.proyectoId =:proyectoId AND o.objetivoId IS NOT NULL";
        $query = $this->em->createQuery($dql);
        $query->setParameter('proyectoId', $proyectoId);
        $query->getResult();
        $dql = "DELETE FROM sgiiBundle:TblObjetivo o
            WHERE o.proyectoId =:proyectoId";
        $query = $this->em->createQuery($dql);
        $query->setParameter('proyectoId', $proyectoId);
        $query->getResult();
    }
    
    /**
     * Borrar Hipotesis
     * - Acceso desde tblProyectos
     * 
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @version 1
     * @param Int $proyectoId Id del proyecto
     */
    public function deleteHipotesis($proyectoId)
    {
        $dql = "DELETE FROM sgiiBundle:TblHipotesis h
            WHERE h.proyectoId =:proyectoId";
        $query = $this->em->createQuery($dql);
        $query->setParameter('proyectoId', $proyectoId);
        $query->getResult();
    }
    
    /**
     * Funcion que obtiene los perfiles retornandolas como array
     * - acceso desde TblUsuarioController
     * 
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @version 1
     * @return array
     */
    public function getPerfilesArray()
    {
        $perfiles = $this->getPerfiles();
        $ArrayPer = Array();
        if ($perfiles) {
            foreach ($perfiles as $per){
                $ArrayPer[$per['id']] = $per['perPerfil'];
            }
        }
        return $ArrayPer;
    }
    
    /**
     * Funcion que obtiene los usuarios
     * - Acceso desde TblUsuarios
     * 
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @version 1
     * @param integer $id id del usuario si busca uno en específico
     * @return array
     */
    public function getUsuarios($id = null)
    {
        $return = false;
        $dql = "SELECT u.id, u.usuNombre, u.usuApellido, u.usuCedula, u.usuFechaCreacion, u.usuLog, u.usuEstado,
                    c.carNombre, d.depNombre, o.orgNombre, n.nivNombre
                FROM sgiiBundle:TblUsuario u
                LEFT JOIN sgiiBundle:TblCargo c WITH c.id = u.cargoId
                LEFT JOIN sgiiBundle:TblDepartamento d WITH d.id = u.departamentoId
                LEFT JOIN sgiiBundle:TblOrganizacion o WITH o.id = u.organizacionId
                LEFT JOIN sgiiBundle:TblNivel n WITH n.id = u.nivelId";
        if($id != null) {
            $dql .= " WHERE u.id = :id";
        }
        
        $query = $this->em->createQuery($dql);
        if($id != null) {
            $query->setParameter('id', $id);
            $query->setMaxResults(1);
        }
        $result = $query->getResult();
        
        if(count($result)>0) {
            if($id != null) {
                $return = $result[0];
            }
            else {
                $return = $result;
            }
        }
        return $return;
    }
    
    /**
     * Funcion que obtiene las organizaciones retornandolas como array
     * - acceso desde TblUsuarioController
     * 
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @version 1
     * @return array
     */
    public function getOrganizacionesArray()
    {
        $organizaciones = $this->getOrganizaciones();
        $ArrayOrg = Array();
        if ($organizaciones) {
            foreach ($organizaciones as $org){
                $ArrayOrg[$org['id']] = $org['orgNombre'];
            }
        }
        return $ArrayOrg;
    }
    
    /**
     * Funcion que obtiene los cargos retornandolas como Array
     * - acceso desde TblUsuarioController
     * 
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @version 1
     * @return array
     */
    public function getCargosArray()
    {
        $cargos = $this->getCargos();
        $ArrayCar = Array();
        if ($cargos) {
            foreach ($cargos as $car){
                $ArrayCar[$car['id']] = $car['carNombre'];
            }
        }
        return $ArrayCar;
    }
    
    /**
     * Funcion que obtiene los departamentos/areas como Array
     * - acceso desde TblUsuarioController
     * 
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @version 1
     * @return array
     */
    public function getDepartamentosArray()
    {
        $departamentos = $this->getDepartamentos();
        $ArrayDep = Array();
        if ($departamentos) {
            foreach ($departamentos as $dep){
                $ArrayDep[$dep['id']] = $dep['depNombre'];
            }
        }
        return $ArrayDep;
    }
    
    /**
     * Funcion que obtiene los Niveles como Array
     * - acceso desde TblUsuarioController
     * - acceso desde PerfilController
     * 
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @version 1
     * @return array
     */
    public function getNivelesArray()
    {
        $niveles = $this->getNiveles();        
        $ArrayNiv = Array();
        if ($niveles) {
            foreach ($niveles as $niv){
                $ArrayNiv[$niv['id']] = $niv['nivNombre'];
            }
        }
        return $ArrayNiv;
    }
    
    /**
     * Funcion que obtiene los Estados de proyecto
     * - acceso desde TblProyectosController
     * 
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @version 1
     * @return array En donde la clave es el Id del estado
     */
    public function getEstadoProyectoArray()
    {
        $dql = "SELECT ep.id, ep.eprEstadoProyecto
            FROM sgiiBundle:TblEstadoProyecto ep
            WHERE ep.eprEstado = 1";
        $query = $this->em->createQuery($dql);
        $estadoProyecto = $query->getResult();
        
        $ArrayEp = Array();
        if ($estadoProyecto) {
            foreach ($estadoProyecto as $ep){
                $ArrayEp[$ep['id']] = $ep['eprEstadoProyecto'];
            }
        }
        return $ArrayEp;
    }
    
    /**
     * Funcion que obtiene los Tipos de investigación
     * - acceso desde TblProyectosController
     * 
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @version 1
     * @return array En donde la clave es el Id del tipo de investigación
     */
    public function getTipoInvestigacionArray()
    {
        $dql = "SELECT ti.id, ti.tinNombreTipo
            FROM sgiiBundle:TblTipoInvestigacion ti
            WHERE ti.tinEstado = 1";
        $query = $this->em->createQuery($dql);
        $tipoInvestigacion = $query->getResult();
        
        $ArrayTi = Array();
        if ($tipoInvestigacion) {
            foreach ($tipoInvestigacion as $ti){
                $ArrayTi[$ti['id']] = $ti['tinNombreTipo'];
            }
        }
        return $ArrayTi;
    }
    
    /**
     * Funcion que obtiene las lineas de investigación
     * - acceso desde TblProyectosController
     * 
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @version 1
     * @return array En donde la clave es el Id de las lineas de investigación
     */
    public function getLineasInvestigacionArray()
    {
        $dql = "SELECT li.id, li.linNombreInvestigacion
            FROM sgiiBundle:TblLineaInvestigacion li
            WHERE li.linEstado = 1";
        $query = $this->em->createQuery($dql);
        $lineaInvestigacion = $query->getResult();
        
        $ArrayLi = Array();
        if ($lineaInvestigacion) {
            foreach ($lineaInvestigacion as $li){
                $ArrayLi[$li['id']] = $li['linNombreInvestigacion'];
            }
        }
        return $ArrayLi;
    }
    
    /**
     * Funcion que obtiene los proyectos
     * - Acceso desde TblProyectosController
     * 
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @version 1
     * @param integer $id id del proyecto si busca uno en específico
     * @return array
     */
    public function getProyectos($id = null)
    {
        $sess_usuario = $this->session->get('sess_usuario');
        $usuarioId = $sess_usuario['id'];
        
        $return = false;
        $dql = "SELECT p.id, p.proNombre, p.proDescripcion, p.proProblema, p.proFechaCreacion, p.proConclusiones, 
                    p.proDemostraciones, p.proRecomendaciones, p.proEstado, 
                    p.usuarioId, u.usuNombre, u.usuApellido,
                    p.lineaInvestigacionId, ti.tinNombreTipo,
                    p.estadoProyectoId, ep.eprEstadoProyecto,
                    p.tipoInvestigacionId, li.linNombreInvestigacion,
                    SUM(CASE WHEN (tup.usuarioId =:usuarioId AND tup.proyectoId = p.id) THEN 1 ELSE 0 END) AS pertenece
                FROM sgiiBundle:TblProyecto p
                LEFT JOIN sgiiBundle:TblEstadoProyecto ep WITH ep.id = p.estadoProyectoId
                LEFT JOIN sgiiBundle:TblLineaInvestigacion li WITH li.id = p.lineaInvestigacionId
                LEFT JOIN sgiiBundle:TblTipoInvestigacion ti WITH ti.id = p.tipoInvestigacionId
                LEFT JOIN sgiiBundle:TblUsuario u WITH u.id = p.usuarioId
                LEFT JOIN sgiiBundle:TblUsuarioProyecto tup WITH tup.proyectoId = p.id
                ";
        if($id != null) {
            $dql .= " WHERE p.id = :id";
        }
        $dql .= " GROUP BY p.id";
        $query = $this->em->createQuery($dql);
        
        if($id != null) {
            $query->setParameter('id', $id);
            $query->setMaxResults(1);
        }
        $query->setParameter('usuarioId', $usuarioId);
        $result = $query->getResult();
        
        if(count($result)>0) {
            if($id != null) {
                //Validar a que proyectos tiene acceso
                $auxResult = $this->getProyectosAcceso($result);
                if (count($auxResult)>0) {
                    $return = $auxResult[0];
                }
            }
            else {
                //Validar a que proyectos tiene acceso
                $return = $this->getProyectosAcceso($result);
                //$return = $result;
            }
        }
        return $return;
    }
    
    /**
     * Funcion que obtiene los proyectos a los que se tiene acceso
     * - Acceso desde TblProyectosController
     * Acceso
     * - Si es admin o superadmin = All
     * - Si es investigador = Pry en los que pertenece
     * - Si es estudiante = Ninguno
     * 
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @version 1
     * @param integer $id id del proyecto si busca uno en específico
     * @return array
     */
    public function getProyectosAcceso($proyectos)
    {
        $sess_usuario = $this->session->get('sess_usuario');
        $perfilId = $sess_usuario['perfilId'];
        if ($perfilId == 4)
        {
            return false;
        } 
        elseif ($perfilId == 3)
        {
            $arrayPry = Array();
            foreach($proyectos as $pry){
                if ($pry['pertenece'] == 1){
                    $arrayPry[] = $pry;
                }
            }
            return $arrayPry;
        }
        elseif ($perfilId == 2 || $perfilId == 1){
            return $proyectos;
        }
    }
    
    /**
     * Permiso de CRUD DE hipotesis, objetivos e integrantes y eliminacion del proyecto
     * 
     * Funcion que retorna si el usuario tiene acceso a
     * - CRUD OBJETIVOS
     * - CRUD INTEGRANTE
     * - CRUD HIPOTESIS
     * Se valida de la siguiente forma
     * Si el proyecto esta abierto, tiene permiso o
     * si el usuario tiene un rol diferente a investigador (admin o superadmin)
     * 
     * @param type $estado Estado actual del proyecto
     * @return boolean 1=> Permiso Activo 0=>No activo
     */
    public function permisoCRUDHipObjIntPry($estado)
    {
        $sess_usuario = $this->session->get('sess_usuario');
        $perfilId = $sess_usuario['perfilId'];
        
        //{% if (entity.proEstado == 1) or (sess_usuario.perfilId != 3) %}
        $return = false;
        if (($estado == 1) or ($perfilId != 3)) {
            $return = true;
        }
        return $return;
    }
    
    /**
     * Funcion que retorna el listado de usuarios incluidos en el proyecto
     * - acceso desde TblProyectoController
     * 
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @version 1
     * @param Integer $proyectoId Id del proyecto
     * @return Array Arreglo de usuarios del poyecto que ingresa por parametro
     */
    public function getUsuariosProyecto($proyectoId)
    {
        $dql = 'SELECT up.id, up.usuarioProyectoTipo, u.usuLog, u.usuNombre, u.usuApellido, u.id AS usuarioId
                FROM sgiiBundle:TblUsuarioProyecto up
                JOIN sgiiBundle:TblUsuario u WITH u.id = up.usuarioId
                WHERE up.proyectoId =:proyectoId
                ORDER BY up.usuarioProyectoTipo';
        $query = $this->em->createQuery($dql);
        $query->setParameter('proyectoId', $proyectoId);
        return $query->getResult();
    }
    
    /**
     * Funcion que retorna el listado de usuarios que no pertenecen al proyecto excepto usuarios tipo Usuario
     * - acceso desde TblProyectoController
     * 
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @version 1
     * @param Integer $proyectoId Id del proyecto
     * @return Array Arreglo de usuarios que no pertenecen al poyecto que ingresa por parametro
     */
    public function getNoUsuariosProyecto($proyectoId)
    {
        $dql = 'SELECT up.id, up.usuarioProyectoTipo, 
                    u.id AS usuarioId, u.usuLog, u.usuNombre, u.usuApellido, u.usuCedula, u.usuEstado, tup.perfilId
                FROM sgiiBundle:TblUsuario u
                LEFT JOIN sgiiBundle:TblUsuarioProyecto up WITH u.id = up.usuarioId AND up.proyectoId =:proyectoId
                LEFT JOIN sgiiBundle:TblUsuarioPerfil tup WITH tup.usuarioId = u.id
                WHERE up IS NULL AND tup.perfilId != 4
                GROUP BY u.id';
        $query = $this->em->createQuery($dql);
        $query->setParameter('proyectoId', $proyectoId);
        return $query->getResult();
    }
    
    /**
     * Funcion que retorna el listado de hipotesis incluidos en el proyecto
     * - acceso desde TblProyectoController
     * 
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @version 1
     * @param Integer $proyectoId Id del proyecto
     * @return Array Arreglo de hipotesis del poyecto que ingresa por parametro
     */
    public function getHipotesisProyecto($proyectoId)
    {
        $dql = 'SELECT h.hipHipotesis, h.hipEstado, h.id
                FROM sgiiBundle:TblHipotesis h
                WHERE h.proyectoId =:proyectoId';
        $query = $this->em->createQuery($dql);
        $query->setParameter('proyectoId', $proyectoId);
        return $query->getResult();
    }
    
    /**
     * Funcion que retorna el listado de objetivos general y específicos en el proyecto
     * - acceso desde TblProyectoController
     * 
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @version 1
     * @param Integer $proyectoId Id del proyecto
     * @return Array Arreglo de objetivos del poyecto que ingresa por parametro
     */
    public function getObjetivosProyecto($proyectoId)
    {
        $dql = 'SELECT o.objObjetivo, o.objEstado, o.proyectoId, o.objetivoId, o.id
                FROM sgiiBundle:TblObjetivo o
                WHERE o.proyectoId =:proyectoId';
        $query = $this->em->createQuery($dql);
        $query->setParameter('proyectoId', $proyectoId);
        return $query->getResult();
    }
    
    /**
     * Funcion que elimina los objetivos específicos del proyecto, entrando como parametro el Id del obj. general
     * - acceso desde TblProyectoController
     * 
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @version 1
     * @param Integer $objGeneral Id del objetivo gneral
     */
    public function deleteObjetivosEspecificos($objGeneral)
    {
        $dql = 'DELETE FROM sgiiBundle:TblObjetivo o
                WHERE o.objetivoId =:objetivoId';
        $query = $this->em->createQuery($dql);
        $query->setParameter('objetivoId', $objGeneral);
        return $query->getResult();
    }
    
    /**
     * Funcion que obtiene la cantidad de usuarios de la organización
     * 
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @param integer $id id de organizacion
     * @return Int cantidad de usuarios
     */
    public function getCountOrganizacion($id)
    {
        $dql = "SELECT COUNT(u.id) AS cantidad 
                FROM sgiiBundle:TblUsuario u
                JOIN sgiiBundle:TblOrganizacion o WITH u.organizacionId = o.id
                WHERE o.id=:organizacionId";
        $query = $this->em->createQuery($dql);
        $query->setParameter('organizacionId', $id);
        $query->setMaxResults(1);
        $result = $query->getResult();
        return $result[0]['cantidad'];
    }
    
    /**
     * Funcion que obtiene la cantidad de usuarios con este cargos
     * 
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @param integer $id id de cargo
     * @return Int cantidad de usuarios
     */
    public function getCountCargo($id)
    {
        $dql = "SELECT COUNT(u.id) AS cantidad 
                FROM sgiiBundle:TblUsuario u
                JOIN sgiiBundle:TblCargo c WITH u.cargoId = c.id
                WHERE c.id=:cargoId";
        $query = $this->em->createQuery($dql);
        $query->setParameter('cargoId', $id);
        $query->setMaxResults(1);
        $result = $query->getResult();
        return $result[0]['cantidad'];
    }
    
    /**
     * Funcion que obtiene la cantidad usuarios del departamento
     * 
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @param integer $id id de departamento
     * @return Int cantidad de usuarios
     */
    public function getCountDepartamento($id)
    {
        $dql = "SELECT COUNT(u.id) AS cantidad 
                FROM sgiiBundle:TblUsuario u
                JOIN sgiiBundle:TblDepartamento d WITH u.departamentoId = d.id
                WHERE d.id=:departamentoId";
        $query = $this->em->createQuery($dql);
        $query->setParameter('departamentoId', $id);
        $query->setMaxResults(1);
        $result = $query->getResult();
        return $result[0]['cantidad'];
    }
    
    /**
     * Funcion que obtiene la cantidad proyectos que tienen este estado
     * 
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @param integer $id id de estado de proyecto
     * @return Int cantidad de proyectos
     */
    public function getCountEstadosProyecto($id)
    {
        $dql = "SELECT COUNT(p.id) AS cantidad 
                FROM sgiiBundle:TblProyecto p
                WHERE p.estadoProyectoId=:id";
        $query = $this->em->createQuery($dql);
        $query->setParameter('id', $id);
        $query->setMaxResults(1);
        $result = $query->getResult();
        return $result[0]['cantidad'];
    }
    
    /**
     * Funcion que obtiene la cantidad proyectos que tienen esta linea de investigación
     * 
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @param integer $id id de la linea de investigacion
     * @return Int cantidad de proyectos
     */
    public function getCountLineaInvestigacion($id)
    {
        $dql = "SELECT COUNT(p.id) AS cantidad 
                FROM sgiiBundle:TblProyecto p
                WHERE p.lineaInvestigacionId=:id";
        $query = $this->em->createQuery($dql);
        $query->setParameter('id', $id);
        $query->setMaxResults(1);
        $result = $query->getResult();
        return $result[0]['cantidad'];
    }
    
    /**
     * Funcion que obtiene la cantidad proyectos que tienen este tipo de investigación
     * 
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @param integer $id id del tipo de investigacion
     * @return Int cantidad de proyectos
     */
    public function getCountTipoInvestigacion($id)
    {
        $dql = "SELECT COUNT(p.id) AS cantidad 
                FROM sgiiBundle:TblProyecto p
                WHERE p.tipoInvestigacionId=:id";
        $query = $this->em->createQuery($dql);
        $query->setParameter('id', $id);
        $query->setMaxResults(1);
        $result = $query->getResult();
        return $result[0]['cantidad'];
    }
    
    /**
     * Funcion que obtiene la cantidad proyectos en lo que esta un usuario
     * 
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @param integer $id id del usuario
     * @return Int cantidad de proyectos
     */
    public function getCountProyectos($id)
    {
        $dql = "SELECT COUNT(p.id) AS cantidad 
                FROM sgiiBundle:TblUsuarioProyecto up
                JOIN sgiiBundle:TblProyecto p WITH p.id = up.proyectoId
                WHERE up.usuarioId=:id OR p.usuarioId=:id";
        $query = $this->em->createQuery($dql);
        $query->setParameter('id', $id);
        $query->setMaxResults(1);
        $result = $query->getResult();
        return $result[0]['cantidad'];
    }
}
?>
