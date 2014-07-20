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
            $musician = $em->getRepository('ZE\BABundle\Entity\Musician')->findOneById($message['musicianId']);
            $band = $em->getRepository('ZE\BABundle\Entity\Band')->findOneById($message['bandId']);
            $musicianUri = $this->generateUrl('musician_show', array('slug' => $musician->getSlug()));
            $bandUri = $this->generateUrl('band_show', array('slug' => $band->getSlug()));
            $acceptUri = $this->generateUrl('api_joinBandRequestAction',
                array('bandId' => $message['bandId'], 'musicianId' => $message['musicianId']));
            $message['msgId'] = $msgId;
            $message['counter'] = $arrCounter +1;
            $musicianLink = '<a href="'.$musicianUri.'">' . $musician->getName() .'</a>';
            $bandLink = '<a href="'.$bandUri.'">' . $band->getName() .'</a';
            $acceptLink = '
                <div><button data-href="'.$acceptUri.'"
                    type="button" class="btn btn-primary">Accept Join Request</button>
                </div>';
            $searchArr = array('[musician]','[band]');
            $replaceArr = array($musicianLink,$bandLink);
            $message['message'] = str_replace($searchArr,$replaceArr,$message['message']) . $acceptLink;
            $msgs[$arrCounter] = $message;

            $arrCounter ++;
        }
        return $this->render(
            'ZEBABundle:Message:index.html.twig',
            array('messages' =>  $msgs->toArray())

        );
    }
}