<?php

namespace sgii\sgiiBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TblDepartamentoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('depNombre', 'text', array('required' => true))
            ->add('depDescripcion', 'textarea', array('required' => false))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'sgii\sgiiBundle\Entity\TblDepartamento'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sgii_sgiibundle_tbldepartamento';
    }
}
