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

use Supplier\Model\Supplier;
use Supplier\Enum\SupplierEnum;
use Supplier\Service\SupplierService;

use Supplier\Service\ProductService;
use Supplier\Service\ProductTypeService;

class SupplierController extends AbstractActionController
{
    /**
     * @var $supplierService SupplierService
     */
    protected $supplierService;

    public function getSupplierService()
    {
        if (!$this->supplierService) {
            $this->supplierService = $this->getServiceLocator()->get('SupplierService');
        }
        return $this->supplierService;
    }

    public function indexAction()
    {
        return new ViewModel(array(
            'suppliers' => $this->getSupplierService()->getAll(),
            'section' => SectionEnum::SUPPLIER_INDEX,
        ));
    }

    public function saveAction() {
        $params = $this->params()->fromPost();

        /** @var $supplierModel Supplier */
        $supplierModel = $this->getSupplierService()->getById($params['id']);

        $supplierModel->setName($params['name']);
        $supplierModel->setAddress($params['address']);
        $supplierModel->setPhone($params['phone']);
        $supplierModel->setEmail($params['email']);
        $supplierModel->setWebsite($params['website']);

        $result = $this->getSupplierService()->save($supplierModel);
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

        /** @var $supplierModel Supplier */
        $supplierModel = $this->getSupplierService()->getById(SupplierEnum::NEW_SUPPLIER);

        return new ViewModel(array(
            'supplier' => $supplierModel,
            'section' => $section,
            'mode' => $mode,
        ));
    }

    public function editAction()
    {
        $supplierId = $this->getEvent()->getRouteMatch()->getParam('id', SupplierEnum::NEW_SUPPLIER);
        $section = $this->params()->fromRoute('section', false);
        $mode = $this->params()->fromRoute('mode', false);

        if($mode == ModeEnum::MODE_AJAX){
            $this->layout('layout/empty');
        }

        /** @var $supplierModel Supplier */
        $supplierModel = $this->getSupplierService()->getById($supplierId);

        return new ViewModel(array(
            'supplier' => $supplierModel,
            'section' => $section,
            'mode' => $mode,
        ));
    }

    public function detailsAction()
    {
        $supplierId = $this->getEvent()->getRouteMatch()->getParam('id', SupplierEnum::NEW_SUPPLIER);
        $section = $this->params()->fromRoute('section', false);

        /** @var $supplierModel Supplier */
        $supplierModel = $this->getSupplierService()->getById($supplierId);

        /** @var $productService ProductService */
        $productService = $this->getServiceLocator()->get('ProductService');
        $products = $productService->getAllBySupplier($supplierId);

        /** @var $productTypeService ProductTypeService */
        $productTypeService = $this->getServiceLocator()->get('ProductTypeService');
        $productsTypes = $productTypeService->getAll(array_keys($products));

        return new ViewModel(array(
            'supplier' => $supplierModel,
            'productsGrouped' => $products,
            'productsTypes' => $productsTypes,
            'section' => $section,
        ));
    }

    public function deleteAction()
    {
        $params = $this->params()->fromPost();
        $success = $this->getSupplierService()->delete((int) $params['id']);
        $result = new JsonModel($success);
        return $result;
    }

}