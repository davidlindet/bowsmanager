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
        $query = $this->params()->fromPost('query', false);
        $searchTypes = $this->params()->fromPost('type', false);

        $response = array('success' => false,
                            'clientHtml' => false,
                            'query' => $query
                            );

        if(in_array(SearchEnum::SEARCH_CLIENT, $searchTypes)){
            $clients = $this->getSearchService()->searchClient($query);

//            /** @var $client \client\Model\Client */
//            foreach($clients as $client){
//                $response['clients'][] = $client->toArray();
//            }

            $viewModel =  new ViewModel(array(
                                'clients' => $clients,
                                'query' => $query,
                            ));
            $viewModel->setTemplate("clientList");
            $viewRender = $this->getServiceLocator()->get('ViewRenderer');
            $html = $viewRender->render($viewModel);

            $response['clientHtml'] = $html;
        }

        if($response['clientHtml']){
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