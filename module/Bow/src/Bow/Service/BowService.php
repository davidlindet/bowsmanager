<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 00:37
 * To change this template use File | Settings | File Templates.
 */
namespace Bow\Service;

use Bow\Enum\BowSizeEnum;
use Bow\Enum\BowTypeEnum;
use Bow\Model\Bow;
use Bow\Dao\BowDao;
use Bow\Enum\BowEnum;
use Collection\Model\Collection;

use Upload\Service\UploadService;

class BowService
{
    /**
     * @var $bowDao BowDao
     */
    protected $bowDao;

    /**
     * @var $uploadService UploadService
     */
    protected $uploadService;

    public function __construct($bowDao, $uploadService){
        $this->bowDao = $bowDao;
        $this->uploadService = $uploadService;
    }

    public function getAll(){
        return $this->bowDao->fetchAll();
    }

    public function getAllByCollection($collectionId){
        return $this->bowDao->fetchAllByCollection($collectionId);
    }

    public function getById($bowId){
        $bowId = (int) $bowId;

        $bowModel = null;
        if($bowId == BowEnum::NEW_BOW) {
            $bowModel = new Bow();
            $bowModel->setSize(BowSizeEnum::FOUR_QUARTERS);
        } else {
            $bowModel = $this->bowDao->getBow($bowId);
        }
        return $bowModel;
    }

    public function save($bowModel){
        try {
            $bowId = $this->bowDao->saveBow($bowModel);
            $result = array('success'=> true, 'id' => (int) $bowId);
        }
        catch (Exception $exception) {
            error_log($exception);
            $result = array('success'=> false, 'error' => $exception);
        }
        return $result;
    }

    public function delete($bowId){
        try {
            //delete all attachments related to this bow
            $bowModel = $this->getById($bowId);
            foreach($bowModel->getAttachments() as $attachment) {
                $bowModel->removeAttachment($attachment, $this->uploadService);
            }
            //delete bow in the database
            $this->bowDao->deleteBow($bowId);
            $result = array('success'=> true);
        }
        catch (Exception $exception) {
            error_log($exception);
            $result = array('success'=> false, 'error' => $exception);
        }
        return $result;
    }

    public function search($query) {
        return $this->bowDao->fetchAllByQuery($query);
    }

    public function getNextBowNumber(Collection $collection){
        return $collection->countBows() + 1;
    }
}