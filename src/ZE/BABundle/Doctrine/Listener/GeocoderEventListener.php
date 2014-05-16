<?php
namespace ZE\BABundle\Doctrine\Listener;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use \Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ZE\BABundle\Entity\Address;


class GeocoderEventListener
{
    protected  $container;

    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /** @ORM\PrePersist */
    public function prePersist(LifecycleEventArgs $eventArgs) {
        if(($address = $eventArgs->getEntity()) instanceof Address){
            if( !$address->getLatitude() || !$address->getLongitude()){
                $this->geocodeAddress($address);
            }
        }
    }
    /** @ORM\PreUpdate */
    public function preUpdate(PreUpdateEventArgs $eventArgs){
        if(($address = $eventArgs->getEntity()) instanceof Address){
            if( !$address->latitude || !$address->longitude
                || $eventArgs->hasChangedField('address')){

                $this->geocodeAddress($address->__toString());

                $em = $eventArgs->getEntityManager();
                $uow = $em->getUnitOfWork();
                $meta = $em->getClassMetadata(get_class($address));
                $uow->recomputeSingleEntityChangeSet($meta, $address);
            }
        }
    }


    private function geocodeAddress($address){
        try {
            $result = $this->container
                ->get('bazinga_geocoder.geocoder')
                ->geocode($address->__toString());
            $address->setLatitude($result['latitude']);
            $address->setLongitude($result['longitude']);
        } catch (\Exception $e){
            return false;
        }

    }
}