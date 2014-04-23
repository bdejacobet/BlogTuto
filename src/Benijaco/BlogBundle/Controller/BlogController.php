<?php
 
// src/Benijaco/BlogBundle/Controller/BlogController.php
 
namespace Benijaco\BlogBundle\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Benijaco\BlogBundle\Entity\Article;
use Benijaco\BlogBundle\Form\ArticleType;
 
class BlogController extends Controller
{
  public function indexAction($page)
  {
    $articles = $this->getDoctrine()
                     ->getManager()
                     ->getRepository('BenijacoBlogBundle:Article')
                     ->getArticles(3, $page); // 3 articles par page
     
    return $this->render('BenijacoBlogBundle:Blog:index.html.twig', array(
      'articles'   => $articles,
      'page'       => $page,
      'nombrePage' => ceil(count($articles)/3)
    ));
  }
 
  public function voirAction(Article $article)
  {

    $listeArticleCompetence = $this->getDoctrine()
                                   ->getManager()
                                   ->getRepository('BenijacoBlogBundle:ArticleCompetence')
                                   ->findByArticle($article->getId());
 
    return $this->render('BenijacoBlogBundle:Blog:voir.html.twig', array(
      'article'                 => $article,
      'listeArticleCompetence'  => $listeArticleCompetence
    ));
  }
 
  public function ajouterAction()
  {
      
    $article = new Article;
    $form = $this->createForm(new ArticleType, $article);
 
    $request = $this->get('request');
    if ($request->getMethod() == 'POST') {
      $form->bind($request);
 
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();
 
        $this->get('session')->getFlashBag()->add('info', 'Article bien créé');
        
        return $this->redirect($this->generateUrl('benijacoblog_voir', array('id' => $article->getId())));
      }
    } 

    return $this->render('BenijacoBlogBundle:Blog:ajouter.html.twig', array(
      'form' => $form->createView(),
    ));
      
    
  }
 
  public function modifierAction($id)
  {
    $article = $this->getDoctrine()
               ->getEntityManager()
               ->getRepository('BenijacoBlogBundle:Article')
               ->find($id);
 
    if ($article == null) {
      throw $this->createNotFoundException('Article[id='.$id.'] inexistant');
    }
 
    $form = $this->createForm(new ArticleType, $article);
 
    $request = $this->get('request');
    if ($request->getMethod() == 'POST') {
      $form->bind($request);
 
      if ($form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();
        
        $this->get('session')->getFlashBag()->add('info', 'Article bien modifié');
 
        return $this->redirect($this->generateUrl('benijacoblog_voir', array('id' => $article->getId())));
      }
    }

    return $this->render('BenijacoBlogBundle:Blog:modifier.html.twig', array(
      'article' => $article,
      'form' => $form->createView(),
    ));
  }
 
  public function supprimerAction($id)
  {
    $em = $this->getDoctrine()
               ->getEntityManager();
 
    $article = $em->getRepository('BenijacoBlogBundle:Article')
                  ->find($id);
     
    if ($article == null) {
      throw $this->createNotFoundException('Article[id='.$id.'] inexistant');
    }
 
    if ($this->get('request')->getMethod() == 'POST') {       
      $this->get('session')->getFlashBag()->add('info', 'Article bien supprimé');
 
      return $this->redirect( $this->generateUrl('benijacoblog_accueil') );
    }
 
    return $this->render('BenijacoBlogBundle:Blog:supprimer.html.twig', array(
      'article' => $article
    ));
  }
 
  public function menuAction($nombre)
  {
    $liste = $this->getDoctrine()
                  ->getManager()
                  ->getRepository('BenijacoBlogBundle:Article')
                  ->findBy(
                    array(),          // Pas de critère
                    array('date' => 'desc'), // On tri par date décroissante
                    $nombre,         // On sélectionne $nombre articles
                    0                // À partir du premier
                  );
 
    return $this->render('BenijacoBlogBundle:Blog:menu.html.twig', array(
      'liste_articles' => $liste 
    ));
  }
}