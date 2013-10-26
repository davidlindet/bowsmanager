<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Collection\Service\CollectionService;

class IndexController extends AbstractActionController
{
    /**
     * @var $collectionService CollectionService
     */
    protected $collectionService;

    public function getCollectionService()
    {
        if (!$this->collectionService) {
            $this->collectionService = $this->getServiceLocator()->get('CollectionService');
        }
        return $this->collectionService;
    }

    public function indexAction()
    {
        return new ViewModel(array(
            'collectionsNotSent' => $this->getCollectionService()->getCollectionsNotSent(),
            'collectionsNotPaid' => $this->getCollectionService()->getCollectionsNotPaid(),
        ));
    }

}
