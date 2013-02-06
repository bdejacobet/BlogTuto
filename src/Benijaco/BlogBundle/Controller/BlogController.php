<?php

namespace Benijaco\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Benijaco\BlogBundle\Entity\Article;
use Benijaco\BlogBundle\Entity\Image;

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
        
        // On récupère le repository
        $repository = $this->getDoctrine()
                            ->getManager()
                            ->getRepository('BenijacoBlogBundle:Article');

        // On récupère l'entité correspondant à l'id $id
        $article = $repository->find($id);
          
        return $this->render('BenijacoBlogBundle:Blog:voir.html.twig', array(
            'article' => $article
        ));
    }
    
    public function ajouterAction()
    { 
        
        // Création de l'entité
        $article = new Article();
        $article->setTitre('Mon dernier weekend');
        $article->setAuteur('Bibi');
        $article->setContenu("C'était vraiment super et on s'est bien amusé.");

        // Création de l'entité Image
        $image = new Image();
        $image->setUrl('http://uploads.siteduzero.com/icones/478001_479000/478657.png');
        $image->setAlt('Logo Symfony2');

        // On lie l'image à l'article
        $article->setImage($image);

        // On récupére l'EntityManager
        $em = $this->getDoctrine()->getManager();

        // Etape 1 : On « persiste » l'entité
        $em->persist($article);

        // Etape 2 : On « flush » tout ce qui a été persisté avant
        $em->flush();

        // si POST : ajout article
        if( $this->get('request')->getMethod() == 'POST' ){

            // message flash pour confirmer ajout article
            $this->get('session')->getFlashBag()->add('notice', 'Article bien enregistré');

            // redirection vers la page de visualisation de cet article
            return $this->redirect( $this->generateUrl('benijacoblog_voir', array('id' => $article->getId())) );
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
