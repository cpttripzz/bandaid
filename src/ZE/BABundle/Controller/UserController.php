<?php
namespace ZE\BABundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function indexAction(){
        /**
         * @var  ZE\BABundle\Entity\User
         */

        if( !$this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') ){
            return $this->render(
                'ZEBABundle:Home:index.html.twig'
            );
        }
        $user = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $bandsOwned = $em->getRepository('ZE\BABundle\Entity\Association')->getAllBandsAssociatedByUserId($user->getId());
        $musicianProfiles = $em->getRepository('ZE\BABundle\Entity\Association')->getAllMusiciansOwnedByUserId($user->getId());

        return $this->render(
            'ZEBABundle:User:index.html.twig',array('bands_owned' => $bandsOwned, 'musician_profiles' => $musicianProfiles)

        );
    }

    public function showAction(User $entity)
    {
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $em = $this->getDoctrine()->getManager();

        $bandsOwned = $em->getRepository('ZE\BABundle\Entity\Association')->getAllBandsAssociatedByUserId($user->getId());
        $musicianProfiles = $em->getRepository('ZE\BABundle\Entity\Association')->getAllMusiciansOwnedByUserId($user->getId());

        return $this->render(
            'ZEBABundle:User:index.html.twig',array('bands_owned' => $bandsOwned, 'musician_profiles' => $musicianProfiles)

        );
    }

}