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

use Collection\Service\CollectionService;
use Bow\Service\BowService;

class UploadController extends AbstractActionController
{

    public function collectionAction()
    {
        $response = array('success' => false);
        $id = $this->params()->fromQuery('id', false);

        if($id){
            /** @var CollectionService $collectionService */
            $collectionService = $this->getServiceLocator()->get('CollectionService');
            $response = $this->upload("collection", $id, $collectionService);
        }

        return new JsonModel($response);
    }

    public function bowAction()
    {
        $response = array('success' => false);
        $id = $this->params()->fromQuery('id', false);

        if($id){
            /** @var BowService $bowService */
            $bowService = $this->getServiceLocator()->get('BowService');
            $response = $this->upload("bow", $id, $bowService);
        }

        return new JsonModel($response);
    }


    private function upload($modelType, $modelId, $service){
        $response = array('success' => true);

        try {
            if(!empty($_FILES)){

                $model = $service->getById($modelId);
                $path = __DIR__ . "/../../../../../public/img/attachment/";

                //for each files
                foreach ($_FILES["images"]["error"] as $key => $error) {
                    //check if no errors
                    if ($error == UPLOAD_ERR_OK) {
                        $ext = pathinfo($_FILES["images"]["name"][$key], PATHINFO_EXTENSION);
                        $fileName = $modelType . "-" . $modelId . "-" . $key . "-" . time() .".". $ext;
                        //upload files
                        move_uploaded_file( $_FILES["images"]["tmp_name"][$key], $path . $fileName);
                        $model->addAttachment($fileName);
                    }
                }
                $service->save($model);
            }
        } catch(Exception $e) {
            $response = array('success' => false, 'error' => $e);
        }
        return $response;
    }
}