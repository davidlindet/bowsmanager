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

    public function fetchAll($order = ClientEnum::SORT_NATIVE, $dataRequired = array(ClientEnum::ATTR_ALL)) {

        if(($key = array_search(ClientEnum::ATTR_COLLECTIONS, $dataRequired)) !== false) {
            unset($dataRequired[$key]);
        }

        $driver = $this->tableGateway->getAdapter()->getDriver();

        if(empty($dataRequired) || in_array(ClientEnum::ATTR_ALL, $dataRequired)){
            $columns = "*";
        }
        else {
            $columns = "id";
            for($i = 0; $i < count($dataRequired); $i++) {
                if($i < count($dataRequired)){
                    $columns .= ", ";
                }

                $columns .= $dataRequired[$i];
            }
        }
        $orderSql = "";
        if($order == ClientEnum::SORT_AZ){
            $orderSql = "ORDER BY last_name ASC";
        }
        elseif($order == ClientEnum::SORT_ZA){
            $orderSql = "ORDER BY last_name DESC";
        }
        $sql = "SELECT $columns FROM bm_client $orderSql;";

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

    public function fetchAllByQuery($query, $order = ClientEnum::SORT_AZ) {
        $driver = $this->tableGateway->getAdapter()->getDriver();

        if($order == ClientEnum::SORT_AZ){
            $orderSql = "last_name ASC";
        }
        elseif($order == ClientEnum::SORT_ZA){
            $orderSql = "last_name DESC";
        }

        $sql = "SELECT * FROM bm_client WHERE last_name LIKE '%$query%'
                UNION
                SELECT * FROM bm_client WHERE first_name LIKE '%$query%' ORDER BY $orderSql
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

    public function getClient($id, $dataRequired = array(ClientEnum::ATTR_ALL))
    {
        if(($key = array_search(ClientEnum::ATTR_COLLECTIONS, $dataRequired)) !== false) {
            unset($dataRequired[$key]);
        }

        $driver = $this->tableGateway->getAdapter()->getDriver();

        if(empty($dataRequired) || in_array(ClientEnum::ATTR_ALL, $dataRequired)){
            $columns = "*";
        }
        else {
            $columns = "id";
            for($i = 0; $i < count($dataRequired); $i++) {
                if($i < count($dataRequired)){
                    $columns .= ", ";
                }

                $columns .= $dataRequired[$i];
            }
        }
        $sql = "SELECT $columns FROM bm_client WHERE id = $id;";

        $statement = $driver->createStatement($sql);
        $result = $statement->execute();

        $resultSet = new ResultSet;
        $resultSet->initialize($result);
        $data = $resultSet->current();

        $client = new Client();
        $client->exchangeArray($data);

        return $client;
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
            $data['create_time'] = time();
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