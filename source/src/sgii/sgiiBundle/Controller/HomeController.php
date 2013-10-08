<?php
namespace sgii\sgiiBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * controlador para el homepage de la aplicacion.
 * 
 * @Route("/home")
 * @package CuentaBundle/Controller
 */
class HomeController extends Controller
{
    
    /**
     * Index para la aplicacion
     * 
     * @Route("/", name="homepage")
     * @author Diego Malagón <diego-software@hotmail.com>
     * @return Resonse
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $usuarios = $em->getRepository("sgiiBundle:TblUsuario")->findAll();
        
        echo "<pre>";
        print_r($usuarios);
        echo "</pre>";
        
        return $this->render('sgiiBundle:Home:index.html.twig', array());
    }
    
}

?>
