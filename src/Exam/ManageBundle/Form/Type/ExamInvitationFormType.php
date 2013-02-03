<?php

namespace Exam\ManageBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ExamInvitationFormType extends AbstractType {
    
    
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'examId',
            'hidden'
        );
        
        $builder->add('email');
        $builder->add('first_name');
        $builder->add('last_name');
    }
    
    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Exam\ManageBundle\Form\Model\ExamInvitationFormModel'
        ));
    }
   

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        //return 'exam_invitation';
        return 'exam_send_invitation';
    }
    
}
