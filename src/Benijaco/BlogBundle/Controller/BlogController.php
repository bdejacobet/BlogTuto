<?php

namespace Benijaco\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends Controller
{
    public function indexAction()
    {

        if( isset($page) && $page < 1 ) {
            throw $this->createNotFoundException('Page inexistante (page = '.$page.')');
        }

        // Ici, on récupérera la liste des articles
        $articles = array(
          array('titre' => 'Mon weekend a Phi Phi Island !',          'id' => 1, 'auteur' => 'winzou',  'contenu' => 'Ce weekend était trop bien. Blabla…',  'date' => new \Datetime()),
          array('titre' => 'Repetition du National Day de Singapour', 'id' => 2, 'auteur' => 'winzou',  'contenu' => 'Bientôt prêt pour le jour J. Blabla…', 'date' => new \Datetime()),
          array('titre' => 'Chiffre d\'affaire en hausse',            'id' => 3, 'auteur' => 'M@teo21', 'contenu' => '+500% sur 1 an, fabuleux. Blabla…',    'date' => new \Datetime())
        );     

        return $this->render('BenijacoBlogBundle:Blog:index.html.twig', array(
            'articles' => $articles
        ));
    }
    
    public function voirAction($id)
    {
        
        // Ici, on récupérera les données de l'articles
        $article = array(
            'id'      => 1,
            'titre'   => 'Mon weekend a Phi Phi Island !',
            'auteur'  => 'winzou',
            'contenu' => 'Ce weekend était trop bien. Blabla…',
            'date'    => new \Datetime()
        );
          
        return $this->render('BenijacoBlogBundle:Blog:voir.html.twig', array(
            'article' => $article
        ));
    }
    
    public function ajouterAction()
    { 

        // si POST : ajout article
        if( $this->get('request')->getMethod() == 'POST' ){
            // Ici, on s'occupera de la création et de la gestion du formulaire

            // message flash pour confirmer ajout article
            $this->get('session')->getFlashBag()->add('notice', 'Article bien enregistré');

            // redirection vers la page de visualisation de cet article
            return $this->redirect( $this->generateUrl('benijacoblog_voir', array('id' => 5)) );
        }

        // si on n'est pas en POST : affichage du formulaire
        return $this->render('BenijacoBlogBundle:Blog:ajouter.html.twig');
    }
    
    public function modifierAction($id)
    {
        
        // Ici, on récupérera les données de l'articles
        $article = array(
            'id'      => 1,
            'titre'   => 'Mon weekend a Phi Phi Island !',
            'auteur'  => 'winzou',
            'contenu' => 'Ce weekend était trop bien. Blabla…',
            'date'    => new \Datetime()
        );

        return $this->render('BenijacoBlogBundle:Blog:modifier.html.twig', array(
            'article' => $article
        ));
    }

    public function supprimerAction($id)
    {
        // Ici, on récupérera l'article correspondant à l'$id

        // Ici, on gérera la suppression de l'article en question

        return $this->render('BenijacoBlogBundle:Blog:supprimer.html.twig');
    }
    
    public function menuAction()
    {
        // Ici on fixe en dur une liste, bien entendu par la suite on la récupérera depuis la BDD !
        $liste = array(
          array('id' => 2, 'titre' => 'Mon dernier weekend !'),
          array('id' => 5, 'titre' => 'Sortie de Symfony2.1'),
          array('id' => 9, 'titre' => 'Petit test')
        );

        return $this->render('BenijacoBlogBundle:Blog:menu.html.twig', array(
          'liste_articles' => $liste 
        ));
    }
}
