<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CalcRepo
 *
 * @author tomasz_lada
 */

namespace AppBundle\Repository;

use AppBundle\Entity\CalcEntity;


class CalcRepo extends CalcEntity implements CalcRepoInterface {
  
    /**
     * 
     * @param CalcEntity $calculateResult
     * @return CalcEntity 
     */
    public function save(CalcEntity $calculateResult) {
        $this->getEntityManager()->persist($calculateResult);
        $this->getEntityManager()->flus();
    }
    
    /**
     * 
     * @param type $id
     * @return CalcEntity
     */
    public function findById($id) {
        return $this->findById($id);
    }
}
