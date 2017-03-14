<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * @author tomasz_lada
 *        
 */
class CalcEntity {

    /**
     * @Assert\NotBlank()
     * @Assert\Type("integer")
     */
    private $var1;
    private $func;

    /**
     * @Assert\NotBlank()
     * @Assert\Type("integer")
     */
    private $var2;
    private $result;
    private $round;

    public function __constructor($var1, $var2, $result) {
        $this->var1 = $var1;
        $this->var2 = $var2;
        $this->result = $result;
    }

    public function getVar1() {
        return $this->var1;
    }

    public function setVar1($var1) {
        $this->var1 = $var1;
        return $this;
    }

    public function getFunc() {
        return $this->func;
    }

    public function setFunc($func) {
        $this->func = $func;
        return $this;
    }

    public function getVar2() {
        return $this->var2;
    }

    public function setVar2($var2) {
        $this->var2 = $var2;
        return $this;
    }

    public function getResult() {
        return $this->result;
    }

    public function setResult($result) {
        $this->result = $result;
        return $this;
    }

    function getRound() {
        return $this->round;
    }

    function setRound($round) {
        $this->round = $round;
    }

    public function __toString() {
        return $this->var1 . " " . $this->func . " " . " " . $this->var2 . " = " . $this->result;
    }

}
