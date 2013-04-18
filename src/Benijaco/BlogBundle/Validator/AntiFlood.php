<?php
 
namespace Benijaco\BlogBundle\Validator;
 
use Symfony\Component\Validator\Constraint;
 
/**
 * @Annotation
 */
class AntiFlood extends Constraint
{
    public $message = 'Vous avez déjà posté un message il y a moins de 15 secondes, merci d\'attendre un peu.';
 
    public function validatedBy()
    {
        return 'benijacoblog_antiflood'; // Ici, on fait appel à l'alias du service
    }
}