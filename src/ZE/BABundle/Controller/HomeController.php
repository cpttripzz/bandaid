<?php
namespace ZE\BABundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends FOSRestController
{
    public function getHomeAction()
    {

        $em = $this->getDoctrine()->getManager();
        $userId = null;
        if( $this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') ){
            $user = $this->get('security.context')->getToken()->getUser();
            $userId = $user->getId();
        }

        $data = $this->get('zeba.band_service')->findAllBandsWithVacancies(
            $userId,$this->get('request')->query->get('page', 1),$this->get('request')->query->get('limit', 10)
        );

        $view = $this->view($data, 200);

        return $this->handleView($view);

    }
}