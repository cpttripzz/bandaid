<?php

namespace Bandaid\BandaidUserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BandaidBandaidUserBundle:Default:index.html.twig');
    }
}
