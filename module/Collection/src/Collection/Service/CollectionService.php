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

    public function __construct($collectionDao, $bowService){
        $this->collectionDao = $collectionDao;
        $this->bowService = $bowService;
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
        /** @var $collection Collection */
        foreach($collections as &$collection){
            $bows = $this->bowService->getAllByCollection($collection->getId());
            $collection->setBows($bows);
        }

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
}