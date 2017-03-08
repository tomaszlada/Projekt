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
	 * @Route("/calc", name="calcHomepage")
	 */
	
	public function indexAction(Request $request)
	{
		return $this->render('calc/index.html.twig', [
				'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
		]);
		
	}
	
	
	/**
	 * @Route("/calc/{var1}/{func}/{var2}/", name="calcAction" , 
	 * requirements={
	 * "var1": "\d+",
	 * "var2": "\d+",
	 * "func": "[+-:*]"
	 * })
	 */
	public function calcAction($var1, $func, $var2){
		
		$calc = new CalcEntity();
		$calc->setVar1($var1);
		$calc->setFunc($func);
		$calc->setVar2($var2);
		

			switch ($func) {
				case '+': 
					$calc->setResult($var1 + $var2);
					break;
				case '-':
					$calc->setResult($var1 - $var2);
					break;
				case '*':
					$calc->setResult($var1 * $var2);
					break;
				case ':' || '/':
					if ($var2 == 0){
						$calc->setResult("nie mo¿na dzieliæ przez ZERO");
					}else{
						$calc->setResult($var1 / $var2);
					}
					break;
				default:
					$calc->setResult("Dzia³anie nie jest wspierane");
			}				
		
		return $this->render('calc/index.html.twig', [
				'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
				'calc' => $calc,
			]);
	}
}
