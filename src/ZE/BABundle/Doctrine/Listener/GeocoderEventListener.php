<?php
namespace ZE\BABundle\Doctrine\Listener;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use ZE\BABundle\Entity\Address;


class GeocoderEventListener
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /** @ORM\PrePersist */
    public function prePersistHandler(Address $address, LifecycleEventArgs $eventArgs) {
        if(($address = $eventArgs->getEntity()) instanceof Address){
            if( !$address->getLatitude() || !$address->getLongitude()){
                $this->geocodeAddress($address);
            }
        }
    }
    /** @ORM\PreUpdate */
    public function preUpdate(Address $address, PreUpdateEventArgs $eventArgs){
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
        $result = $this->container
            ->get('bazinga_geocoder.geocoder')
            ->geocode($address->__toString());
        $address->latitude = $result['latitude'];
        $address->longitude = $result['longitude'];
    }

}