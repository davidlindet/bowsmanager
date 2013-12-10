<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ukiitan
 * Date: 08/10/13
 * Time: 00:37
 * To change this template use File | Settings | File Templates.
 */
namespace Supplier\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

use Application\Enum\SectionEnum;
use Application\Enum\ModeEnum;

use Supplier\Model\ProductType;
use Supplier\Enum\ProductTypeEnum;
use Supplier\Service\ProductTypeService;

class ProductTypeController extends AbstractActionController
{
    /**
     * @var $productTypeService ProductTypeService
     */
    protected $productTypeService;

    public function getProductTypeService()
    {
        if (!$this->productTypeService) {
            $this->productTypeService = $this->getServiceLocator()->get('ProductTypeService');
        }
        return $this->productTypeService;
    }

    public function indexAction()
    {
        return new ViewModel(array(
            'productTypes' => $this->getProductTypeService()->getAll(),
            'section' => SectionEnum::PRODUCT_INDEX,
        ));
    }

    public function saveAction() {
        $params = $this->params()->fromPost();

        /** @var $productTypeModel ProductType */
        $productTypeModel = $this->getProductTypeService()->getById($params['id']);
        $productTypeModel->setName($params['name']);

        $result = $this->getProductTypeService()->save($productTypeModel);
        $result['section'] = $params['section'];
        return new JsonModel($result);
    }

    public function addAction()
    {
        $section = $this->params()->fromRoute('section', false);
        $mode = $this->params()->fromRoute('mode', false);

        if($mode == ModeEnum::MODE_AJAX){
            $this->layout('layout/empty');
        }

        /** @var $productTypeModel ProductType */
        $productTypeModel = $this->getProductTypeService()->getById(ProductTypeEnum::NEW_PRODUCT_TYPE);

        return new ViewModel(array(
            'productType' => $productTypeModel,
            'section' => $section,
            'mode' => $mode,
        ));
    }

    public function editAction()
    {
        $productTypeId = $this->getEvent()->getRouteMatch()->getParam('id', ProductTypeEnum::NEW_PRODUCT_TYPE);
        $section = $this->params()->fromRoute('section', false);
        $mode = $this->params()->fromRoute('mode', false);

        if($mode == ModeEnum::MODE_AJAX){
            $this->layout('layout/empty');
        }

        /** @var $productTypeModel ProductType */
        $productTypeModel = $this->getProductTypeService()->getById($productTypeId);

        return new ViewModel(array(
            'productType' => $productTypeModel,
            'section' => $section,
            'mode' => $mode,
        ));
    }

    public function detailsAction()
    {
        $productTypeId = $this->getEvent()->getRouteMatch()->getParam('id', ProductTypeEnum::NEW_PRODUCT_TYPE);
        $section = $this->params()->fromRoute('section', false);

        /** @var $productTypeModel ProductType */
        $productTypeModel = $this->getProductTypeService()->getById($productTypeId);

        return new ViewModel(array(
            'productType' => $productTypeModel,
            'section' => $section,
        ));
    }

    public function deleteAction()
    {
        $params = $this->params()->fromPost();
        $success = $this->getProductTypeService()->delete((int) $params['id']);
        $result = new JsonModel($success);
        return $result;
    }

}