<?php

namespace ZE\BABundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\DBAL\Types\Type;
use ZE\BABundle\Entity;

class Band extends EntityRepository
{
    public function getAllBandsOwnedByUserId($userId)
    {
        $qb = $this->createQueryBuilder('a')
            ->where('a.user = :userId')
            ->andWhere('a  INSTANCE OF ZE\BABundle\Entity\Band')
            ->setParameter('userId', $userId);

        return $qb->getQuery()->getResult();
    }


    public function findAllMusiciansByBandId($bandId, $returnQb=false)
    {
        /*SELECT
        FROM
          band_musician
          INNER JOIN association
            ON band_musician.musician_id = association.id
        WHERE `type` = 'musician'
            AND band_id = 4     */
        $qb = $this->createQueryBuilder('m');
        $qb ->innerJoin('m.bands','bands')
            ->where('bands.id = :bandId')
            ->setParameter('bandId', $bandId);
        if($returnQb){
            return $qb;
        }
        return $qb->getQuery()->getResult();
    }
}