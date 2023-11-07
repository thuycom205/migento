<?php
//
//namespace Xseed\SizeChart\Controller\Adminhtml\SizeChart;
//
//use Magento\Backend\App\Action;
//use Magento\Backend\App\Action\Context;
//use Magento\Framework\Registry;
//
//class Edit extends Action
//{
//    private $coreRegistry;
//
//    public function __construct(Context $context, Registry $coreRegistry)
//    {
//        parent::__construct($context);
//        $this->coreRegistry = $coreRegistry;
//    }
//
//    public function execute()
//    {
//        $id = $this->getRequest()->getParam('id');
//        $model = $this->_initSizeChartModel($id);
//
//        if (!$model) {
//            $this->messageManager->addErrorMessage(__('This Size Chart no longer exists.'));
//            $this->_redirect('sizechart/*/*');
//            return;
//        }
//
//        // Set entered data if there were errors during save
//        $data = $this->_getSession()->getPageData(true);
//        if (!empty($data)) {
//            $model->addData($data);
//        }
//
//        $this->coreRegistry->register('xseed_sizechart', $model);
//        //$this->_initAction();
//
//        // The following line has been updated to set the form object for conditions
////        $model->getConditions()->setJsFormObject('rule_conditions_fieldset');
//
//        $this->_view->getLayout()
//                    ->getBlock('index_edit')
//                    ->setData('action', $this->getUrl('sizechart/*/save'));
//
//        $this->_addBreadcrumb($id ? __('Edit Size Chart') : __('New Size Chart'), $id ? __('Edit Size Chart') : __('New Size Chart'));
//
//        $this->_view->getPage()->getConfig()->getTitle()->prepend(
//            $model->getChartId() ? $model->getTitle() : __('New Size Chart')
//        );
//
//        $this->_view->renderLayout();
//    }
//
//    private function _initSizeChartModel($id)
//    {
//        if ($id) {
//            $model = $this->_objectManager->create(\Xseed\SizeChart\Model\SizeChart::class);
//            $model->load($id);
//            return $model->getChartId() ? $model : null;
//        }
//
//        return $this->_objectManager->create(\Xseed\SizeChart\Model\SizeChart::class);
//    }
//}
namespace Xseed\SizeChart\Controller\Adminhtml\SizeChart;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Registry;

class Edit extends Action implements HttpGetActionInterface
{
    const ADMIN_RESOURCE = 'Xseed_SizeChart::save';

    protected $coreRegistry;

    protected $resultPageFactory;

    public function __construct(
        Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        Registry $coreRegistry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    protected function _initAction()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Xseed_SizeChart::sizechart')
                   ->addBreadcrumb(__('Size Charts'), __('Size Charts'))
                   ->addBreadcrumb(__('Manage Size Charts'), __('Manage Size Charts'));
        return $resultPage;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->_objectManager->create(\Xseed\SizeChart\Model\SizeChart::class);

        if ($id) {
            $model->load($id);
            if (!$model->getChartId()) {
                $this->messageManager->addErrorMessage(__('This Size Chart no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->coreRegistry->register('xseed_sizechart', $model);

        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Size Chart') : __('New Size Chart'),
            $id ? __('Edit Size Chart') : __('New Size Chart')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Size Charts'));
        $resultPage->getConfig()->getTitle()
                   ->prepend($model->getChartId() ? $model->getTitle() : __('New Size Chart'));

        return $resultPage;
    }
}
