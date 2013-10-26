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

use Search\Enum\SearchEnum;

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

    public function searchAction() {
        $viewRender = $this->getServiceLocator()->get('ViewRenderer');

        $query = $this->params()->fromPost('query', false);
        $searchTypes = $this->params()->fromPost('type', false);

        $response = array('success' => false,
                            'clientHTML' => false,
                            'collectionHTML' => false,
                            'bowHTML' => false,
                            'query' => $query
                            );

        //client
        if(in_array(SearchEnum::SEARCH_CLIENT, $searchTypes)){
            $clients = $this->getSearchService()->searchClient($query);
            $viewModel =  new ViewModel(array('clients' => $clients, 'query' => $query));
            $viewModel->setTemplate("searchClientList");
            $response['clientHTML'] = $viewRender->render($viewModel);
        }

        //bow
        if(in_array(SearchEnum::SEARCH_COLLECTION, $searchTypes)){
            $collections = $this->getSearchService()->searchCollection($query);
            $viewModel =  new ViewModel(array('collections' => $collections, 'query' => $query));
            $viewModel->setTemplate("searchCollectionList");
            $response['collectionHTML'] = $viewRender->render($viewModel);
        }


        //bow
        if(in_array(SearchEnum::SEARCH_BOW, $searchTypes)){
            $bows = $this->getSearchService()->searchBow($query);
            $viewModel =  new ViewModel(array('bows' => $bows, 'query' => $query));
            $viewModel->setTemplate("searchBowList");
            $response['bowHTML'] = $viewRender->render($viewModel);
        }

        if($response['clientHTML'] || $response['bowHTML']){
            $response['success'] = true;
        }
        else {
            $response['error'] = 'No results';
        }

        return new JsonModel($response);
    }

    public function indexAction()
    {}
}