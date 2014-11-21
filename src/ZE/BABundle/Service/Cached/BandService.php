<?php
/**
 * Created by PhpStorm.
 * User: zach
 * Date: 20/11/14
 * Time: 23:40
 */

namespace ZE\BABundle\Service\Cached;


use Doctrine\ORM\Tools\Pagination\Paginator;

class BandService extends ServiceAbstract
{
    /**
     * @param $userId
     * @param $page
     * @param $limit
     * @return array
     */
    public function findAllBandsWithVacancies($userId, $page, $limit)
    {
        $predis = new \Snc\RedisBundle\Doctrine\Cache\RedisCache();
        $predis->setRedis(new \Predis\Client());
        $bands = $this->getCachedByParams(array('userId' => $userId, 'page' => $page, 'limit' => $limit));
        if (empty($bands)) {
//            $repository = $this->em->getRepository('ZEBABundle:Band');
            $dql = "
              SELECT b,g, a,m,mg
              FROM ZEBABundle:Band b
              LEFT JOIN b.genres g
              LEFT JOIN b.addresses a
              LEFT JOIN b.musicians m
              LEFT JOIN m.genres mg

            ";

            $query = $this->em->createQuery($dql)
                ->setFirstResult(($page-1) * $limit )
                ->setMaxResults($limit)
                ->setResultCacheDriver($this->cacheProvider)
                ->setResultCacheLifetime(86400)
            ;
            $query->getArrayResult();
            $paginator = new Paginator($query, $fetchJoinCollection = true);
            return iterator_to_array($paginator,true);



        }
    }
} 