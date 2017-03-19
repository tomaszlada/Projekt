<?php

namespace AppBundle\Controller;

use AppBundle\Forms\CalcForm;
use AppBundle\Controller\FileController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


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

        $calc = new CalcActionController(null, null, null);
        $form = $this->createForm(CalcForm::class, $calc);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {


            switch ($calc->getFunc()) {
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

            if ($calc->getRound()) {
                $calc->roundAction();
            }

            //$form->getData();

            FileController::saveFile("wyniki.csv", $calc);
            /*
            $em = $this->getDoctrine()->getManager();
            $em->persist($calc);
            $em->flush();
             * 
             */
        }
        
        //$history = FileController::showHistory(FileController::readFile('wyniki.csv'));
        $history = FileController::readFile('wyniki.csv');
        return $this->render('calc/indexCalcForm.html.twig', [
                    'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
                    'form' => $form->createView(),
                    'history' => $history,
        ]);
    }
    


}
