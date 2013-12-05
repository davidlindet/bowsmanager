<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 00:37
 * To change this template use File | Settings | File Templates.
 */
namespace Bill\Controller;

use Application\Enum\ModeEnum;
use Application\Enum\SectionEnum;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

use Bill\Model\Bill;
use Bill\Enum\BillEnum;
use Bill\Service\BillService;

use Collection\Service\CollectionService;

class BillController extends AbstractActionController
{
    /**
     * @var $billService BillService
     */
    protected $billService;

    public function getBillService()
    {
        if (!$this->billService) {
            $this->billService = $this->getServiceLocator()->get('BillService');
        }
        return $this->billService;
    }

    public function indexAction()
    {
        $collectionId = $this->getEvent()->getRouteMatch()->getParam('collectionId');

        return new ViewModel(array(
            'bills' => $this->getBillService()->getAll(),
            'collectionId' => $collectionId,
            'section' => SectionEnum::BOW_INDEX
        ));
    }

    public function saveAction() {
        $params = $this->params()->fromPost();

        /** @var $billModel Bill */
        $billModel = $this->getBillService()->getById($params['id']);

        $billModel->setNumber((int) $params['number']);
        $billModel->setCollectionId((int) $params['collectionId']);
        $billModel->setType((int) $params['type']);
        $billModel->setSize((int) $params['size']);
        $billModel->setDescription($params['description']);
        $billModel->setWorkToDo($params['workToDo']);
        $billModel->setStatus($params['status']);
        $billModel->setIsDone((isset($params['isDone']) &&  $params['isDone'] == "on") ? true : false);
        $billModel->setComments($params['comments']);

        if(isset($params['del-attachment'])){
            foreach($params['del-attachment'] as $attachment) {
                $billModel->removeAttachment($attachment);
            }
        }

        $result = $this->getBillService()->save($billModel);
        $result['section'] = $params['section'];
        $result['collectionId'] = $params['collectionId'];
        return new JsonModel($result);
    }

    public function addAction()
    {
        $collectionId = $this->getEvent()->getRouteMatch()->getParam('collectionId', false);
        $section = $this->params()->fromRoute('section', false);

        /** @var CollectionService $collectionService */
        $collectionService = $this->getServiceLocator()->get('CollectionService');
        $collectionModel = $collectionService->getById($collectionId);

        /** @var $billModel Bill */
        $billModel = $this->getBillService()->getById(BillEnum::NEW_BOW);
        $billModel->setCollectionId($collectionId);

        return new ViewModel(array(
            'bill' => $billModel,
            'section' => $section,
            'mode' => ModeEnum::MODE_REGULAR,
        ));
    }

    public function editAction()
    {
        $billId = $this->getEvent()->getRouteMatch()->getParam('id', BillEnum::NEW_BOW);
        $section = $this->params()->fromRoute('section', false);
        $mode = $this->params()->fromRoute('mode', false);

        if($mode == ModeEnum::MODE_AJAX){
            $this->layout('layout/empty');
        }

        /** @var $billModel Bill */
        $billModel = $this->getBillService()->getById($billId);

        return new ViewModel(array(
            'bill' => $billModel,
            'section' => $section,
            'mode' => $mode,
        ));
    }

    public function detailsAction()
    {
        $billId = $this->getEvent()->getRouteMatch()->getParam('id', BillEnum::NEW_BOW);
        $section = $this->params()->fromRoute('section', false);

        /** @var $billModel Bill */
        $billModel = $this->getBillService()->getById($billId);

        return new ViewModel(array(
            'bill' => $billModel,
            'section' => $section,
        ));
    }

    public function deleteAction()
    {
        $params = $this->params()->fromPost();

        /** @var $billModel Bill */
        $success = $this->getBillService()->delete((int) $params['id']);

        $result = new JsonModel($success);

        return $result;
    }

}