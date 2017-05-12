<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Forms;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ClientForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {

        $builder->add('name', TextType::class, array('label' => 'Imię:'));
        /*
          $builder->add('func', ChoiceType::class, array('label' => 'Działanie :',
          'choices' => array(
          'Dodawanie' => '+',
          'Odejmowanie' => '-',
          'Mnożenie' => '*',
          'Dzielenie' => '/')
          ));
          $builder->add('var2', IntegerType::class, array('label' => 'Zmienna 2:'));
         */
        $builder->add('surname', TextType::class, array('label' => 'Nazwisko:'));
        $builder->add('pesel', IntegerType::class, array('label' => 'PESEL:'));
        $builder->add('Zatwierdź', SubmitType::class);
    }

}
