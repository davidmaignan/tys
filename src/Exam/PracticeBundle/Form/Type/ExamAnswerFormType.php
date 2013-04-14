<?php

namespace Exam\PracticeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ExamAnswerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('answer')
        ;
        /*
        $builder->add(
            'exam',
            'entity',
            array(
                'class' => 'Exam\CoreBundle\Entity\Exam',
            )
        );
        
        $builder->add(
            'user',
            'entity',
            array(
                'class' => 'Security\AuthenticateBundle\Entity\User',
            )
        );
        
        $builder->add(
            'question',
            'entity',
            array(
                'class' => 'Core\QuestionBundle\Entity\Question',
            )
        );
         */
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'            =>  'Exam\PracticeBundle\Form\Model\ExamAnswerFormModel',
            'cascade_validation'    =>  true
        ));
    }
    
    public function getName()
    {
        return 'exam_answer_form_type';
    }
}
