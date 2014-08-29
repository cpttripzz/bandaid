<?php
namespace ZE\BABundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    public function indexAction(){

        $em = $this->getDoctrine()->getManager();
        $userId = null;
        if( $this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') ){
            $user = $this->get('security.context')->getToken()->getUser();
            $userId = $user->getId();
        }


        $bands = $em->getRepository('ZE\BABundle\Entity\Band')->findAllBandsWithVacancies($userId);

        return $this->render(
            'ZEBABundle:Home:index.html.twig',array('bands' => $bands)

        );
    }
}