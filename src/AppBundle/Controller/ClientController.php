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
use AppBundle\Entity\Client;
use AppBundle\Forms\ClientForm;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Description of ClientController
 *
 * @author tomasz_lada
 */
class ClientController extends Controller {

    /**
     * @Route("/client_list", name="client_list")
     */
    public function clientActionList(Request $request) {

        $repository = $this->getDoctrine()->getRepository('AppBundle:Client');
        $query = $repository->createQueryBuilder('c')
                ->orderBy('c.client_id', 'ASC')
                ->getQuery();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $query, /* query NOT result */ $request->query->getInt('page', 1)/* page number */, 5/* limit per page */
        );

        //$client_list = $query->getResult();
        //var_dump($client_list);

        return $this->render('list/client_list.html.twig', [
                    'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
                    //'list' => $client_list,
                    'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/add_client", name="add_client")
     */
    public function addClientAction(Request $request) {

        $client = new Client();
        $form = $this->createForm(ClientForm::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();
            return $this->redirectToRoute('client_list');
        }

        return $this->render('list/client.html.twig', [
                    'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete_client/{client_id}", name="delete_client",
     * requirements={
     * "client_id": "\d+"
     * })
     */
    public function deleteClientAction(Request $request, $client_id) {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Client')->findOneBy(array('client_id' => $client_id));

        if ($entity != null) {
            $em->remove($entity);
            $em->flush();
        }
        return $this->redirectToRoute('client_list');
    }

    /**
     * @Route("/edit_client/{client_id}", name="edit_client",
     * requirements={
     * "client_id": "\d+"
     * })
     */
    public function editClientAction(Request $request, $client_id) {


        $em = $this->getDoctrine()->getEntityManager();
        $client = $em->getRepository('AppBundle:Client')->find($client_id);
        // var_dump($task);

        $form = $this->createForm(ClientForm::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();
            return $this->redirectToRoute('client_list');
        }


        return $this->render('list/client.html.twig', [
                    'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/print_client/{client_id}", name="print_client",
     * requirements={
     * "client_id": "\d+"
     * })
     */
    public function printClientAction(Request $request, $client_id) {


        $em = $this->getDoctrine()->getEntityManager();
        $client = $em->getRepository('AppBundle:Client')->find($client_id);


        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $header = $phpWord->addSection();
        $header->addText("Id Klienta: " . $client->getClient_Id());
        $header->addText("Imię: " . $client->getName());
        $header->addText("Nazwisko: " . $client->getSurname());
        $header->addText("PESEL: " . $client->getPesel());
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

        $fileName = 'client_file.docx';
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
     * @Route("/print_client_list/", name="print_client_list")
     */
    public function printClientListAction(Request $request) {
        $em = $this->getDoctrine()->getEntityManager();
        $client = $em->getRepository('AppBundle:Client')->findAll();

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $header = $phpWord->addSection();

        foreach ($client as $c) {
            $header->addText("Id Klienta: " . $c->getClient_Id());
            $header->addText("Imię: " . $c->getName());
            $header->addText("Nazwisko: " . $c->getSurname());
            $header->addText("PESEL: " . $c->getPesel());
            $header->addText("______________________________________________________");
        }


        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');

        $fileName = 'client_file.docx';
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
