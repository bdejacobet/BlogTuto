<?php

namespace Benijaco\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Benijaco\BlogBundle\Entity\Article;
use Benijaco\BlogBundle\Entity\Image;
use Benijaco\BlogBundle\Entity\Commentaire;
use Benijaco\BlogBundle\Entity\Categorie;
use Benijaco\BlogBundle\Entity\Competence;
use Benijaco\BlogBundle\Entity\ArticleCompetence;

class BlogController extends Controller
{
    public function indexAction($page)
    {
        
        if( isset($page) && $page < 1 ) {
            throw $this->createNotFoundException('Page inexistante (page = '.$page.')');
        }

        // Récupération EntityManager
        $em = $this->getDoctrine()
                   ->getManager();

        // Récupération des articles en fonction de la page
        $liste_articles = $em->getRepository('BenijacoBlogBundle:Article')
                             ->findBy(array(), array('date' => 'desc'),5, ($page*5)-5);  

        return $this->render('BenijacoBlogBundle:Blog:index.html.twig', array(
            'liste_articles' => $liste_articles
        ));
    }
    
    
    public function voirAction($id)
    {
        
        // Récupération EntityManager
        $em = $this->getDoctrine()
                   ->getManager();

        // Récupération article
        $article = $em->getRepository('BenijacoBlogBundle:Article')
                      ->find($id);
 
        // Si l'article n'existe pas
        if($article === null)
        {
            throw $this->createNotFoundException('Article[id='.$id.'] inexistant.');
        }
 
        // Récupération des commentaires de l'article
        $liste_commentaires = $em->getRepository('BenijacoBlogBundle:Commentaire')
                                 ->findByArticle($article->getId());
        
        // Récupération des articleCompetence de l'article
        $liste_articleCompetence = $em->getRepository('BenijacoBlogBundle:ArticleCompetence')
                                      ->findByArticle($article->getId());
 

        return $this->render('BenijacoBlogBundle:Blog:voir.html.twig', array(
            'article' => $article,
            'liste_commentaires' => $liste_commentaires,
            'liste_articleCompetence'  => $liste_articleCompetence
        ));
        
    }
    
    public function ajouterAction()
    { 
        
        
        // CREATION D'UN ARTICLE
        //----------------------------------------------------------
        
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
         
        // Création d'un premier commentaire
        $commentaire1 = new Commentaire();
        $commentaire1->setAuteur('winzou');
        $commentaire1->setContenu('On veut les photos !');

        // Création d'un deuxième commentaire, par exemple
        $commentaire2 = new Commentaire();
        $commentaire2->setAuteur('Choupy');
        $commentaire2->setContenu('Les photos arrivent !');

        // On lie les commentaires à l'article
        $commentaire1->setArticle($article);
        $commentaire2->setArticle($article);

        // On récupére l'EntityManager
        $em = $this->getDoctrine()->getManager();

        // On « persiste » l'entité
        $em->persist($article);
        $em->persist($commentaire1);
        $em->persist($commentaire2);

        // On « flush » pour créer l'aricle
        $em->flush();
        
        
        // ASSOCIATION DE COMPETENCES
        //----------------------------------------------------------
        
        // Les compétences existent déjà, on les récupère depuis la bdd
        $liste_competences = $em->getRepository('BenijacoBlogBundle:Competence')
                                ->findAll(); // Pour l'exemple, notre Article contient toutes les Competences

        // Pour chaque compétence
        foreach($liste_competences as $i => $competence)
        {
          // On crée une nouvelle "relation entre 1 article et 1 compétence"
          $articleCompetence[$i] = new ArticleCompetence;

          // On la lie à l'article, qui est ici toujours le même
          $articleCompetence[$i]->setArticle($article);
          // On la lie à la compétence, qui change ici dans la boucle foreach
          $articleCompetence[$i]->setCompetence($competence);

          // Arbitrairement, on dit que chaque compétence est requis au niveau 'Expert'
          $articleCompetence[$i]->setNiveau('Expert');

          // Et bien sûr, on persiste cette entité de relation, propriétaire des deux autres relations
          $em->persist($articleCompetence[$i]);
        }

        // Déclenchement de l'enregistrement
        $em->flush();

        // si POST : ajout article
        if( $this->get('request')->getMethod() == 'POST' ){

            // message flash pour confirmer ajout article
            $this->get('session')->getFlashBag()->add('notice', 'Article bien enregistré');

            // Redirection vers la page de visualisation de cet article
            return $this->redirect( $this->generateUrl('benijacoblog_voir', array('id' => $article->getId())) );
        }

        // si on n'est pas en POST : affichage du formulaire
        return $this->render('BenijacoBlogBundle:Blog:ajouter.html.twig');
    }
    
    public function modifierAction($id)
    {
        
        // Récupération EntityManager
        $em = $this->getDoctrine()
                   ->getManager();

        // Récupération article
        $article = $em->getRepository('BenijacoBlogBundle:Article')
                                ->find($id);

        // si l'article n'existe pas
        if($article === null)
        {
            throw $this->createNotFoundException('Article[id='.$id.'] inexistant.');
        }

        // Récupération des catégories
        $liste_categories = $em->getRepository('BenijacoBlogBundle:Categorie')
                                ->findAll();

        // Liaison des catégories à l'article
        foreach($liste_categories as $categorie)
        {
            $article->addCategorie($categorie);
        }

        // Déclenchement de l'enregistrement
        $em->flush();

        return $this->render('BenijacoBlogBundle:Blog:modifier.html.twig', array(
            'article' => $article
        ));
    }

    public function supprimerAction($id)
    {
        
        // Récupération EntityManager
        $em = $this->getDoctrine()
                   ->getManager();

        // Récupération article
        $article = $em->getRepository('BenijacoBlogBundle:Article')
                      ->find($id);

        // si l'article n'existe pas
        if($article === null)
        {
            throw $this->createNotFoundException('Article[id='.$id.'] inexistant.');
        }

        // Récupération des catégories :
        $liste_categories = $em->getRepository('BenijacoBlogBundle:Categorie')
                               ->findAll();

        // Suppression des catégories de l'article
        foreach($liste_categories as $categorie)
        {
            $article->removeCategorie($categorie);
        }

        // Déclenchement de l'enregistrement
        $em->flush(); 

        return $this->render('BenijacoBlogBundle:Blog:supprimer.html.twig');
    }
    
    public function menuAction()
    {

        // Récupération EntityManager
        $em = $this->getDoctrine()
                   ->getManager();

        // Récupération des 3 premiers articles
        $liste_articles = $em->getRepository('BenijacoBlogBundle:Article')
                             ->findBy(array(), array('date' => 'desc'),3,0);

        return $this->render('BenijacoBlogBundle:Blog:menu.html.twig', array(
          'liste_articles' => $liste_articles 
        ));
    }
}
