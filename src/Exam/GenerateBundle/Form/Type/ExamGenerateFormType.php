<?php

namespace Exam\GenerateBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;



class ExamGenerateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {        
        $builder
            ->add('sections', null,  array('expanded'=>true, 'multiple'=>true, 'required' => true))
            ->add('numberCandidates')
            ->add('level', null,  array('expanded'=>true, 'multiple'=>false, 'required' => true))
            ->add('numberQuestions')
            ->add('types', null,  array('expanded'=>true, 'multiple'=>true, 'required' => true))
            ->add('tags', null,  array('expanded'=>true, 'multiple'=>true, 'required' => true));      
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'            =>  'Exam\CoreBundle\Entity\ExamCriteria',
            'cascade_validation'    =>  true
        ));
    }
    
    public function getName()
    {
        return 'exam_generate_form_type';
    }
}
