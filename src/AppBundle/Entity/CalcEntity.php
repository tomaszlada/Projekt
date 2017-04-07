<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 *
 * @author tomasz_lada
 *        
 */

/**
 * @ORM\Entity
 * @ORM\Table(name="calc_result") 
 */
class CalcEntity {

    /**
     * @var string
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * 
     * @Assert\NotBlank()
     * @Assert\Type("integer")
     * 
     * @var integer
     * @ORM\Column(name="var1", type="integer")
     */
    private $var1;

    /**
     *
     * @var string
     * @ORM\Column(name="func", type="string", length=1)
     */
    private $func;

    /**
     * 
     * @Assert\NotBlank()
     * @Assert\Type("integer")
     * 
     * @var integer
     * @ORM\Column(name="var2", type="integer")
     */
    private $var2;

    /**
     * @var integer
     * @ORM\Column(name="result", type="float")
     */
    private $result;

    /**
     *
     * @var bool
     * @ORM\Column(name="round", type="boolean")
     */
    private $round;

    /**
     *
     * @var datetime
     * @ORM\Column(name="addDate", type="datetime")
     */
    private $date;

    public function __construct($var1, $func, $var2, $result, $round) {
        $this->var1 = $var1;
        $this->func = $func;
        $this->var2 = $var2;
        $this->result = $result;
        $this->round = $round;
        $this->date = new \DateTime("now");
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getVar1() {
        return $this->var1;
    }

    public function setVar1($var1) {
        $this->var1 = $var1;
    }

    public function getFunc() {
        return $this->func;
    }

    public function setFunc($func) {
        $this->func = $func;
    }

    public function getVar2() {
        return $this->var2;
    }

    public function setVar2($var2) {
        $this->var2 = $var2;
    }

    public function getResult() {
        return $this->result;
    }

    public function setResult($result) {
        $this->result = $result;
    }

    function getRound() {
        return $this->round;
    }

    function setRound($round) {
        $this->round = $round;
    }

    function getDate() {
        return $this->date;
    }
    
    function getAddDate(){
         return $this->date;
    }

    function setAddDate($date) {
        if ($date == NULL) {
            $this->date = new \DateTime("now");
        } else {
            $this->date = $date;
        }
    }
    
    function setDate($date) {
        if ($date == NULL) {
            $this->date = new \DateTime("now");
        } else {
            $this->date = $date;
        }
    }

    public function getDateAsObject() {
        // should be able to parse this format: Mar 2 2014 12:00:00:000AM
        return \DateTime::createFromFormat("Y-m-d H:i:s", $this->date);
    }

    public function __toString() {
        return $this->var1 . " " . $this->func . " " . " " . $this->var2 . " = " . $this->result;
    }

}
