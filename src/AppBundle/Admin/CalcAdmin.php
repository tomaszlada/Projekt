<?php

/**
 * Description of Admin
 *
 * @author tomasz_lada
 */

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\Type\Filter\ChoiceType;

class CalcAdmin extends AbstractAdmin {

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->add('var1', 'integer', array('label' => 'var1'))
               // ->add('func', 'text', array('label' => 'func'))
                ->add('func', 'choice', array(
                        'choices' => 
                    array('+ - Dodawanie' => '+', 
                        '- - Odejmowanie' => '-',
                        '* - Mnożenie' => '*',
                        '/ - Dzielenie' => '/',)))
                ->add('var2', 'integer', array('label' => 'var2'))
                ->add('result', 'text', array('label' => 'result'))
                ->add('round', null, array('required' => false))
                ->add('addDate', 'datetime', array('label' => 'addDate'))

        // if no type is specified, SonataAdminBundle tries to guess it
        // ->add('body')
        // ...
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('id')
                ->add('func')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('id')
                ->add('var1')
                ->add('func')
                ->add('var2')
                ->add('result')
                ->add('round')

        ;
    }

    // Fields to be shown on show action
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('id')
                ->add('func')

        ;
    }

}
