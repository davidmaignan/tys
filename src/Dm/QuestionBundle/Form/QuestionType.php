<?php

namespace Dm\QuestionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                  'help' => 'test to translate',
            ))
            ->add('code')
            ->add('note')
            ->add('points')
            ->add('section')
            ->add('level')
            ->add('type')
            ->add('tags')
        ;
        
        $builder->add('answers', 'collection', array('type' => new AnswerType(),'by_reference' => true));
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Dm\QuestionBundle\Entity\Question',
            'cascade_validation' => true
        ));
    }

    public function getName()
    {
        return 'dm_questionbundle_questiontype';
    }
}
