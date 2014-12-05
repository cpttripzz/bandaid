<?php
/**
 * Created by PhpStorm.
 * User: zach
 * Date: 20/11/14
 * Time: 23:40
 */

namespace ZE\BABundle\Service\Cached;


use Doctrine\ORM\Tools\Pagination\Paginator;

class UserItemsService extends ServiceAbstract
{
    /**
     * @param $userId
     * @param $page
     * @param $limit
     * @return array
     */
    public function findAll($page, $limit,$userId=null)
    {
        $bands = $this->getCachedByParams(array('userId' => $userId, 'page' => $page, 'limit' => $limit));
        if (empty($bands)) {

            $dql = "
              SELECT b, bg, ba, br, bac, bacc, m, mg, mi, ma, mr, mac, macc, bd, md
              FROM ZEBABundle:Band b
              LEFT JOIN b.genres bg
              LEFT JOIN b.addresses ba
              LEFT JOIN ba.region br
              LEFT JOIN ba.city bac
              LEFT JOIN bac.country bacc
              LEFT JOIN b.documents bd
              LEFT JOIN b.musicians m
              LEFT JOIN m.genres mg
              LEFT JOIN m.instruments mi
              LEFT JOIN m.addresses ma
              LEFT JOIN ma.region mr
              LEFT JOIN ma.city mac
              LEFT JOIN mac.country macc
              LEFT JOIN m.documents md
            ";

            if($withVacancies){
                $dql .= ' INNER JOIN b.bandVacancyAssociations bva ';
            }
            $query = $this->em->createQuery($dql)
                ->setFirstResult(($page-1) * $limit )
                ->setMaxResults($limit)
                ->setResultCacheDriver($this->cacheProvider)
                ->setResultCacheLifetime(86400)
            ;
            $query->getArrayResult();
            $paginator = new Paginator($query, $fetchJoinCollection = true);
            $totalItems = count($paginator);
            $pagesCount = ceil($totalItems / $limit);
            $arrEntity = iterator_to_array($paginator,true);
            $arrGenres = $arrAddresses = $arrInstruments = $arrCities =
                $arrCountries = $arrRegions = $arrMusicians = $arrDocuments = array();


            foreach($arrEntity as $keyEntity => &$arrEnt){
                $this->sideloadEntity($arrEnt, $arrAddress, $arrGenres, $arrCountries, $arrCities, $arrRegions, $arrAddresses,$arrDocuments);
                foreach($arrEnt['musicians'] as &$musician) {
                    $this->sideloadEntity($musician, $arrAddress, $arrGenres, $arrCountries, $arrCities, $arrRegions, $arrAddresses,$arrDocuments,$arrInstruments);
                }
                $this->sideloadData('musicians', $arrEnt,$arrMusicians);

                unset($arrEnt['addresses']);
                unset($arrEnt['musicians']);
//                unset($arrEnt['genres']);

            }
            $meta = array('total'=>$totalItems,'pagesCount'=>$pagesCount);

            return array(
                'bands' => $arrEntity,'genres' =>$arrGenres,'documents'=>$arrDocuments, 'meta' =>$meta
            );
            return array(
                'bands' => $arrEntity,'genres' =>$arrGenres,'countries' =>$arrCountries,
                'regions' => $arrRegions,'cities' =>$arrCities,'addresses' => $arrAddresses,
                'musicians' => $arrMusicians, 'instruments' => $arrInstruments,'meta' =>$meta
            );



        }
    }



    /**
     * @param $arrEnt
     * @param $arrAddress
     * @param $arrGenres
     * @param $arrCountries
     * @param $arrCities
     * @param $arrRegions
     * @param $arrAddresses
     * @param array $arrInstruments
     */
    protected function sideloadEntity(&$arrEnt, &$arrAddress, &$arrGenres, &$arrCountries, &$arrCities, &$arrRegions, &$arrAddresses, &$arrDocuments, &$arrInstruments=array())
    {
        $this->sideloadData('genres', $arrEnt, $arrGenres);
        if(isset($arrEnt['instruments'])){
            $this->sideloadData('instruments', $arrEnt,$arrInstruments);
        }
        foreach ($arrEnt['addresses'] as $keyAddress => &$arrAddress) {
            if (!empty($arrAddress['city'])) {
                $this->sideloadData('country', $arrAddress['city'], $arrCountries);
                $arrAddress['country'] = $arrAddress['city']['country'][0];
                unset($arrAddress['city']['country']);
                $this->sideloadData('city', $arrAddress, $arrCities);
                $this->sideloadData('region', $arrAddress, $arrRegions);
            }
        }
        $this->sideloadData('addresses', $arrEnt, $arrAddresses);
        $this->sideloadData('documents', $arrEnt, $arrDocuments);
    }
} 