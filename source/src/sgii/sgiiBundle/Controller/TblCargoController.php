<?php

namespace sgii\sgiiBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use sgii\sgiiBundle\Entity\TblCargo;
use sgii\sgiiBundle\Form\TblCargoType;

/**
 * Controlador de cargos
 * @package sgiiBundle/Controller
 * @Route("/cargo")
 */
class TblCargoController extends Controller
{
    /**
     * Listado de cargos
     * 
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @version 1
     * @Method("GET")
     * @return Render ViewRender de listado de cargos
     * @Template("sgiiBundle:TblCargo:index.html.twig")
     * @Route("/", name="cargo")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('sgiiBundle:TblCargo')->findAll();
        return array( 'entities' => $entities );
    }

    /**
     * Ver detalles del cargo
     *
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @version 1
     * @Method("GET")
     * @param Int $id Id del cargo
     * @return Render Vista renderizada con detalles del cargo
     * @Template("sgiiBundle:TblCargo:show.html.twig")
     * @Route("/{id}/show", name="cargo_show")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('sgiiBundle:TblCargo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TblCargo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }
    
    /**
     * Agregar cargo
     *
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @version 1
     * @param \Symfony\Component\HttpFoundation\Request $request Form de nuevo cargo
     * @return Render Formulario de nuevo cargo
     * @Template("sgiiBundle:TblCargo:new.html.twig")
     * @Route("/new", name="cargo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $entity = new TblCargo();
        $form  = $this->createForm(new TblCargoType(), $entity);
        
        if ($request->getMethod() == "POST")
        {
            $form->bind($request);
            if ($form->isValid()) 
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();

                $this->get('session')->getFlashBag()->add('alerts', array("type" => "information", "text" => "Nuevo cargo agregado"));
                return $this->redirect($this->generateUrl('cargo_show', array('id' => $entity->getId())));
            }
            $this->get('session')->getFlashBag()->add('alerts', array("type" => "error", "text" => "Verifique los datos ingresados"));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Editar cargo
     *
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @version 1
     * @param \Symfony\Component\HttpFoundation\Request $request Form del cargo a editar
     * @return Render Formulario del cargo a editar
     * @Template("sgiiBundle:TblCargo:edit.html.twig")
     * @Route("/{id}/edit", name="cargo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('sgiiBundle:TblCargo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TblCargo entity.');
        }

        $editForm = $this->createForm(new TblCargoType(), $entity);
        //$deleteForm = $this->createDeleteForm($id);
        
        if ($request->getMethod() == 'POST')
        {
            $editForm->bind($request);
            if ($editForm->isValid()) 
            {
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('alerts', array("type" => "information", "text" => "El cargo ha sido editado correctamente"));
                return $this->redirect($this->generateUrl('cargo_show', array('id' => $id)));
            }
            $this->get('session')->getFlashBag()->add('alerts', array("type" => "error", "text" => "Verifique los datos ingresados"));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            //'delete_form' => $deleteForm->createView(),
        );
    }
    
    /**
     * Borrar una cargo
     * 
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @version 1
     * @param \Symfony\Component\HttpFoundation\Request $request Form de eliminar del cargo
     * @param Int $id Id del cargo a eliminar
     * @return Redirect Redirigir a listado de cargos
     * @Route("/{id}", name="cargo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('sgiiBundle:TblCargo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TblCargo entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('alerts', array("type" => "information", "text" => "El cargo ha sido eliminado correctamente"));
        }

        return $this->redirect($this->generateUrl('cargo'));
    }

    /**
     * Creación de formulario para eliminar un cargo
     * @author Camilo Quijano <camiloquijano31@hotmail.com>
     * @version 1
     * @param Int $id Id del cargo
     * @return \Symfony\Component\Form\Form Formulario de eliminacion
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cargo_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->add('submit', 'button', array('label' => 'Eliminar', 'attr' => array('class' => 'btn btn-primary confirm')))
            ->getForm();
    }
}