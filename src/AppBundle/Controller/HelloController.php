<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HelloController extends Controller{
	

	/**
	 * @Route("/hello", name="hello_site")
	 */
	
	public function HelloAction(){
		return $this->render('hello/hello_site.html.twig', [
				'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
		]);
	}
	
	
	/**
	 * @Route("/byebye", name="byebye_site")
	 */
	public function ByeByeAction(){
		return $this->render('hello/byebye_site.html.twig', [
				'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
		]);
	}
}