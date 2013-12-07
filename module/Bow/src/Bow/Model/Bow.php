<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 10:18
 * To change this template use File | Settings | File Templates.
 */
namespace Bow\Model;

use Upload\Service\UploadService;

class Bow
{
    private $id;

    private $number;

    private $collectionId;

    /**
     * 0 - violin
     * 1 - cello
     * 2 - alto
     * 3 - doublebass
     */
    private $type;

    /**
     * 0 - 1/4
     * 1 - 1/2
     * 2 - 3/4
     * 3 - 4/4
     * 4 - baroque
     */
    private $size;

    /**
     * Brand and component information
     */
    private $description;

    private $workToDo;

    /**
     * Is there any particular issue
     */
    private $status;

    private $isDone;

    /**
     * It was hard to rehair/fix it because of...
     */
    private $comments;

    /**
     * Pictures of the bow
     */
    private $attachments;

    public function exchangeArray($data)
    {
        $this->id = (isset($data['id'])) ? (int) $data['id'] : null;
        $this->number = (isset($data['number'])) ? (int) $data['number'] : null;
        $this->collectionId = (isset($data['collection_id'])) ? (int) $data['collection_id'] : null;
        $this->type = (isset($data['type'])) ? (int) $data['type'] : null;
        $this->size =(isset($data['size'])) ? (int) $data['size'] : null;
        $this->description =(!empty($data['description'])) ? $data['description'] : null;
        $this->workToDo = (!empty($data['work_to_do'])) ? $data['work_to_do'] : null;
        $this->status = (!empty($data['status'])) ? $data['status'] : null;
        $this->isDone = (isset($data['is_done'])) ? (boolean) $data['is_done'] : null;
        $this->comments = (!empty($data['comments'])) ? $data['comments'] : null;

        $attachements = array();
        if(!empty($data['attachments'])) {
            foreach(explode("--", $data['attachments']) as $attachement){
                $attachements[$attachement] = $attachement;
            }
        }
        $this->attachments =  $attachements;
    }

    /************
     * ID
     ************/
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /************
     * NUMBER
     ************/
    /**
     * @param mixed $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }


    /************
     * COLLECTION ID
     ************/
    /**
     * @param mixed $collectionId
     */
    public function setCollectionId($collectionId)
    {
        $this->collectionId = $collectionId;
    }

    /**
     * @return mixed
     */
    public function getCollectionId()
    {
        return (int) $this->collectionId;
    }

    /************
     * TYPE
     ************/
    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /************
     * SIZE
     ************/
    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /************
     * DESCRIPTION
     ************/
    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return stripslashes($this->description);
    }

    /************
     * WORK TO DO
     ************/
    /**
     * @param mixed $workToDo
     */
    public function setWorkToDo($workToDo)
    {
        $this->workToDo = $workToDo;
    }

    /**
     * @return mixed
     */
    public function getWorkToDo()
    {
        return stripslashes($this->workToDo);
    }

    /************
     * STATUS
     ************/
    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return stripslashes($this->status);
    }

    /************
     * IS DONE
     ************/
    /**
     * @param mixed $isDone
     */
    public function setIsDone($isDone)
    {
        $this->isDone = $isDone;
    }

    /**
     * @return mixed
     */
    public function getIsDone()
    {
        return $this->isDone;
    }

    /************
     * COMMENTS
     ************/
    /**
     * @param mixed $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    /**
     * @return mixed
     */
    public function getComments()
    {
        return stripslashes($this->comments);
    }

    /************
     * ATTACHEMENTS
     ************/
    /**
     * @param mixed $attachments
     */
    public function setAttachments($attachments)
    {
        $this->attachments = $attachments;
    }

    /**
     * @return mixed
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * @param $attachment add 1 file
     */
    public function addAttachment($attachment)
    {
        $this->attachments[$attachment] = $attachment;
    }

    /**
     * @param $fileName remove 1 file (from the server as well)
     */
    public function removeAttachment($fileName, UploadService $uploadService)
    {
        unset($this->attachments[$fileName]);
        $uploadService->deleteFile($fileName);
    }

    /**
     * @return bool contain files
     */
    public function hasAttachments()
    {
        return empty($this->attachments) ? false : true;
    }


}