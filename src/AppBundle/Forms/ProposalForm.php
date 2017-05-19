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
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;

class ProposalForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {


        $builder
                ->add('client_id', 'entity', array(
                    'class' => 'AppBundle\Entity\Client',
                    'label' => 'ID Klienta',
                    'multiple' => false,
                    'constraints' => array(
                        new NotBlank(array('message' => 'Please choose atleast one student'))
                    )
        ));
        //$builder->add('loan_amount', IntegerType::class, array('label' => 'Wysokość pożyczki:'));
        $builder->add('loan_amount', RangeType::class, array(
            'label' => 'Wysokość pożyczki:',
            'attr' => array(
                'min' => 0,
                'max' => 10000,
                'step' => 50,
                'value' => 2000,
            )
        ));
        //$builder->add('loan_duration', IntegerType::class, array('label' => 'Długość pożyczki:'));
        $builder->add('loan_duration', RangeType::class, array(
            'label' => 'Długość pożyczki:',
            'attr' => array(
                'min' => 1,
                'max' => 24,
                'step' => 1,
                'value' => 1,
            )
        ));
        $builder->add('phone_number', IntegerType::class, array('label' => 'Numer telefonu'));
        $builder->add('email', TextType::class, array('label' => 'Email:'));
        $builder->add('date_add', DateTimeType::class, array('label' => 'Data:', 'data' => new \DateTime("now")));
        $builder->add('state', CheckboxType::class, array('label' => 'Stan: ', 'required' => false));
        $builder->add('Zatwierdź', SubmitType::class, array(
            'attr' => array('class' => 'btn btn-success'),
        ));
    }

}
