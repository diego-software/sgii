<?php

namespace sgii\sgiiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TblEstadoProyectoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('eprEstadoProyecto', 'text', array('required' => true))
            ->add('eprEstado', 'checkbox', array('required' => false))
            ->add('eprDisponibleCierre')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'sgii\sgiiBundle\Entity\TblEstadoProyecto'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sgii_sgiibundle_tblestadoproyecto';
    }
}
