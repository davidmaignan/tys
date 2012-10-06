<?php

namespace Extensions\FormBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormViewInterface;
use Symfony\Component\Form\FormBuilderInterface;




use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormBuilder;

class HelpMessageTypeExtension extends AbstractTypeExtension
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->setAttribute('help', $options['help']);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->set('help', $form->getAttribute('help'));
    }

    public function getDefaultOptions()
    {
        return array(
            'help' => null,
        );
    }

    public function getExtendedType()
    {
        return 'field';
    }
}
