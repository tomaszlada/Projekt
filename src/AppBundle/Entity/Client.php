<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Client
 *
 * @author tomasz_lada
 */
/**
 * @ORM\Entity
 * @ORM\Table(name="client")
 */
class Client {

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $client_id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $surname;

    /**
     * @ORM\Column(type="string")
     */
    private $pesel;

    
    public function __construct() {

    }
    /**
     * @return mixed
     */
    public function getClient_Id() {
        return $this->client_id;
    }

    /**
     * @param mixed $client_id
     */
    public function setClient_Id($client_id) {
        $this->client_id = $client_id;
    }

    /**
     * @return mixed
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSurname() {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     */
    public function setSurname($surname) {
        $this->surname = $surname;
    }

    /**
     * @return mixed
     */
    public function getPesel() {
        return $this->pesel;
    }

    /**
     * @param mixed $pesel
     */
    public function setPesel($pesel) {
        $this->pesel = $pesel;
    }

    public function __toString() {
        return "".$this->client_id;
    }
}
