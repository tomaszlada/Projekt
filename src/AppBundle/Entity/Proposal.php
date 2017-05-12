<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Proposal
 *
 * @author tomasz_lada
 */

/**
 * @ORM\Entity
 * @ORM\Table(name="proposal")
 */
class Proposal {

    /**
     * @var integer
     * @ORM\Column(type="guid")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    protected $id;

    /**
     * @var integer
     * @ORM\Column(name="loan_amount", type="integer")
     */
    private $loan_amount;

    /**
     * @var integer
     * @ORM\Column(name="loan_duration", type="integer")
     */
    private $loan_duration;

    /**
     * @var string
     * @ORM\Column(name="phone_number", type="string", length=9 )
     */
    private $phone_number;

    /**
     * @var string
     * @ORM\Column(name="email", type="string", length=255 )
     */
    private $email;

    /**
     * @var DateTime
     * @ORM\Column(name="date_add", type="datetime")
     */
    private $date_add;

    /**
     *
     * @var integer
     * @ORM\Column(name="state", type="integer")
     */
    private $state;

    /**
     * @ORM\ManyToOne(targetEntity="Client",fetch="EAGER")
     * @ORM\JoinColumn(name="client_id",referencedColumnName="client_id", nullable=true)
     */
    private $client_id;

    /**
     * @return string
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * @return integer
     */
    public function getLoanAmount() {
        return $this->loan_amount;
    }

    /**
     * @param integer $loan_amount
     */
    public function setLoanAmount($loan_amount) {
        $this->loan_amount = $loan_amount;
    }

    /**
     * @return integer
     */
    public function getLoanDuration() {
        return $this->loan_duration;
    }

    /**
     * @param integer $loan_duration
     */
    public function setLoanDuration($loan_duration) {
        $this->loan_duration = $loan_duration;
    }

    /**
     * @return string
     */
    public function getPhoneNumber() {
        return $this->phone_number;
    }

    /**
     * @param string $phone_number
     */
    public function setPhoneNumber($phone_number) {
        $this->phone_number = $phone_number;
    }

    /**
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    /**
     * @return DateTime
     */
    public function getDateAdd() {
        return $this->date_add;
    }

    /**
     * @param DateTime $date_add
     */
    public function setDateAdd(DateTime $date_add) {
        $this->date_add = $date_add;
    }

    /**
     * @param integer $state
     */
    function getState() {
        return $this->state;
    }

    function setState($state) {
        $this->state = $state;
    }

    /**
     * @return Client
     */
    public function getClientId() {
        return $this->client_id;
    }

    public function setClientId($client_id) {
        $this->client_id = $client_id;
    }

}
