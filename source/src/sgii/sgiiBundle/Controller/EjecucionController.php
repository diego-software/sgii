<?php
namespace sgii\sgiiBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * controlador para la ejecucion de un instrumento
 * 
 * @Route("/ejecucion")
 */
class EjecucionController extends Controller
{
    /**
     * Index para la ejecucion de instrumento
     * 
     * @Route("/{id}", name="ejecucion_instrumento")
     * @Template("sgiiBundle:Ejecucion:index.html.twig")
     * @author Diego Malagón <diego-software@hotmail.com>
     * @return Response
     */
    public function indexAction(Request $request, $id)
    {
        $security = $this->get('security');
        if(!$security->autentication()){ return $this->redirect($this->generateUrl('login'));}
//        if(!$security->autorization($this->getRequest()->get('_route'))){ throw $this->createNotFoundException("Acceso denegado");}
        
        $usuarioId = $security->getSessionValue('id');
        
        $participo = $this->usuarioParticipoInstrumento($id, $usuarioId);
        $instrumento = false;
        $preguntas = false;
        
        if(!$participo['invitado']) // si no esta invitado al instrumento
        {
            throw $this->createNotFoundException("Acceso denegado");
        }
        
        if(!$participo['participo']) // si no ha participado
        {
            $instrumento = $this->getInstrumento($id);
            
            if($instrumento)
            {
                $preguntas = $this->getPreguntas($id);
            }
            
            $form = $this->createFormBuilder()->getForm(); 
            
            
        }
        
        return array(
            'id' => $id,
            'form' => $form->createView(), 
            'participo' => $participo['participo'],
            'instrumento' => $instrumento,
            'preguntas' => $preguntas
        );
    }
    
    /**
     * Accion para procesar el formulario del cuestionario
     * 
     * @Route("/{id}/procesar", name="procesar_ejecucion_instrumento")
     * @Method({"POST"})
     * @author Diego Malagón <diego-software@hotmail.com>
     * @return Response
     */
    public function procesarAction(Request $request, $id)
    {
        $security = $this->get('security');
        if(!$security->autentication()){ return $this->redirect($this->generateUrl('login'));}
//        if(!$security->autorization($this->getRequest()->get('_route'))){ throw $this->createNotFoundException("Acceso denegado");}
        
        $form = $this->createFormBuilder()->getForm();
        
        if($request->getMethod() == 'POST')
        {
            $form->bind($request);
            if ($form->isValid())
            {
                $data = $request->get('preguntas');
                echo "correcto";
                $security->debug($data);
            }
        }        
        
        return new Response();
    }
    
    /**
     * Funcion que obtiene si el usuario esta invitado y/o participado en un instrumento
     * 
     * @param integer $instrumentoId id de instrumento
     * @param integer $usuarioId id de usuario
     * @return array
     */
    private function usuarioParticipoInstrumento($instrumentoId, $usuarioId)
    {
        $participo = false;
        $invitado = false;
        
        $em = $this->getDoctrine()->getManager();
        
        $dql = "SELECT uh.ushAplico 
                FROM sgiiBundle:TblUsuarioHerramienta uh
                WHERE uh.usuario = :usuarioId
                    AND uh.herramienta = :instrumentoId
                  ";
        $query = $em->createQuery($dql);
        $query->setParameter('usuarioId', $usuarioId);
        $query->setParameter('instrumentoId', $instrumentoId);
        $query->setMaxResults(1);
        $result = $query->getResult();
        
        if(count($result)>0)
        {
            $invitado = true;
            $participo = $result[0]['ushAplico'];
        }
        
        return array(
            'invitado' => $invitado,
            'participo' => $participo
        );
    }
    
    /**
     * Funcion que retorna un instrumento si esta activo
     * 
     * @param integer $id id de instrumento
     * @return array|false
     */
    private function getInstrumento($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $dql = "SELECT
                    h.herNombreHerramienta,
                    th.theNombreHerramienta,
                    p.proNombre
                FROM 
                    sgiiBundle:TblHerramienta h
                    JOIN sgiiBundle:TblUsuarioHerramienta uh WITH uh.herramienta = h.id
                    JOIN sgiiBundle:TblTipoHerramienta th WITH h.tipoHerramienta = th.id
                    LEFT JOIN sgiiBundle:TblProyecto p WITH h.proyecto = p.id
                WHERE
                    h.id = :instrumentoId
                    AND h.herEstado = 1
                    AND (uh.ushFechaActivoInicio <= :current_date OR uh.ushFechaActivoInicio IS NULL)
                    AND (uh.ushFechaActivoFin >= :current_date OR uh.ushFechaActivoFin IS NULL)
                ";
        $query = $em->createQuery($dql);
        $query->setParameter('instrumentoId', $id);
        $query->setParameter('current_date', new \DateTime());
        $query->setMaxResults(1);
        $result = $query->getResult();
        
        $return = false;
        
        if(count($result)>0)
        {
            $return = $result[0];
        }
        
        
        return $return;
    }
        
    /**
     * Funcion para obtener las preguntas del instrumento
     * 
     * @param integer $instrumentoId id de instrumento
     * @return array arreglo de preguntas
     */
    private function getPreguntas($instrumentoId)
    {
        $preguntas = array();
        
        $em = $this->getDoctrine()->getManager();
        
        $dql = "SELECT
                    p.id,
                    p.prePregunta,
                    p.preObligatoria,
                    tp.id tipoId,
                    tp.tprTipoPregunta
                FROM
                    sgiiBundle:TblPregunta p
                    JOIN sgiiBundle:TblTipoPregunta tp WITH p.tipoPregunta = tp.id
                WHERE 
                    p.herramienta = :instrumentoId
                    AND p.preEstado = 1
                ORDER BY p.preOrden
                    ";
        $query = $em->createQuery($dql);
        $query->setParameter("instrumentoId", $instrumentoId);
        $result_preguntas = $query->getResult();
        
        
        
        // Crear array con ids por keys y array de ids para consultar preguntas
        if(count($result_preguntas)>0)
        {
            $ids = array();
            foreach($result_preguntas as $p)
            {
                $preguntas[$p['id']] = $p;
                $ids[] = $p['id'];
            }
            
            // Consultar las opciones de respuesta de las preguntas
            $dql = "SELECT
                        r.id,
                        r.resRespuesta,
                        r.pregunta
                    FROM
                        sgiiBundle:TblRespuesta r
                    WHERE 
                        (r.pregunta = ".implode(" OR r.pregunta = ", $ids).") ";
            $query = $em->createQuery($dql);
            $result_opciones = $query->getResult();
            
            
            // Agregar resultado de respuestas a cada pregunta
            
            foreach($result_opciones as $o)
            {
                $preguntas[$o['pregunta']]['opciones'][] = $o; 
            }            
        }
        
        
        
        return $preguntas;
    }
    
}

