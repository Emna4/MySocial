<?php

namespace AppBundle\Controller;

use AppBundle\Entity\client;
use AppBundle\Entity\entreprise;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class ClientController
 * @package AppBundle\Controller
 * @Route("/client")
 */
class ClientController extends Controller
{
    /**
     * @Route("/list")
     */
    public function listAction()
    {
        $doctrine = $this->getDoctrine();

        $repository = $doctrine->getRepository('AppBundle:client');

        $clients = $repository->findAll();
        return $this->render('@App/Client/list.html.twig', array(
            'clients'=>$clients
        ));


    }

    /**
     * @Route("/add")
     */
    public function addAction($nom,$prenom,$email,$password,$adresse)
    {
        $client = new client($nom,$prenom,$email,$password,$adresse);
        $em = $this->getDoctrine()-> getManager();
        $em->persist($client);
        $em->flush();
        return $this-> forward('AppBundle:client:list');
    }

    /**
     * @Route("/delete/{client}")
     */
    public function deleteAction(client $client=null)
    {
        if ($client){

            $em = $this->getDoctrine()-> getManager();
            $em->remove($client);
            $em->flush();
        }
        else { echo('cliente n\'existe pas');}
        return $this-> forward('AppBundle:client:list');
    }

    /**
     * @Route("/update/{client}/{nouvnom}")
     */
    public function updateAction(client $client = null,$nouvnom)
    {
        if ($client){
            $client->setNom($nouvnom);
            $em = $this->getDoctrine()->getManager();
            $em->persist($client);
            $em->flush();

        }
        else{ echo ('client n\'existe pas');}
        return $this-> forward('AppBundle:client:list');
    }


    /**
     * @Route("/irrigate")
     */
    public function irrigateAction()
    {
        //creation des objets
        $clients = array(
            new client('amri','emna','emnaaa@gmail.com','emna','manouba'),
            new client('kouki','malek','malekhh@gmail.com','malek','tbarka'),
            new client('jemai','ahmed','ahmedtt@gmail.com','ahmed','soussa'),
            new client('dridi','oussema','oussemath@gmail.com','oussema','beja')
        );
        //recupere entity manager
        $em = $this->getDoctrine()->getManager();

        //prendre en charge les donnees
        foreach($clients as $client){
            $em->persist($client);
        }

        //ajouter a la base de donnees

        $em->flush();
        //afficher
        return $this->forward('AppBundle:client:list');

    }

}
