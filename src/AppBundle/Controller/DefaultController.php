<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\PageInfo;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

    	$pageInfo = new PageInfo();
        $pageInfo->setTitle("nowy tytul");
        $pageInfo->setDescription("nowy opis");
        
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        	'pageInfo' => $pageInfo
        ]);
    }
    
    /**
     * @Route("/show/{id}/", name="showInfo", requirements={"id": "\d+"})
     */
    public function showAction(Request $request, $id)
    {
    	$pageInfo = new PageInfo();
    	$pageInfo->setTitle("nowy tytul ".$id);
    	$pageInfo->setDescription("nowy opis ");
    	return $this->render('default/index.html.twig', [
    			'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
    			'pageInfo' => $pageInfo
    	]);
    }
    
        /**
     * @Route("/index/", name="bootstrap")
     */
    public function bootstrapIndexAction(Request $request)
    {      
        return $this->render('index.html', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
}
