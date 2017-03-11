<?php

namespace AppBundle\Forms;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Description of CalcForm
 *
 * @author Tomek
 */
class CalcForm extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('var1')->add('var2')->add('wynik', SubmitType::class);
    }
    
}
