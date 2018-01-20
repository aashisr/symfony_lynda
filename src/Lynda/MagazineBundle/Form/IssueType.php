<?php

namespace Lynda\MagazineBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IssueType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number')
            ->add('datePublication', 'date', array(
                'years' => range(date('Y'), date('Y', strtotime('-50 years'))),
                'required' => TRUE,
            ))
            ->add('file')
                //Publication is an entity
            ->add('publication', 'entity', array(
                'required' => TRUE,
                'class' => 'LyndaMagazineBundle:Publication',
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lynda\MagazineBundle\Entity\Issue'
        ));
    }
}
