<?php
namespace ZE\BABundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    public function indexAction(){

        $em = $this->getDoctrine()->getManager();
        $bands = $em->getRepository('ZE\BABundle\Entity\Band')->findAllBandsWithVacancies();

        return $this->render(
            'ZEBABundle:Home:index.html.twig',array('bands' => $bands)

        );
    }
}