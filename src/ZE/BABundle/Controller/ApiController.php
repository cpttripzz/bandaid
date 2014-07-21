<?php

namespace ZE\BABundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use ZE\BABundle\Entity\Band;
use ZE\BABundle\Event\JoinBandAcceptEvent;
use ZE\BABundle\Event\JoinBandRequestEvent;

class ApiController extends Controller
{

    public function joinBandRequestAction($bandId,$musicianId)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        if( !$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') ){
            return new JsonResponse(array("Not Logged In"),401);
        }
        $em = $this->getDoctrine()->getManager();
        if ($user->hasRole('ROLE_USER')) {
            $band = $em->getRepository('ZE\BABundle\Entity\Band')->findOneById($bandId);

            if( $this->get('ze.band_manager_service')->isUserInBand($band)){
                return new JsonResponse(array("success" =>false, "msg"=>"User Already Member of Band"),404);
            }
            $dispatcher = $this->container->get('event_dispatcher');
            $dispatcher->dispatch('zeba.band.join_request', new JoinBandRequestEvent($user, $bandId, $musicianId));
            return new JsonResponse(array("success" =>true, "msg"=>"Request sent."));
        } else {
            return new JsonResponse(array("success" =>false, "msg"=>"Not Logged In"),401);
        }
    }

    public function joinBandAcceptAction($bandId,$musicianId)
    {
        $user = $this->get('security.context')->getToken()->getUser();

        if( !$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') ){
            return new JsonResponse(array("msg"=>"Not Logged In"),401);
        }

        $em = $this->getDoctrine()->getManager();
        $band = $em->getRepository('ZE\BABundle\Entity\Band')->findOneById($bandId);

        if(! $this->get('ze.band_manager_service')->isUserInBand($band)){
            throw new AccessDeniedException('Unauthorised access!');
        }
        if ($user->hasRole('ROLE_USER')) {
            $dispatcher = $this->container->get('event_dispatcher');
            $dispatcher->dispatch('zeba.band.join_accept', new JoinBandAcceptEvent($user,$bandId,$musicianId));
            return new JsonResponse(array("success" =>true, "msg"=>"User accepted to band."));
        } else {
            return new JsonResponse(array("success" =>false, "msg"=>"Not Logged In"),401);
        }
    }
    public function getAllImagesByAssociationIdAction($associationId)
    {
        $em = $this->getDoctrine()->getManager();
        $images = $em->getRepository('ZE\BABundle\Entity\Document')->getAllImagesByAssociationId($associationId);
        return new JsonResponse($images);
    }
}
