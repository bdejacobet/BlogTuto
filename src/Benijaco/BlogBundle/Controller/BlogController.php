<?php

namespace Benijaco\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends Controller
{
    public function indexAction()
    {
        return $this->render('BenijacoBlogBundle:Blog:index.html.twig', array());
    }
    
    public function voirAction($id)
    {
        return new Response("Affichage de l'article d'id : ".$id.".");
    }
    
    public function ajouterAction()
    {
        return new Response("Ajout d'un article");
    }
    
    public function modifierAction($id)
    {
        return new Response("Modification de l'article d'id : ".$id.".");
    }
    
    public function supprimerAction($id)
    {
        return new Response("Suppression de l'article d'id : ".$id.".");
    }
}
