<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 00:37
 * To change this template use File | Settings | File Templates.
 */
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Application\Service\BowService;

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
        return new ViewModel(array(
            'bows' => $this->getBowService()->getAll(),
        ));
    }

    public function addAction()
    {
    }

    public function editAction()
    {
    }

    public function deleteAction()
    {
    }
}