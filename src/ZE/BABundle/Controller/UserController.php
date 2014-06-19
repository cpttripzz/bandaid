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
        $user = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();


        $bandsOwned = $em->getRepository('ZE\BABundle\Entity\Association')->getAllBandsOwnedByUserId($user->getId());
        $musicianProfiles = $em->getRepository('ZE\BABundle\Entity\Association')->getAllMusiciansOwnedByUserId($user->getId());

        if(!$user->hasRole('ROLE_USER')){
            return new Response(array("Not Logged In"),401);
        }
        return $this->render(
            'ZEBABundle:User:index.html.twig',array('bands_owned' => $bandsOwned, 'musician_profiles' => $musicianProfiles)

        );
    }
}