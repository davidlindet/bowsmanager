<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 00:37
 * To change this template use File | Settings | File Templates.
 */
namespace Application\Service;

use Application\Dao\ClientDao;
use Application\Model\Client;
use Application\Enum\ClientEnum;

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

    public function getAll(){
        return $this->clientDao->fetchAll();
    }

    public function save($clientModel){
        $success = true;
        try {
            $this->clientDao->saveClient($clientModel);
        }
        catch (Exception $exception) {
            $success = false;
        }

        return $success;
    }
}