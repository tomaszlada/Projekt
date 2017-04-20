<?php

namespace AppBundle\Controller;

use AppBundle\Entity\CalcEntity;
/**
 * Description of CalcActionController
 *
 * @author Tomek
 */
class CalcActionController extends CalcEntity{
      
    private $calc;
          
    public function __construct() {
        $this->calc = new CalcEntity(NULL, NULL, NULL, NULL, NULL);
    }

    public function __construct1($var1, $func, $var2) {
        $this->calc = new CalcEntity($var1, $func, $var2, NULL, NULL);
    }
    
    public function addAction() {
        return $this->setResult($this->getVar1() + $this->getVar2());
    }

    public function subtractAction() {
        return $this->setResult($this->getVar1() - $this->getVar2());
    }

    public function multiplyAction() {
        return $this->setResult($this->getVar1() * $this->getVar2());
    }

    public function divideAction() {
        if ($this->getVar2() == 0) {
            return $this->setResult("nie można dzielić przez ZERO");
        } else {
            return $this->setResult($this->getVar1() / $this->getVar2());
        }
    }
    
    public function roundAction(){
        return $this->setResult(round($this->getResult(), 0, PHP_ROUND_HALF_UP));
    }
    
    public function __toString() {
        return $this->getVar1() . " " . $this->getFunc() . " " . " " . $this->getVar2() . " = " . $this->getResult();
    }
    
    /*
    function getCalc() {
        return $this->calc;
    }

    function setCalc($calc) {
        $this->calc = $calc;
    }
    */
}
