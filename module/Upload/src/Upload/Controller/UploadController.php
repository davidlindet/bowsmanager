<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 00:37
 * To change this template use File | Settings | File Templates.
 */
namespace Upload\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

use Bow\Service\BowService;
use Bill\Service\BillService;
use Upload\Service\UploadService;

class UploadController extends AbstractActionController
{
    /**
     * @var $uploadService UploadService
     */
    protected $uploadService;

    public function getUploadService()
    {
        if (!$this->uploadService) {
            $this->uploadService = $this->getServiceLocator()->get('UploadService');
        }
        return $this->uploadService;
    }

    /**
     * Upload a bill
     * @return JsonModel
     */
    public function billAction()
    {
        $response = array('success' => false);
        $id = $this->params()->fromQuery('id', false);

        //if there is a file to upload
        if(!empty($_FILES)){
            // if it's relative to a collection
            if($id){
                /** @var BillService $billService */
                $billService = $this->getServiceLocator()->get('BillService');
                $response = $this->getUploadService()->uploadBill($id, $billService);
            }
        }
        return new JsonModel($response);
    }

    /**
     * Upload bow's attachments
     * @return JsonModel
     */
    public function bowAction()
    {
        $response = array('success' => false);
        $id = $this->params()->fromQuery('id', false);

        if($id){
            /** @var BowService $bowService */
            $bowService = $this->getServiceLocator()->get('BowService');
            $response = $this->getUploadService()->uploadBowsAttachment($id, $bowService);
        }

        return new JsonModel($response);
    }
}