<?php

namespace Benijaco\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller
{
    public function indexAction()
    {
        return $this->render('BenijacoBlogBundle:Blog:index.html.twig', array());
    }
}
