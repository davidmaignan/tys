<?php
namespace Dm\QuestionBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;

class QuestionAdmin extends Admin
{
  protected function configureFormFields(FormMapper $formMapper)
  {
    $formMapper
      ->add('title')
      ->add('code', null, array('required'=>false))
      ->add('note', null, array('required' => false))
      ->add('section', null, array('required' => false))
      ->add('level', null, array('required' => false))
      ->add('type', null, array('required' => false))
    ;
  }
  /*
  protected function configureDatagridFilters(DatagridMapper $datagridMapper)
  {
    $datagridMapper
      ->add('title')
    ;
  }
   * 
   */

  protected function configureListFields(ListMapper $listMapper)
  {
    $listMapper
      ->add('id')
      ->addIdentifier('title')
      ->add('section')
      ->add('level')
      ->add('type')      
    ;
  }

  public function validate(ErrorElement $errorElement, $object)
  {
    //$errorElement
    //  ->with('title')
    //  ->assertMaxLength(array('limit' => 32))
    //  ->end()
    ;
  }
}
