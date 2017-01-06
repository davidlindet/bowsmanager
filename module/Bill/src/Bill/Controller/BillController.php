<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 00:37
 * To change this template use File | Settings | File Templates.
 */
namespace Bill\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

use Application\Enum\SectionEnum;
use Application\Enum\ModeEnum;

use Bill\Model\Bill;
use Bill\Enum\BillEnum;
use Bill\Service\BillService;

use Collection\Service\CollectionService;

use Upload\Service\UploadService;

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
        return new ViewModel(array(
            'bills' => $this->getBillService()->getAll(),
            'section' => SectionEnum::BILL_INDEX,
            'header' => "Bills List",
        ));
    }

    public function saveAction() {
        $params = $this->params()->fromPost();

        /** @var $billModel Bill */
        $billModel = $this->getBillService()->getById($params['id']);

        $billModel->setCollectionId((int) $params['collectionId']);
        $billModel->setReference($params['reference']);
        $billModel->setAmount((float) $params['amount']);
        $billModel->setIsPaid(isset($params['isPaid']));
        $billModel->setPaymentType(isset($params['paymentType']) ? $params['paymentType'] : null);

        if(isset($params['del-attachment'])){
            /** @var $uploadService UploadService */
            $uploadService = $this->getServiceLocator()->get('UploadService');
            foreach($params['del-attachment'] as $attachment) {
                $billModel->removeAttachment($attachment, $uploadService);
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
        $mode = $this->params()->fromRoute('mode', false);

        if($mode == ModeEnum::MODE_AJAX){
            $this->layout('layout/empty');
        }

        /** @var CollectionService $collectionService */
        $collectionService = $this->getServiceLocator()->get('CollectionService');
        $collections = ($collectionId && $collectionId != BillEnum::NO_COLLECTION) ? $collectionService->getById($collectionId) : $collectionService->getAll(false);

        /** @var $billModel Bill */
        $billModel = $this->getBillService()->getById(BillEnum::NEW_BILL);
        $billModel->setCollectionId($collectionId);

        return new ViewModel(array(
            'bill' => $billModel,
            'section' => $section,
            'collections' => $collections,
            'mode' => $mode,
        ));
    }

    public function editAction()
    {
        $billId = $this->getEvent()->getRouteMatch()->getParam('id', BillEnum::NEW_BILL);
        $section = $this->params()->fromRoute('section', false);
        $mode = $this->params()->fromRoute('mode', false);

        if($mode == ModeEnum::MODE_AJAX){
            $this->layout('layout/empty');
        }

        /** @var $billModel Bill */
        $billModel = $this->getBillService()->getById($billId);

        /** @var CollectionService $collectionService */
        $collectionService = $this->getServiceLocator()->get('CollectionService');
        $collections = $collectionService->getAll(false, false);

        return new ViewModel(array(
            'bill' => $billModel,
            'section' => $section,
            'collections' => $collections,
            'mode' => $mode,
        ));
    }

    public function detailsAction()
    {
        $billId = $this->getEvent()->getRouteMatch()->getParam('id', BillEnum::NEW_BILL);
        $section = $this->params()->fromRoute('section', false);
        $mode = $this->params()->fromRoute('mode', false);

        if($mode == ModeEnum::MODE_AJAX){
            $this->layout('layout/empty');
        }

        /** @var $billModel Bill */
        $billModel = $this->getBillService()->getById($billId);

        if($billModel->getCollectionId() != BillEnum::NO_COLLECTION) {
            /** @var CollectionService $collectionService */
            $collectionService = $this->getServiceLocator()->get('CollectionService');
            $collection = $collectionService->getById($billModel->getCollectionId());
            $billModel->setCollectionName($collection->getName());
        }

        return new ViewModel(array(
            'bill' => $billModel,
            'section' => $section,
            'mode' => $mode,
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

    public function isPaidAction()
    {
        $params = $this->params()->fromPost();
        /** @var $billModel Bill */
        $billModel = $this->getBillService()->getById((int) $params['id']);
        $billModel->setIsPaid(true);
        $billModel->setPaymentType($params['payment_type']);
        $result = $this->getBillService()->save($billModel);
        return new JsonModel($result);
    }

}