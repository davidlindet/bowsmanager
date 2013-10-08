<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 10:18
 * To change this template use File | Settings | File Templates.
 */
namespace Application\Model;

class Bow
{
    private $id;

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

    public function exchangeArray($data)
    {
        $this->id = (!empty($data['id'])) ? $data['id'] : null;
        $this->type = (!empty($data['type'])) ? $data['type'] : null;
        $this->size =(!empty($data['size'])) ? $data['size'] : null;
        $this->description =(!empty($data['description'])) ? $data['description'] : null;
        $this->workToDo = (!empty($data['work_to_do'])) ? $data['work_to_do'] : null;
        $this->status = (!empty($data['status'])) ? $data['status'] : null;
        $this->isDone = (!empty($data['is_done'])) ? $data['is_done'] : null;
        $this->comments = (!empty($data['comments'])) ? $data['comments'] : null;
    }

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
        return $this->comments;
    }

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
        return $this->description;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

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
        return $this->status;
    }

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
        return $this->workToDo;
    }


}