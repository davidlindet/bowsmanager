<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 00:37
 * To change this template use File | Settings | File Templates.
 */
namespace Collection\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

use Bill\Model\Bill;
use Bill\Service\BillService;

use Client\Service\ClientService;
use Client\Enum\ClientEnum;

use Collection\Service\CollectionService;
use Collection\Model\Collection;
use Collection\Enum\CollectionEnum;

class CollectionController extends AbstractActionController
{
    /**
     * @var $collectionService CollectionService
     */
    protected $collectionService;

    public function getCollectionService()
    {
        if (!$this->collectionService) {
            $this->collectionService = $this->getServiceLocator()->get('CollectionService');
        }
        return $this->collectionService;
    }

    public function indexAction()
    {
        return new ViewModel(array(
            'collections' => $this->getCollectionService()->getAll(),
            'header' => 'Collections List',
        ));
    }

    public function saveAction() {
        $params = $this->params()->fromPost();

        //update collection
        /** @var $collectionModel Collection */
        $collectionModel = $this->getCollectionService()->getById($params['id']);

        $collectionModel->setOwnerId($params['owner']);
        $collectionModel->setReceptionTime(strtotime($params['receptionTime']));
        $collectionModel->setReturnTime(strtotime($params['returnTime']));
        $collectionModel->setPackageNumber($params['packageNumber']);
        $collectionModel->setComments($params['comments']);

        $result = $this->getCollectionService()->save($collectionModel);
        $result['section'] = $params['section'];
        return new JsonModel($result);
    }

    public function addAction()
    {
        $clientId = $this->getEvent()->getRouteMatch()->getParam('clientId', false);
        $section = $this->params()->fromRoute('section', false);

        /** @var $collectionModel Collection */
        $collectionModel = $this->getCollectionService()->getById(CollectionEnum::NEW_COLLECTION);

        /** @var $clientService ClientService */
        $clientService = $this->getServiceLocator()->get('ClientService');
        $attributes = array(ClientEnum::ATTR_FIRST_NAME,
            ClientEnum::ATTR_LAST_NAME,
        );

        $clients = array();
        if(!$clientId){
            $clients = $clientService->getAll(ClientEnum::SORT_AZ, $attributes);
        }
        else {
            $client = $clientService->getById($clientId, $attributes);
            $collectionModel->setOwnerId($client->getId());
            $collectionModel->setOwnerName($client->getName(false));
        }

        return new ViewModel(array(
            'collection' => $collectionModel,
            'clients' => $clients,
            'section' => $section,
        ));
    }

    public function editAction()
    {
        $collectionId = $this->getEvent()->getRouteMatch()->getParam('id', CollectionEnum::NEW_COLLECTION);
        $section = $this->params()->fromRoute('section', false);

        /** @var $collectionModel Collection */
        $collectionModel = $this->getCollectionService()->getById($collectionId);

        /** @var $clientService ClientService */
        $clientService = $this->getServiceLocator()->get('ClientService');
        $attributes = array(ClientEnum::ATTR_FIRST_NAME,
            ClientEnum::ATTR_LAST_NAME,
        );

        $clients = $clientService->getAll(ClientEnum::SORT_AZ, $attributes);


        return new ViewModel(array(
            'collection' => $collectionModel,
            'section' => $section,
            'clients' => $clients,
        ));
    }

    public function detailsAction()
    {
        $section = $this->params()->fromRoute('section', false);
        $collectionId = $this->params()->fromRoute('id', CollectionEnum::NEW_COLLECTION);

        /** @var $collectionModel Collection */
        $collectionModel = $this->getCollectionService()->getById($collectionId);

        return new ViewModel(array(
            'collection' => $collectionModel,
            'section' => $section,
        ));
    }

    public function deleteAction()
    {
        $params = $this->params()->fromPost();

        /** @var $collectionModel Collection */
        $collectionModel = $this->getCollectionService()->getById($params['id']);
        $success = $this->getCollectionService()->delete($collectionModel);

        return new JsonModel($success);
    }
}