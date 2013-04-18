<?php
// src/Benijaco/BlogBundle/Entity/Article.php
 
namespace Benijaco\BlogBundle\Entity;

 
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;
use Benijaco\BlogBundle\Validator\AntiFlood as AntiFlood;
 
/**
 * Benijaco\BlogBundle\Entity\Article
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Benijaco\BlogBundle\Entity\ArticleRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Article
{
  /**
   * @var integer $id
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;
 
  /**
   * @var datetime $date
   *
   * @ORM\Column(name="date", type="datetime")     
   * @Assert\DateTime()
   */
  private $date;
 
  /**
   * @var string $titre
   *
   * @ORM\Column(name="titre", type="string", length=255)
   * @Assert\MinLength(limit=10, message="Le titre doit faire au moins {{ limit }} caractères.")
   */
  private $titre;
 
  /**
   * @var string $titre
   *
   * @ORM\Column(name="auteur", type="string", length=255)
   * @Assert\MinLength(limit=10, message="L'auteur doit faire au moins {{ limit }} caractères.")
   */
  private $auteur;
 
  /**
   * @ORM\Column(name="publication", type="boolean")
   */
  private $publication;
 
  /**
   * @var text $contenu
   *
   * @ORM\Column(name="contenu", type="text")
   * @Assert\NotBlank()
   * @AntiFlood()
   */
  private $contenu;
   
  /**
   * @ORM\Column(type="date", nullable=true)
   */
  private $dateEdition;
   
  /**
   * @Gedmo\Slug(fields={"titre"})
   * @ORM\Column(length=128, unique=true)
   */
  private $slug;
 
  /**
   * @ORM\OneToOne(targetEntity="Benijaco\BlogBundle\Entity\Image", cascade={"persist"})
   * @Assert\Valid()
   */
  private $image;
 
  /**
   * @ORM\ManyToMany(targetEntity="Benijaco\BlogBundle\Entity\Categorie", cascade={"persist"})
   */
  private $categories;
 
  /**
   * @ORM\OneToMany(targetEntity="Benijaco\BlogBundle\Entity\Commentaire", mappedBy="article")
   */
  private $commentaires; // Ici commentaires prend un « s », car un article a plusieurs commentaires !
 
 
  public function __construct()
  {
    $this->date     = new \Datetime;
    $this->publication  = true;
    $this->categories   = new \Doctrine\Common\Collections\ArrayCollection();
    $this->commentaires = new \Doctrine\Common\Collections\ArrayCollection();
  }
   
  /**
   * @ORM\PreUpdate
   * Callback pour mettre à jour la date d'édition à chaque modification de l'entité
   */
  public function updateDate()
  {
    $this->setDateEdition(new \Datetime());
  }
 
  /**
   * @return integer
   */
  public function getId()
  {
    return $this->id;
  }
 
  /**
   * @param datetime $date
   * @return Article
   */
  public function setDate(\Datetime $date)
  {
    $this->date = $date;
    return $this;
  }
 
  /**
   * @return datetime
   */
  public function getDate()
  {
    return $this->date;
  }
 
  /**
   * @param string $titre
   * @return Article
   */
  public function setTitre($titre)
  {
    $this->titre = $titre;
    return $this;
  }
 
  /**
   * @return string
   */
  public function getTitre()
  {
    return $this->titre;
  }
 
  /**
   * @param text $contenu
   * @return Article
   */
  public function setContenu($contenu)
  {
    $this->contenu = $contenu;
    return $this;
  }
 
  /**
   * @return text
   */
  public function getContenu()
  {
    return $this->contenu;
  }
 
  /**
   * @param boolean $publication
   * @return Article
   */
  public function setPublication($publication)
  {
    $this->publication = $publication;
    return $this;
  }
 
  /**
   * @return boolean
   */
  public function getPublication()
  {
    return $this->publication;
  }
 
  /**
   * @param string $auteur
   * @return Article
   */
  public function setAuteur($auteur)
  {
    $this->auteur = $auteur;
    return $this;
  }
 
  /**
   * @return string
   */
  public function getAuteur()
  {
    return $this->auteur;
  }
 
  /**
   * @param Benijaco\BlogBundle\Entity\Image $image
   * @return Article
   */
  public function setImage(\Benijaco\BlogBundle\Entity\Image $image = null)
  {
    $this->image = $image;
    return $this;
  }
 
  /**
   * @return Benijaco\BlogBundle\Entity\Image
   */
  public function getImage()
  {
    return $this->image;
  }
 
  /**
   * @param Benijaco\BlogBundle\Entity\Categorie $categorie
   * @return Article
   */
  public function addCategorie(\Benijaco\BlogBundle\Entity\Categorie $categorie)
  {
    $this->categories[] = $categorie;
    return $this;
  }
 
  /**
   * @param Benijaco\BlogBundle\Entity\Categorie $categorie
   */
  public function removeCategorie(\Benijaco\BlogBundle\Entity\Categorie $categorie)
  {
    $this->categories->removeElement($categorie);
  }
 
  /**
   * @return Doctrine\Common\Collections\Collection
   */
  public function setCategories()
  {
    return $this->categories;
  }
 
  /**
   * @return Doctrine\Common\Collections\Collection
   */
  public function getCategories()
  {
    return $this->categories;
  }
 
  /**
   * @param Benijaco\BlogBundle\Entity\Commentaire $commentaire
   * @return Article
   */
  public function addCommentaire(\Benijaco\BlogBundle\Entity\Commentaire $commentaire)
  {
    $this->commentaires[] = $commentaire;
    return $this;
  }
 
  /**
   * @param Benijaco\BlogBundle\Entity\Commentaire $commentaire
   */
  public function removeCommentaire(\Benijaco\BlogBundle\Entity\Commentaire $commentaire)
  {
    $this->commentaires->removeElement($commentaire);
  }
 
  /**
   * @return Doctrine\Common\Collections\Collection
   */
  public function getCommentaires()
  {
    return $this->commentaires;
  }
 
  /**
   * @param datetime $dateEdition
   * @return Article
   */
  public function setDateEdition(\Datetime $dateEdition)
  {
    $this->dateEdition = $dateEdition;
    return $this;
  }
 
  /**
   * @return date
   */
  public function getDateEdition()
  {
    return $this->dateEdition;
  }
 
  /**
   * @param string $slug
   * @return Article
   */
  public function setSlug($slug)
  {
    $this->slug = $slug;
    return $this;
  }
 
  /**
   * @return string
   */
  public function getSlug()
  {
    return $this->slug;
  }

}