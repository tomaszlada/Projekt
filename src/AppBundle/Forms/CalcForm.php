<?php

namespace AppBundle\Forms;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

/**
 * Description of CalcForm
 *
 * @author Tomek
 */
class CalcForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('var1', IntegerType::class, array('label' => 'Zmienna 1:'));
        $builder->add('func', ChoiceType::class, array('label' => 'Działanie :', 
            'choices' => array(
                'Dodawanie' => '+',
                'Odejmowanie' => '-',
                'Mnożenie' => '*',
                'Dzielenie' => '/')
            ));
        $builder->add('var2', IntegerType::class, array('label' => 'Zmienna 2:'));
        $builder->add('round', CheckboxType::class, array('label' => 'Zaokrąglij wynik: ', 'required' => false));
        $builder->add('Wynik', SubmitType::class);
    }

}
