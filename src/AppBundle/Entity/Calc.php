<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;

/**
 * Description of calc
 *
 * @author Tomek
 */
class Calc {

    private $var1;
    private $var2;

    function getVar1() {
        return $this->var1;
    }

    function getVar2() {
        return $this->var2;
    }

    function setVar1($var1) {
        $this->var1 = $var1;
    }

    function setVar2($var2) {
        $this->var2 = $var2;
    }

}
