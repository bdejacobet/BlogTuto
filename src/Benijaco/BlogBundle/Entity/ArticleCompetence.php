<?php
// src/Benijaco/BlogBundle/Entity/ArticleCompetence.php
 
namespace Benijaco\BlogBundle\Entity;
 
use Doctrine\ORM\Mapping as ORM;
 
/**
 * @ORM\Entity
 */
class ArticleCompetence
{
  /**
   * @ORM\Id
   * @ORM\ManyToOne(targetEntity="Benijaco\BlogBundle\Entity\Article")
   */
  private $article;
 
  /**
   * @ORM\Id
   * @ORM\ManyToOne(targetEntity="Benijaco\BlogBundle\Entity\Competence")
   */
  private $competence;
 
  /**
   * @ORM\Column()
   */
  private $niveau; // Ici j'ai un attribut de relation, que j'ai appelé « niveau »
 
  /**
   * @param string $niveau
   * @return Article_Competence
   */
  public function setNiveau($niveau)
  {
    $this->niveau = $niveau;
    return $this;
  }
 
  /**
   * @return string
   */
  public function getNiveau()
  {
    return $this->niveau;
  }
 
  /**
   * @param Benijaco\BlogBundle\Entity\Article $article
   * @return ArticleCompetence
   */
  public function setArticle(\Benijaco\BlogBundle\Entity\Article $article)
  {
    $this->article = $article;
    return $this;
  }
 
  /**
   * @return Benijaco\BlogBundle\Entity\Article
   */
  public function getArticle()
  {
    return $this->article;
  }
 
  /**
   * @param Benijaco\BlogBundle\Entity\Competence $competence
   * @return ArticleCompetence
   */
  public function setCompetence(\Benijaco\BlogBundle\Entity\Competence $competence)
  {
    $this->competence = $competence;
    return $this;
  }
 
  /**
   * @return Benijaco\BlogBundle\Entity\Competence
   */
  public function getCompetence()
  {
    return $this->competence;
  }
}