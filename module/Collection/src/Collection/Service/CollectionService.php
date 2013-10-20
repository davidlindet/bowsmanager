<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 00:37
 * To change this template use File | Settings | File Templates.
 */
namespace Collection\Service;

use Collection\Dao\CollectionDao;
use Collection\Model\Collection;
use Collection\Enum\CollectionEnum;

class CollectionService
{
    /**
     * @var $collectionDao CollectionDao
     */
    protected $collectionDao;

    public function __construct($collectionDao){
        $this->collectionDao = $collectionDao;
    }

    public function getById($collectionId){
        $collectionId = (int) $collectionId;
        return ($collectionId == CollectionEnum::NEW_COLLECTION) ? new Collection() : $this->collectionDao->getCollection($collectionId);
    }

    public function getByOwner($ownerId){
        $ownerId = (int) $ownerId;
        return $this->collectionDao->fetchAllByOwner($ownerId);
    }

    public function getAll(){
        return $this->collectionDao->fetchAll();
    }

    public function save($collectionModel){
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

    public function delete($collectionId){
        try {
            $this->collectionDao->deleteCollection($collectionId);
            $result = array('success'=> true);
        }
        catch (Exception $exception) {
            error_log($exception);
            $result = array('success'=> false, 'error' => $exception);
        }
        return $result;
    }
}