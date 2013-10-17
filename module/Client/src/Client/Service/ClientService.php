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

class ClientService
{
    /**
     * @var $clientDao ClientDao
     */
    protected $clientDao;

    public function __construct($clientDao){
        $this->clientDao = $clientDao;
    }

    public function getById($clientId){
        $clientId = (int) $clientId;
        return ($clientId == ClientEnum::NEW_CLIENT) ? new Client() : $this->clientDao->getClient($clientId);
    }

    public function getAll($order = ClientEnum::SORT_AZ){
        return $this->clientDao->fetchAll($order);
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
}