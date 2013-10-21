<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 10:36
 * To change this template use File | Settings | File Templates.
 */
namespace Client\Dao;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;

use Client\Model\Client;
use Client\Enum\ClientEnum;

class ClientDao
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll($order = ClientEnum::SORT_NATIVE) {
        $select = new Select();
        $select->from("client");

       // $select->where("SELECT * FROM client");
        if($order == ClientEnum::SORT_AZ){
            $select->order('last_name ASC');
        }
        elseif($order == ClientEnum::SORT_ZA){
            $select->order('last_name DESC');
        }

        $resultSet = $this->tableGateway->selectWith($select);

        return $resultSet;
    }

    public function fetchAllByQuery($query, $order = ClientEnum::SORT_AZ) {
        $driver = $this->tableGateway->getAdapter()->getDriver();

        if($order == ClientEnum::SORT_AZ){
            $orderSql = "last_name ASC";
        }
        elseif($order == ClientEnum::SORT_ZA){
            $orderSql = "last_name DESC";
        }

        $sql = "SELECT * FROM client WHERE last_name LIKE '%$query%'
                UNION
                SELECT * FROM client WHERE first_name LIKE '%$query%' ORDER BY $orderSql
              ;
        ";

        $statement = $driver->createStatement($sql);
        $result = $statement->execute();

        $resultSet = new ResultSet;
        $resultSet->initialize($result);

        $clients = array();
        foreach($resultSet as $data){
            $client = new Client();
            $client->exchangeArray($data);
            $clients[$client->getId()] = $client;
        }
        return $clients;
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

        $id = (int) $client->getId();
        if ($id == ClientEnum::NEW_CLIENT) {
            $this->tableGateway->insert($data);
            $id = $this->tableGateway->lastInsertValue;
        } else {
            if ($this->getClient($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            }
            else {
                throw new \Exception('Client id does not exist');
            }
        }
        return $id;
    }

    public function deleteClient($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}