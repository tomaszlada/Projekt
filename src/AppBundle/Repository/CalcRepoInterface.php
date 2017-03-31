<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author tomasz_lada
 */

namespace AppBundle\Repository;

use AppBundle\Entity\CalcEntity;


/**
 * 
 */
interface CalcRepoInterface {

    /**
     * 
     * @param CalcEntity $calculateResult
     * @return CalcEntity 
     */
    public function save(CalcEntity $calculateResult);
    
    /**
     * 
     * @param type $id
     * @return CalcEntity 
     */
    public function findById($id);

}
