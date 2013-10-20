<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 00:37
 * To change this template use File | Settings | File Templates.
 */
namespace Client\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

use Client\Service\ClientService;
use Client\Model\Client;
use Client\Enum\ClientEnum;

class ClientController extends AbstractActionController
{
    /**
     * @var $clientService ClientService
     */
    protected $clientService;

    public function getClientService()
    {
        if (!$this->clientService) {
            $this->clientService = $this->getServiceLocator()->get('ClientService');
        }
        return $this->clientService;
    }

    public function indexAction()
    {
        return new ViewModel(array(
            'clients' => $this->getClientService()->getAll(),
        ));
    }

    public function saveAction() {
        $params = $this->params()->fromPost();

        /** @var $clientModel Client */
        $clientModel = $this->getClientService()->getById($params['id']);

        $clientModel->setFirstName($params['firstName']);
        $clientModel->setLastName($params['lastName']);
        $clientModel->setAddress($params['address']);
        $clientModel->setLandline($params['landline']);
        $clientModel->setMobile($params['mobile']);
        $clientModel->setEmail($params['email']);
        $clientModel->setWebsite($params['website']);

        $result = $this->getClientService()->save($clientModel);
        return new JsonModel($result);
    }

    public function addAction()
    {
        /** @var $clientModel Client */
        $clientModel = $this->getClientService()->getById(ClientEnum::NEW_CLIENT);

        return new ViewModel(array(
            'client' => $clientModel,
        ));
    }

    public function editAction()
    {
        $clientId = $this->getEvent()->getRouteMatch()->getParam('id', ClientEnum::NEW_CLIENT);

        /** @var $clientModel Client */
        $clientModel = $this->getClientService()->getById($clientId);

        return new ViewModel(array(
            'client' => $clientModel,
        ));
    }

    public function detailsAction()
    {
        $clientId = $this->getEvent()->getRouteMatch()->getParam('id', ClientEnum::NEW_CLIENT);

        /** @var $clientModel Client */
        $clientModel = $this->getClientService()->getById($clientId);

        return new ViewModel(array(
            'client' => $clientModel,
        ));
    }

    public function deleteAction()
    {
        $params = $this->params()->fromPost();

        /** @var $clientModel Client */
        $clientModel = $this->getClientService()->getById($params['id']);
        $success = $this->getClientService()->delete($clientModel->getId());

        $result = new JsonModel($success);

        return $result;
    }
}