<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 00:37
 * To change this template use File | Settings | File Templates.
 */
namespace Client\Service;

use Client\Dao\ClientDao;
use Client\Model\Client;
use Client\Enum\ClientEnum;
use Collection\Service\CollectionService;

class ClientService
{
    /**
     * @var $clientDao ClientDao
     */
    protected $clientDao;

    /** @var  $collectionService CollectionService */
    protected $collectionService;

    public function __construct($clientDao, $collectionService){
        $this->clientDao = $clientDao;
        $this->collectionService = $collectionService;
    }

    public function getById($clientId){
        $clientId = (int) $clientId;

        $client = null;
        if($clientId == ClientEnum::NEW_CLIENT){
            $client = new Client();
        }
        else {
            $client = $this->clientDao->getClient($clientId);
            $collections = $this->collectionService->getByOwner($client->getId());
            $client->setCollections($collections);
        }
        return $client;
    }

    public function getAll($order = ClientEnum::SORT_AZ){
        $clients = $this->clientDao->fetchAll($order);
        return $this->setCollections($clients);
    }

    public function save($clientModel){
        try {
            $clientId = $this->clientDao->saveClient($clientModel);
            $result = array('success'=> true, 'id' => (int) $clientId);
        }
        catch (Exception $exception) {
            error_log($exception);
            $result = array('success'=> false, 'error' => $exception);
        }
        return $result;
    }

    public function delete($clientId){
        try {
            $this->clientDao->deleteClient($clientId);
            $result = array('success'=> true);
        }
        catch (Exception $exception) {
            error_log($exception);
            $result = array('success'=> false, 'error' => $exception);
        }
        return $result;
    }

    public function search($query) {
        $clients = $this->clientDao->fetchAllByQuery($query);
        return $this->setCollections($clients);
    }

    public function setCollections($clients){
        $finalClients =  array();

        /** @var $client Client */
        foreach($clients as $client) {
            $collections = $this->collectionService->getByOwner($client->getId());
            $client->setCollections($collections);
            $finalClients[] = $client;
        }
        return $finalClients;
    }
}