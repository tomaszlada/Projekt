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

}
