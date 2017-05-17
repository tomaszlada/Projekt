<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\Paginator;
use AppBundle\Entity\Proposal;
use AppBundle\Forms\ProposalForm;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Description of ListController
 *
 * @author tomasz_lada
 */
class ProposalController extends Controller {

    /**
     * @Route("/proposal_list", name="proposal_list")
     */
    public function proposalActionList(Request $request) {

        $repository = $this->getDoctrine()->getRepository('AppBundle:Proposal');
        $query = $repository->createQueryBuilder('p')
                ->orderBy('p.id', 'ASC')
                ->getQuery();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $query, /* query NOT result */ $request->query->getInt('page', 1)/* page number */, 5/* limit per page */
        );

        //$client_list = $query->getResult();
        //var_dump($client_list);

        return $this->render('list/proposal_list.html.twig', [
                    'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
                    //'list' => $client_list,
                    'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/add_proposal", name="add_proposal")
     */
    public function addProposalAction(Request $request) {

        $proposal = new Proposal();
        $form = $this->createForm(ProposalForm::class, $proposal);
        $form->handleRequest($request);
        //var_dump($proposal);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($proposal);
            $em->flush();
            return $this->redirectToRoute('proposal_list');
        }

        return $this->render('list/proposal.html.twig', [
                    'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete_proposal/{proposal_id}", name="delete_proposal",
     * requirements={
     * "proposal_id": "\d+"
     * })
     */
    public function deleteProposalAction(Request $request, $proposal_id) {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Proposal')->findOneBy(array('id' => $proposal_id));

        if ($entity != null) {
            $em->remove($entity);
            $em->flush();
        }
        return $this->redirectToRoute('proposal_list');
    }

    /**
     * @Route("/edit_proposal/{proposal_id}", name="edit_proposal",
     * requirements={
     * "proposal_id": "\d+"
     * })
     */
    public function editProposalAction(Request $request, $proposal_id) {

        $repository = $this->getDoctrine()->getRepository('AppBundle:Proposal');
        $proposal = $repository->findOneById($proposal_id);
        //var_dump($proposal);

        $form = $this->createForm(ProposalForm::class, $proposal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($proposal);
            $em->flush();
            return $this->redirectToRoute('proposal_list');
        }


        return $this->render('list/proposal.html.twig', [
                    'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/print_proposal/{proposal_id}", name="print_proposal",
     * requirements={
     * "proposal_id": "\d+"
     * })
     */
    public function printClientAction(Request $request, $proposal_id) {


        $em = $this->getDoctrine()->getEntityManager();
        $proposal = $em->getRepository('AppBundle:Proposal')->find($proposal_id);


        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $header = $phpWord->addSection();
        $header->addText("Id Wniosku: " . $proposal->getId());
        $header->addText("Wysokość pożyczki: " . $proposal->getLoanAmount());
        $header->addText("Długość pożyczki: " . $proposal->getLoanDuration());
        $header->addText("Numer telefonu: " . $proposal->getPhoneNumber());
        $header->addText("Email: " . $proposal->getEmail());
        $header->addText("Data dodania: " . $proposal->getDateAdd()->format('Y-m-d H:i:s'));
        $header->addText("Stan: " . $proposal->getState());

        /*
          $section = $phpWord->addSection();


          $section->addText(
          '"Learn from yesterday, live for today, hope for tomorrow. '
          . 'The important thing is not to stop questioning." '
          . '(Albert Einstein)'
          );


          // Adding Text element with font customized inline...
          $section->addText(
          '"Great achievement is usually born of great sacrifice, '
          . 'and is never the result of selfishness." '
          . '(Napoleon Hill)', array('name' => 'Tahoma', 'size' => 10)
          );

          // Adding Text element with font customized using named font style...
          $fontStyleName = 'oneUserDefinedStyle';
          $phpWord->addFontStyle(
          $fontStyleName, array('name' => 'Tahoma', 'size' => 10, 'color' => '1B2232', 'bold' => true)
          );
          $section->addText(
          '"The greatest accomplishment is not in never falling, '
          . 'but in rising again after you fall." '
          . '(Vince Lombardi)', $fontStyleName
          );

          // Adding Text element with font customized using explicitly created font style object...
          $fontStyle = new \PhpOffice\PhpWord\Style\Font();
          $fontStyle->setBold(true);
          $fontStyle->setName('Tahoma');
          $fontStyle->setSize(13);
          $myTextElement = $section->addText('"Believe you can and you\'re halfway there." (Theodor Roosevelt)');
          $myTextElement->setFontStyle($fontStyle);
         */
// Saving the document as OOXML file...
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        /*
          // Saving the document as ODF file...
          $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'ODText');
          $objWriter->save('helloWorld.odt');

          // Saving the document as HTML file...
          $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
          $objWriter->save('downloads/helloWorld.html');
         */

        $fileName = 'proposal_file.docx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);

        // Write in the temporal filepath
        $objWriter->save($temp_file);


        $response = new BinaryFileResponse($temp_file);
        $response->setContentDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT, $fileName
        );


        return $response;
    }

    /**
     * @Route("/print_proposal_list/", name="print_proposal_list")
     */
    public function printProposalListAction(Request $request) {
        $em = $this->getDoctrine()->getEntityManager();
        $proposal = $em->getRepository('AppBundle:Proposal')->findAll();

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $header = $phpWord->addSection();

        foreach ($proposal as $p) {
            $header->addText("Id Wniosku: " . $p->getId());
            $header->addText("Wysokość pożyczki: " . $p->getLoanAmount());
            $header->addText("Długość pożyczki: " . $p->getLoanDuration());
            $header->addText("Numer telefonu: " . $p->getPhoneNumber());
            $header->addText("Email: " . $p->getEmail());
            $header->addText("Data dodania: " . $p->getDateAdd()->format('Y-m-d H:i:s'));
            $header->addText("Stan: " . $p->getState());
            $header->addText("______________________________________________________");
        }
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        $fileName = 'proposal_file.docx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);

        // Write in the temporal filepath
        $objWriter->save($temp_file);

        $response = new BinaryFileResponse($temp_file);
        $response->setContentDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT, $fileName
        );

        return $response;
    }

}
