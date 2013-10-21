<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 00:37
 * To change this template use File | Settings | File Templates.
 */
namespace Search\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

use Search\Service\SearchService;

class SearchController extends AbstractActionController
{
    /**
     * @var $searchService SearchService
     */
    protected $searchService;

    public function getSearchService()
    {
        if (!$this->searchService) {
            $this->searchService = $this->getServiceLocator()->get('SearchService');
        }
        return $this->searchService;
    }

    public function indexAction()
    {
        $query = $this->params()->fromQuery('query', false);

        return new ViewModel(array(
            'query' => $query,
            'clients' => $this->getSearchService()->searchClient($query),
            //'collections' => $this->getSearchService()->getSearchResult(),
        ));
    }
}