<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 00:37
 * To change this template use File | Settings | File Templates.
 */
namespace Collection\Service;

use Bow\Service\BowService;
use Bill\Service\BillService;

use Collection\Dao\CollectionDao;
use Collection\Model\Collection;
use Collection\Enum\CollectionEnum;

use Bow\Model\Bow;

class CollectionService
{
    /**
     * @var $collectionDao CollectionDao
     */
    protected $collectionDao;

    /**
     * @var $bowService BowService
     */
    protected $bowService;

    /**
     * @var $billService BillService
     */
    protected $billService;

    public function __construct($collectionDao, $bowService, $billService){
        $this->collectionDao = $collectionDao;
        $this->bowService = $bowService;
        $this->billService = $billService;
    }

    public function getById($collectionId){
        $collectionId = (int) $collectionId;

        if($collectionId ==  CollectionEnum::NEW_COLLECTION){
            $collection = new Collection();
        }
        else {
            $collection = $this->collectionDao->getCollection($collectionId);
            $bows = $this->bowService->getAllByCollection($collection->getId());
            $collection->setBows($bows);

            $bills = $this->billService->getAllByCollection($collectionId);
            $collection->setBills($bills);
        }
        return $collection;
    }

    public function getByOwner($ownerId){
        $ownerId = (int) $ownerId;
        $collections = $this->collectionDao->fetchAllByOwner($ownerId);

        /** @var $collection Collection */
        foreach($collections as &$collection){
            $bows = $this->bowService->getAllByCollection($collection->getId());
            $collection->setBows($bows);
        }

        return $collections;
    }

    /**
     * Return Collection array with or without bows data
     * @param bool $setBows
     * @return array
     */
    public function getAll($setBows = true, $setBills = true){
        $collections = $this->collectionDao->fetchAll();
        if($setBows){
            $collections = $this->setBows($collections);
        }
        if($setBills){
            $collections = $this->setBills($collections);
        }
        return $collections;
    }

    public function getCollectionsNotSent(){
        $order = CollectionEnum::SORT_NEW_TO_OLD;

        $where = array(
            array(
                "key" => CollectionEnum::ATTR_RETURN_TIME,
                "clause" => "=",
                "value" => CollectionEnum::NO_RETURN_TIME,
            )
        );

        $collections = $this->collectionDao->fetchAll($order, $where);
        $collections = $this->setBows($collections);
        $collections = $this->setBills($collections);
        return $collections;
    }

    public function getCollectionsNotPaid(){
        $order = CollectionEnum::SORT_NEW_TO_OLD;

        $collectionIds = $this->billService->getCollectionsIdWhereBillNotPaid();

        $where = array(
            array(
                "key" => CollectionEnum::ATTR_RETURN_TIME,
                "clause" => ">",
                "value" => CollectionEnum::NO_RETURN_TIME,
            ),
            array(
                "key" => CollectionEnum::ATTR_ID,
                "clause" => "IN",
                "value" => "(" . implode(",", $collectionIds) . ")",
            ),
        );

        $collections = $this->collectionDao->fetchAll($order, $where);
        $collections = $this->setBows($collections);
        $collections = $this->setBills($collections);
        return $collections;
    }

    public function save(Collection $collectionModel){
        try {
            $collectionId = $this->collectionDao->saveCollection($collectionModel);
            $result = array('success'=> true, 'id' => (int) $collectionId);
        }
        catch (Exception $exception) {
            error_log($exception);
            $result = array('success'=> false, 'error' => $exception);
        }
        return $result;
    }

    public function delete(Collection $collection){
        try {
            $bows = $collection->getBows();
            /** @var $bow Bow */
            foreach($bows as $bow) {
                $this->bowService->delete($bow->getId());
            }

            $this->collectionDao->deleteCollection($collection->getId());
            $result = array('success'=> true);
        }
        catch (Exception $exception) {
            error_log($exception);
            $result = array('success'=> false, 'error' => $exception);
        }
        return $result;
    }

    public function search($query) {
        $collections = $this->collectionDao->fetchAllByQuery($query);
        return $this->setBows($collections);
    }

    /**
     * For each collections get and set bows related to them
     * @param $collections
     * @return array
     */
    private function setBows($collections){
        $finalCollections = array();
        /** @var $collection Collection */
        foreach($collections as $collection){
            $bows = $this->bowService->getAllByCollection($collection->getId());
            $collection->setBows($bows);
            $finalCollections[$collection->getId()] = $collection;
        }
        return $finalCollections;
    }

    /**
     * For each collections get and set bills related to them
     * @param $collections
     * @return array
     */
    private function setBills($collections){
        $finalCollections = array();
        /** @var $collection Collection */
        foreach($collections as $collection){
            $bills = $this->billService->getAllByCollection($collection->getId());
            $collection->setBills($bills);
            $finalCollections[$collection->getId()] = $collection;
        }
        return $finalCollections;
    }
}