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

use Supplier\Model\Product;
use Supplier\Enum\ProductEnum;
use Supplier\Service\ProductService;
use Supplier\Service\ProductTypeService;
use Supplier\Service\SupplierService;

class ProductController extends AbstractActionController
{
    /**
     * @var $productService ProductService
     */
    protected $productService;

    /**
     * @var $productTypeService ProductTypeService
     */
    protected $productTypeService;

    /**
     * @var $supplierService SupplierService
     */
    protected $supplierService;

    public function getProductService()
    {
        if (!$this->productService) {
            $this->productService = $this->getServiceLocator()->get('ProductService');
        }
        return $this->productService;
    }

    public function getProductTypeService()
    {
        if (!$this->productTypeService) {
            $this->productTypeService = $this->getServiceLocator()->get('ProductTypeService');
        }
        return $this->productTypeService;
    }

    public function getSupplierService()
    {
        if (!$this->supplierService) {
            $this->supplierService = $this->getServiceLocator()->get('SupplierService');
        }
        return $this->supplierService;
    }

    public function indexAction()
    {
        $productType = $this->params()->fromRoute('productType', false);
        $supplierId = $this->params()->fromRoute('supplierId', false);
        $section = $this->params()->fromRoute('section', SectionEnum::PRODUCT_INDEX);

        $productTypeModel = ($productType) ? $this->getProductTypeService()->getById($productType) : false;
        $supplierModel = ($supplierId) ? $this->getSupplierService()->getById($supplierId) : false;

        return new ViewModel(array(
            'products' => $this->getProductService()->getAllByProductType($productType),
            'productType' => $productTypeModel,
            'supplier' => $supplierModel,
            'section' => $section,
        ));
    }

    public function saveAction() {
        $params = $this->params()->fromPost();

        /** @var $productModel Product */
        $productModel = $this->getProductService()->getById($params['id']);
        $productModel->setProductType($params['type']);
        $productModel->setSupplierId($params['supplier']);
        $productModel->setReference($params['reference']);
        $productModel->setPrice($params['price']);
        $productModel->setDevise($params['devise']);

        $result = $this->getProductService()->save($productModel);
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

        /** @var $productModel Product */
        $productModel = $this->getProductService()->getById(ProductEnum::NEW_PRODUCT);

        // List of all product types
        $productTypeList = $this->getProductTypeService()->getAll();

        // List of all suppliers
        $suppliersList = $this->getSupplierService()->getAll();

        return new ViewModel(array(
            'product' => $productModel,
            'productTypeList' => $productTypeList,
            'suppliersList' => $suppliersList,
            'section' => $section,
            'mode' => $mode,
        ));
    }

    public function editAction()
    {
        $productId = $this->getEvent()->getRouteMatch()->getParam('id', ProductEnum::NEW_PRODUCT);
        $section = $this->params()->fromRoute('section', false);
        $mode = $this->params()->fromRoute('mode', false);

        if($mode == ModeEnum::MODE_AJAX){
            $this->layout('layout/empty');
        }

        /** @var $productModel Product */
        $productModel = $this->getProductService()->getById($productId);

        // List of all product types
        $productTypeList = $this->getProductTypeService()->getAll();

        // List of all suppliers
        $suppliersList = $this->getSupplierService()->getAll();

        return new ViewModel(array(
            'product' => $productModel,
            'productTypeList' => $productTypeList,
            'suppliersList' => $suppliersList,
            'section' => $section,
            'mode' => $mode,
        ));
    }

    public function deleteAction()
    {
        $params = $this->params()->fromPost();
        $success = $this->getProductService()->delete((int) $params['id']);
        $result = new JsonModel($success);
        return $result;
    }

}