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

    public function getAll(){
        $collections = $this->collectionDao->fetchAll();
        return $this->setBows($collections);
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
        return $this->setBows($collections);
    }

    public function getCollectionsNotPaid(){
        $order = CollectionEnum::SORT_NEW_TO_OLD;

        $where = array(
            array(
                "key" => CollectionEnum::ATTR_RETURN_TIME,
                "clause" => ">",
                "value" => CollectionEnum::NO_RETURN_TIME,
            ),
            array(
                "key" => CollectionEnum::ATTR_PAID_STATUS,
                "clause" => "=",
                "value" => "false",
            ),
        );

        $collections = $this->collectionDao->fetchAll($order, $where);
        return $this->setBows($collections);
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

            //delete all attachments related to this collection
            foreach($collection->getAttachments() as $attachment) {
                $collection->removeAttachment($attachment);
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
}