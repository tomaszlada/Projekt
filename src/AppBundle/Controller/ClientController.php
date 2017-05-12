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

}
