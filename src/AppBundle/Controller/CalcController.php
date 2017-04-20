<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\CalcEntity;

/**
 *
 * @author tomasz_lada
 *        
 */
class CalcController extends Controller {

    /**
     * @Route("/calc/{var1}/{func}/{var2}/", name="calcAction" , 
     * requirements={
     * "var1": "\d+",
     * "var2": "\d+",
     * "func": "[+-:*]"
     * })
     */
    public function calcAction($var1, $func, $var2) {

        $calc = new CalcActionController();
        $calc->setVar1($var1);
        $calc->setFunc($func);
        $calc->setVar2($var2);
                
        
        switch ($func) {
            case '+':
                $calc->addAction();
                break;
            case '-':
                $calc->subtractAction();
                break;
            case '*':
                $calc->multiplyAction();
                break;
            case ':' || '/':
                $calc->divideAction();
                break;
            default:
                $calc->setResult("Działanie nie jest wspierane");
        }
        
 
        return $this->render('calc/index.html.twig', [
                    'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
                    'calc' => $calc,
        ]);
    }

    /**
     * @Route("/calc/info/", name="infoAction")
     */
    public function infoAction() {

        return $this->render('calc/infoCalc.html.twig', [
                    'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
        ]);
    }

}
