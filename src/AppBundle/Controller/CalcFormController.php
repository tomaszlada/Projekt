<?php

namespace AppBundle\Controller;

use AppBundle\Forms\CalcForm;
use AppBundle\Entity\CalcEntity;
use AppBundle\Controller\FileController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;

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


        $calc = new CalcActionController();
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


            $calc->setDate(null);
            $c = new CalcEntity($calc->getVar1(), $calc->getFunc(), $calc->getVar2(), 
                $calc->getResult(), $calc->getRound());
              //echo $c;
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($c);
            $em->flush();

            FileController::saveFile("wyniki.csv", $calc);
        }

        $repository = $this->getDoctrine()->getRepository('AppBundle:CalcEntity');
        $query = $repository->createQueryBuilder('r')
                ->orderBy('r.result', 'ASC')
                ->getQuery();

        $calcDB = $query->getResult();
        
        
        $history = FileController::readFile('wyniki.csv');
       
         
        return $this->render('calc/indexCalcForm.html.twig', [
                    'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
                    'form' => $form->createView(),
                    'history' => $history,
                    'historyDB' => $calcDB,
        ]);
    }

}
