<?php

namespace ZE\BABundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\DBAL\Types\Type;
use ZE\BABundle\Entity;

class Address extends EntityRepository
{

    public function getClosestAddresses($latitude, $longitude, $distance=10, $association=null)
    {

        $rsm = new ResultSetMapping;

        $rsm->addEntityResult('ZE\BABundle\Entity\Address', 'a');
        $rsm->addFieldResult('a', 'id', 'id');
        $rsm->addFieldResult('a', 'address', 'address');

        $query = $this->_em->createNativeQuery(
            "SELECT a.id,
              ( 3959 * ACOS( COS( RADIANS(?) ) * COS( RADIANS( a.latitude ) ) *
              COS( RADIANS( a.longitude ) - RADIANS(?) ) + SIN( RADIANS(?) ) *
              SIN( RADIANS( a.latitude ) ) ) ) AS distance
              FROM address a
              INNER JOIN city c ON c.id = a.city_id
	          GROUP BY a.id HAVING distance < ?
              ORDER BY distance", $rsm
        );

        $query->setParameter(1, $latitude);
        $query->setParameter(2, $longitude);
        $query->setParameter(3, $latitude);
        $query->setParameter(4, $distance, Type::INTEGER);

        $addresses = $query->getResult();
        $addressIds = array();
        foreach ($addresses as $address){
            $addressIds[] = $address->getId();
        }
        $qb = $this->_em->createQueryBuilder();
        $fields = array('a','a.address','a.latitude','a.longitude','city','country');
        $qb->select($fields)
            ->from('ZE\BABundle\Entity\Address','a')
            ->innerJoin('a.city', 'city')
            ->innerJoin('city.country', 'country')
            ->where($qb->expr()->in('a.id', '?1'))
        ;
        $qb->setParameter(1,$addressIds);

        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function findOneByAddressAndCityAndRegion($address,$city,$region=null)
    {
        $region=null;
        $cityId = $city->getId();
        $qb = $this->createQueryBuilder('a')
            ->innerJoin('a.city', 'city')
            ->innerJoin('city.country', 'country')
            ->where('city.id = :cityId')

            ->andWhere('a.address = :address')
            ->setParameter('cityId', $cityId)
            ->setParameter('address', $address);

            if($region){

                $qb->where('city.region = :regionId')
                    ->setParameter('regionId', $region->getId());
            }
        /*$query=$qb->getQuery();
        $sql=$query->getSQL();
        $parameters=$query->getParameters();
        echo($sql);
        var_dump($parameters);die;*/

        return $qb->getQuery()->getResult();
    }
}