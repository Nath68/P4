<?php

namespace ML\billetterieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MLbilletterieBundle:Default:index.html.twig');
    }
}
