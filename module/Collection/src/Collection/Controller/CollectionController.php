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
        ));
    }
//
//    public function saveAction() {
//        $params = $this->params()->fromPost();
//
//        /** @var $clientModel Client */
//        $clientModel = $this->getClientService()->getById($params['id']);
//
//        $clientModel->setFirstName($params['firstName']);
//        $clientModel->setLastName($params['lastName']);
//        $clientModel->setAddress($params['address']);
//        $clientModel->setLandline($params['landline']);
//        $clientModel->setMobile($params['mobile']);
//        $clientModel->setEmail($params['email']);
//        $clientModel->setWebsite($params['website']);
//
//        $result = $this->getClientService()->save($clientModel);
//        return new JsonModel($result);
//    }
//
//    public function addAction()
//    {
//        /** @var $clientModel Client */
//        $clientModel = $this->getClientService()->getById(ClientEnum::NEW_CLIENT);
//
//        return new ViewModel(array(
//            'client' => $clientModel,
//        ));
//    }
//
//    public function editAction()
//    {
//        $clientId = $this->getEvent()->getRouteMatch()->getParam('id', ClientEnum::NEW_CLIENT);
//
//        /** @var $clientModel Client */
//        $clientModel = $this->getClientService()->getById($clientId);
//
//        return new ViewModel(array(
//            'client' => $clientModel,
//        ));
//    }
//
//    public function detailsAction()
//    {
//        $clientId = $this->getEvent()->getRouteMatch()->getParam('id', ClientEnum::NEW_CLIENT);
//
//        /** @var $clientModel Client */
//        $clientModel = $this->getClientService()->getById($clientId);
//
//        return new ViewModel(array(
//            'client' => $clientModel,
//        ));
//    }
//
//    public function deleteAction()
//    {
//        $params = $this->params()->fromPost();
//
//        /** @var $clientModel Client */
//        $clientModel = $this->getClientService()->getById($params['id']);
//        $success = $this->getClientService()->delete($clientModel->getId());
//
//        $result = new JsonModel($success);
//
//        return $result;
//    }
}