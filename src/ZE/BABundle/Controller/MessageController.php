<?php
namespace ZE\BABundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller
{
    protected $msgService;

    public function indexAction(){
        $this->msgService = $this->get('snc_redis.default');
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

        $msgIds = $this->msgService->lrange('messages:'.$user->getId(), 0, -1);
        if ($msgIds){
            $msgs = new \SplFixedArray(count($msgIds));
        }
        $arrCounter = 0;
        foreach((array) $msgIds as $key=> $msgId){
            $message = $this->msgService->hgetall('message:'.$msgId);
            $requestUser = $em->getRepository('ZE\BABundle\Entity\User')->findOneById($message['fromUser']);
            $userPofileLink = $this->generateUrl('user_show', array('id' => $requestUser->getId()));
            $message['userProfileUri'] = $userPofileLink;
            $msgs[$arrCounter] = $message;
            $arrCounter ++;
        }
//        return $this->render(
//            'ZEBABundle:User:index.html.twig',array('bands_owned' => $bandsOwned, 'musician_profiles' => $musicianProfiles)
//
//        );
    }
}