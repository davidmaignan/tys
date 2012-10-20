<?php

namespace Question\CreateBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Question\CreateBundle\Form\Type\AnswerFormType;

class QuestionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                  'help' => 'test to translate',
            ))
            ->add('code')
            ->add('user')
            ->add('note')
            ->add('points')
            ->add('section')
            ->add('level')
            ->add('type')
            ->add('tags')
        ;
        
        $builder->add('answers', 'collection', array('type' => new AnswerFormType(),'by_reference' => true));
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Core\QuestionBundle\Entity\Question',
            'cascade_validation' => true
        ));
    }

    public function getName()
    {
        return 'question_create_contributor_type';
    }
}
