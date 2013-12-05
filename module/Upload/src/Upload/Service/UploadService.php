<?php
/**
 * Created by PhpStorm.
 * User: Ukiitan
 * Date: 05/12/13
 * Time: 15:24
 */
namespace Upload\Service;

use Bill\Model\Bill;
use Bill\Service\BillService;
use Bow\Service\BowService;
use Upload\Enum\UploadEnum;

class UploadService {

    public function deleteFile($fileName) {
        unlink(__DIR__ . UploadEnum::PATH . $fileName);
    }

    public function uploadBill($id, BillService $billService){
        $response = array('success' => true);

        try {
            if(!empty($_FILES)){
                $path = __DIR__ . UploadEnum::PATH;

                /** @var Bill $bill */
                $bill = $billService->getById($id);

                //for each files
                foreach ($_FILES["images"]["error"] as $key => $error) {
                    //check if no errors
                    if ($error == UPLOAD_ERR_OK) {
                        $type = UploadEnum::TYPE_BILL;
                        $id = $bill->getId();
                        $originalName = $bill->getReference();
                        $ext = pathinfo($_FILES["images"]["name"][$key], PATHINFO_EXTENSION);

                        // define a unique name per file
                        $fileName = $type . "-" . $id . "-" . $key . "-" . time() . "-" . $originalName .".". $ext;
                        //upload files
                        move_uploaded_file( $_FILES["images"]["tmp_name"][$key], $path . $fileName);
                        $bill->addAttachment($fileName);
                    }
                }
                $billService->save($bill);
            }
        } catch(Exception $e) {
            $response = array('success' => false, 'error' => $e);
        }
        return $response;
    }

    public function uploadBowsAttachment($id, BowService $bowService){
        $response = array('success' => true);

        try {
            if(!empty($_FILES)){
                $bow = $bowService->getById($id);
                $path = __DIR__ . UploadEnum::PATH;

                //for each files
                foreach ($_FILES["images"]["error"] as $key => $error) {
                    //check if no errors
                    if ($error == UPLOAD_ERR_OK) {
                        $ext = pathinfo($_FILES["images"]["name"][$key], PATHINFO_EXTENSION);
                        $originalName = str_replace(".".$ext, "", $_FILES["images"]["name"][$key]);
                        $fileName = UploadEnum::TYPE_BOW . "-" . $id . "-" . $key . "-" . time() . "-" . $originalName .".". $ext;
                        //upload files
                        move_uploaded_file( $_FILES["images"]["tmp_name"][$key], $path . $fileName);
                        $bow->addAttachment($fileName);
                    }
                }
                $bowService->save($bow);
            }
        } catch(Exception $e) {
            $response = array('success' => false, 'error' => $e);
        }
        return $response;
    }

}

