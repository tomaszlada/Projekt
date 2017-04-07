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
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class Admin extends AbstractAdmin {

    protected function configureFormFields(FormMapper $formMapper) {
        $formMapper
                ->add('username', 'text', array('label' => 'username'))
                ->add('email', 'text', array('label' => 'email'))
                ->add('plainPassword', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'first_options'  => array('label' => 'Password'),
                    'second_options' => array('label' => 'Repeat Password'),))                
                ->add('last_login', 'datetime', array('label' => 'last_login'))
                ->add('enabled', null, array('required' => false))
                ->add('roles')

        // if no type is specified, SonataAdminBundle tries to guess it
        // ->add('body')
        // ...
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper) {
        $datagridMapper
                ->add('username')
                ->add('email')
                ->add('enabled')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper) {
        $listMapper
                ->addIdentifier('username')
                ->add('email')
                ->add('enabled')
        ;
    }

    // Fields to be shown on show action
    protected function configureShowFields(ShowMapper $showMapper) {
        $showMapper
                ->add('username')
                ->add('email')
                ->add('enabled')
                ->add('last_login')
                ->add('roles')
        ;
    }

}
