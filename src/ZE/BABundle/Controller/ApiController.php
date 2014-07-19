<?php

namespace ZE\BABundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use ZE\BABundle\Entity\Band;
use ZE\BABundle\Event\JoinBandRequestEvent;

class ApiController extends Controller
{

    public function joinBandRequestAction($bandId)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        if( !$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') ){
            return new JsonResponse(array("Not Logged In"),401);
        }
        if ($user->hasRole('ROLE_USER')) {
            $dispatcher = $this->container->get('event_dispatcher');
            $dispatcher->dispatch('zeba.band.join_request', new JoinBandRequestEvent($user, $bandId));
            return new JsonResponse(array("Request sent."));
        } else {
            return new JsonResponse(array("Not Logged In"),401);
        }
    }

    public function getAllImagesByAssociationIdAction($associationId)
    {
        $em = $this->getDoctrine()->getManager();
        $images = $em->getRepository('ZE\BABundle\Entity\Document')->getAllImagesByAssociationId($associationId);
        return new JsonResponse($images);
    }
}
