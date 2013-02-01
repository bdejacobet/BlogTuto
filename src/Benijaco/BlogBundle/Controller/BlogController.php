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
}
