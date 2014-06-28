<?php

namespace ZE\BABundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\DBAL\Types\Type;
use ZE\BABundle\Entity;

class Association extends EntityRepository
{
    public function getAllBandsOwnedByUserId($userId)
    {
        $qb = $this->createQueryBuilder('a')
            ->where('a.user = :userId')
            ->andWhere('a  INSTANCE OF ZE\BABundle\Entity\Band')
            ->setParameter('userId', $userId);

        return $qb->getQuery()->getResult();
    }

    public function getAllMusiciansOwnedByUserId($userId)
    {
        $qb = $this->createQueryBuilder('a')
            ->where('a.user = :userId')
            ->andWhere('a  INSTANCE OF ZE\BABundle\Entity\Musician')
            ->setParameter('userId', $userId);

        return $qb->getQuery()->getResult();
    }

    public function getAllBandsAssociatedByUserId($userId)
    {
        $qb = $this->createQueryBuilder('a')
            ->innerJoin('a.bandMusician', 'bm')
            ->where('a.id = :associationId')
            ->andWhere('d.type = :documentType')
            ->setParameter('documentType', Entity\Document::DOCUMENT_TYPE_IMAGE);
        $arrResult = array();
        foreach($qb->getQuery()->getResult() as $document){
            $arrResult[] = array(
                'id' => $document->getId(),
                'name' => $document->getName(),
                'webpath' => $document->getWebPath(),
                'association_id' => $document->getAssociation()->getId()
            );
        }
        return $arrResult;
    }

    public function getAllMusiciansByBandId($bandId)
    {

        /*SELECT * FROM association
        INNER JOIN band_musician ON band_musician.musician_id = association.id
        WHERE `type`='musician' AND band_id = 4*/
        $qb = $this->createQueryBuilder('a')
            ->innerJoin('a.BandMusician', 'bm')
            ->where('bm.bandId = :bandId')
            ->andWhere('a  INSTANCE OF ZE\BABundle\Entity\Band')
            ->setParameter('bandId', $bandId);
        return $qb->getQuery()->getResult();
    }

}