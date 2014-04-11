<?php
namespace ZE\BABundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Ivory\GoogleMap\Overlays\Animation;
use Ivory\GoogleMap\Overlays\Marker;

class LocationController extends Controller
{
    public function indexAction(Request $request){
        $map = $this->get('ivory_google_map.map');
//        $result = $this->container
//            ->get('bazinga_geocoder.geocoder')
//            ->geocode($request->server->get('REMOTE_ADDR'));
//
//        $latitude = $result->getLatitude();
        $latitude = 43.6449285;
//        $longitude = $result->getLongitude();
        $longitude = -79.4560727;
        $map->setCenter($latitude, $longitude, true);

        $em = $this->getDoctrine()->getManager();
        $addresses = $em->getRepository('ZE\BABundle\Entity\Address')->getClosestAddresses($latitude,$longitude);
        foreach($addresses as $address){
            $latitude = $address['latitude'];
            $longitude = $address['longitude'];
            $marker = new Marker();
            $marker->setPrefixJavascriptVariable('marker_');
            $marker->setPosition($latitude, $longitude, true);
            $marker->setAnimation(Animation::DROP);
            $marker->setOption('clickable', false);
            $marker->setOption('flat', true);
            $marker->setOptions(array(
                'clickable' => false,
                'flat'      => true,
            ));
            $map->addMarker($marker);
        }

        $map->setMapOption('zoom', 10);
        return $this->render(
            'ZEBABundle:Location:index.html.twig',
            array('map' => $map)
        );
    }
    public function geocodeAction(Request $request)
    {
        $result = $this->container
            ->get('bazinga_geocoder.geocoder')
            ->geocode($request->server->get('REMOTE_ADDR'));

        $body = $this->container
            ->get('bazinga_geocoder.dumper_manager')
            ->get('geojson')
            ->dump($result);

        $response = new Response();
        $response->setContent($body);

        return $response;
    }
}