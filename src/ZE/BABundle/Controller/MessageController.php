<?php
namespace ZE\BABundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use ZE\BABundle\Event\JoinBandRequestEvent;

class MessageController extends Controller
{
    protected $msgService;

    public function indexAction(Request $request){
        $this->msgService = $this->get('snc_redis.default');

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
            $acceptUri = $this->generateUrl('api_joinBandAcceptAction',
                array('bandId' => $message['bandId'], 'musicianId' => $message['musicianId']));

            $message['DT_RowId'] = $msgId;
            $message['counter'] = $arrCounter +1;
            $musicianLink = '<a href="'.$musicianUri.'">' . $musician->getName() .'</a>';
            $bandLink = '<a href="'.$bandUri.'">' . $band->getName() .'</a';

            $searchArr = array('[musician]','[band]');
            $replaceArr = array($musicianLink,$bandLink);
            $message['message'] = str_replace($searchArr,$replaceArr,$message['message']) ;
            if ($message['messageType'] == JoinBandRequestEvent::EVENT_TYPE_JOIN ){
                $acceptLink = '
                <div><button data-href="'.$acceptUri.'"
                    type="button" class="btn btn-primary">Accept Request</button>
                </div>';

                $rejectLink = '
                <div><button data-href="'.$acceptUri.'"
                    type="button" class="btn btn-primary">Accept Join Request</button>
                </div>';
                $message['message'] .= $acceptLink;
            }
            $msgs[$arrCounter] = $message;

            $arrCounter ++;
        }
        if($request->isXmlHttpRequest())
        {
            return new JsonResponse(array("data"=>$msgs->toArray()));
        }
        return $this->render(
            'ZEBABundle:Message:index.html.twig',
            array('messages' =>  $msgs->toArray())

        );
    }
}