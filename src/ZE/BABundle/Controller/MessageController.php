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
            $requestBand = $em->getRepository('ZE\BABundle\Entity\Band')->findOneById($message['bandId']);
            $userPofileLink = $this->generateUrl('user_show', array('id' => $requestUser->getId()));
            $bandLink = $this->generateUrl('band_show', array('slug' => $requestBand->getSlug()));
            $message['msgId'] = $msgId;
            $message['counter'] = $arrCounter +1;
            $requestUserLink = '<a href="'.$userPofileLink.'">' . $requestUser->getUserName() .'</a>';
            $bandLink = '<a href="'.$bandLink.'">' . $requestBand->getName() .'</a';
            $searchArr = array('[user]','[band]');
            $replaceArr = array($requestUserLink,$bandLink);
            $message['message'] = str_replace($searchArr,$replaceArr,$message['message']);
            $msgs[$arrCounter] = $message;

            $arrCounter ++;
        }
        return $this->render(
            'ZEBABundle:Message:index.html.twig',
            array('messages' =>  $msgs->toArray())

        );
    }
}