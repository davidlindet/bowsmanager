<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 00:37
 * To change this template use File | Settings | File Templates.
 */
namespace Bow\Controller;

use Application\Enum\ModeEnum;
use Application\Enum\SectionEnum;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

use Bow\Model\Bow;
use Bow\Enum\BowEnum;
use Bow\Service\BowService;

use Collection\Service\CollectionService;

use Upload\Service\UploadService;

class BowController extends AbstractActionController
{
    /**
     * @var $bowService BowService
     */
    protected $bowService;

    public function getBowService()
    {
        if (!$this->bowService) {
            $this->bowService = $this->getServiceLocator()->get('BowService');
        }
        return $this->bowService;
    }

    public function indexAction()
    {
        $collectionId = $this->getEvent()->getRouteMatch()->getParam('collectionId');

        return new ViewModel(array(
            'bows' => $this->getBowService()->getAll(),
            'collectionId' => $collectionId,
            'section' => SectionEnum::BOW_INDEX
        ));
    }

    public function saveAction() {
        $params = $this->params()->fromPost();

        /** @var $bowModel Bow */
        $bowModel = $this->getBowService()->getById($params['id']);

        $bowModel->setNumber((int) $params['number']);
        $bowModel->setCollectionId((int) $params['collectionId']);
        $bowModel->setType((int) $params['type']);
        $bowModel->setSize((int) $params['size']);
        $bowModel->setDescription($params['description']);
        $bowModel->setWorkToDo($params['workToDo']);
        $bowModel->setStatus($params['status']);
        $bowModel->setIsDone((isset($params['isDone']) &&  $params['isDone'] == "on") ? true : false);
        $bowModel->setComments($params['comments']);

        if(isset($params['del-attachment'])){
            /** @var UploadService $uploadService */
            $uploadService = $this->getServiceLocator()->get("UploadService");
            foreach($params['del-attachment'] as $attachment) {
                $bowModel->removeAttachment($attachment, $uploadService);
            }
        }

        $result = $this->getBowService()->save($bowModel);
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

        /** @var $bowModel Bow */
        $bowModel = $this->getBowService()->getById(BowEnum::NEW_BOW);
        $bowModel->setCollectionId($collectionId);
        $bowModel->setNumber($this->getBowService()->getNextBowNumber($collectionModel));

        return new ViewModel(array(
            'bow' => $bowModel,
            'section' => $section,
            'mode' => ModeEnum::MODE_REGULAR,
        ));
    }

    public function editAction()
    {
        $bowId = $this->getEvent()->getRouteMatch()->getParam('id', BowEnum::NEW_BOW);
        $section = $this->params()->fromRoute('section', false);
        $mode = $this->params()->fromRoute('mode', false);

        if($mode == ModeEnum::MODE_AJAX){
            $this->layout('layout/empty');
        }

        /** @var $bowModel Bow */
        $bowModel = $this->getBowService()->getById($bowId);

        return new ViewModel(array(
            'bow' => $bowModel,
            'section' => $section,
            'mode' => $mode,
        ));
    }

    public function detailsAction()
    {
        $bowId = $this->getEvent()->getRouteMatch()->getParam('id', BowEnum::NEW_BOW);
        $section = $this->params()->fromRoute('section', false);

        /** @var $bowModel Bow */
        $bowModel = $this->getBowService()->getById($bowId);

        return new ViewModel(array(
            'bow' => $bowModel,
            'section' => $section,
        ));
    }

    public function deleteAction()
    {
        $params = $this->params()->fromPost();

        /** @var $bowModel Bow */
        $success = $this->getBowService()->delete((int) $params['id']);

        $result = new JsonModel($success);

        return $result;
    }

    public function isDoneAction()
    {
        $params = $this->params()->fromPost();

        /** @var $bowModel Bow */
        $bowModel = $this->getBowService()->getById((int) $params['id']);
        $bowModel->setIsDone(true);
        $result = $this->getBowService()->save($bowModel);

        return new JsonModel($result);
    }
}