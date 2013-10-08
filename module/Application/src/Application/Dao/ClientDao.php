<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 10:36
 * To change this template use File | Settings | File Templates.
 */
namespace Application\Dao;

use Zend\Db\TableGateway\TableGateway;

use Application\Model\Client;
use Application\Enum\ClientEnum;

class ClientDao
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getClient($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveClient(Client $client)
    {
        $data = array(
            'last_name' => $client->getLastName(),
            'first_name'  => $client->getFirstName(),
            'address'  => $client->getAddress(),
            'landline'  => $client->getLandline(),
            'mobile'  => $client->getMobile(),
            'email'  => $client->getEmail(),
            'website'  => $client->getWebsite(),
        );

        $id = (int)$client->getId();
        if ($id == ClientEnum::NEW_CLIENT) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getClient($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Client id does not exist');
            }
        }
    }

    public function deleteClient($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}