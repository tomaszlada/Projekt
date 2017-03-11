<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Calc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Description of CalcFormController
 *
 * @author Tomek
 */
class CalcFormController extends Controller {

    /**
     * @Route("/calc/", name="calcForm")
     */
    public function indexAction(Request $request) {
        $calc = new Calc();


        $form = $this->createForm(\AppBundle\Forms\CalcForm::class, $calc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $form->getData();

            $file = new Filesystem();
            try {
                $filename = 'wyniki.csv';
                $file->touch($filename);    
            } catch (IOExceptionInterface $e) {
                echo "Błąd podczas tworzenia pliku " . $e->getPath();
            }
            
            

            var_dump($calc);
            exit();
        }
        return $this->render('calc/indexCalcForm.html.twig', [
                    'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
                    'form' => $form->createView()
        ]);
    }

}
