<?php

namespace AppBundle\Controller;

use AppBundle\Entity\entreprise;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class EntrepriseController
 * @package AppBundle\Controller
 * @Route("/entreprise")
 */
class EntrepriseController extends Controller
{
    /**
     * @Route("/list")
     */
    public function listAction()
    {
        $doctrine = $this->getDoctrine();

        $repository = $doctrine->getRepository('AppBundle:Entreprise');

        $entreprises = $repository->findAll();
        return $this->render('@App/Entreprise/list.html.twig', array(
            'entreprises'=> $entreprises
        ));

    }

    /**
     * @Route("/add")
     */
    public function addAction($nom,$email,$password,$adresse,$activation)
    {
        $entreprise = new client($nom,$email,$password,$adresse,$activation);
        $em = $this->getDoctrine()-> getManager();
        $em->flush();
        return $this-> forward('AppBundle:entreprise:list');
    }

    /**
     * @Route("/delete/{entreprise}")
     */
    public function deleteAction(entreprise $entreprise=null)
    {
        if ($entreprise){

            $em = $this->getDoctrine()-> getManager();
            $em->remove($entreprise);
            $em->flush();
        }
        else { echo('entreprise n\'existe pas');}
        return $this-> forward('AppBundle:entreprise:list');
    }

    /**
     * @Route("/update/{entreprise}/{nouvnom}")
     */
    public function updateAction(entreprise $entreprise = null,$nouvnom)
    {
        if ($entreprise){
            $entreprise->setNom($nouvnom);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entreprise);
            $em->flush();
        }
        else{ echo ('entreprise n\'existe pas');}
        return $this-> forward('AppBundle:entreprise:list');
    }

}
