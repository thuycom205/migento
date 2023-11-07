<?php

namespace Xseed\SizeChart\Controller\Adminhtml;

abstract class SizeChart extends \Magento\Backend\App\Action
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry = null;

    /**
     * @var \Magento\Framework\App\Response\Http\FileFactory
     */
    protected $fileFactory;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\Filter\Date
     */
    protected $dateFilter;

    /**
     * @var \Xseed\SizeChart\Model\SizeChartFactory
     */
    protected $sizechartFactory;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\App\Response\Http\FileFactory $fileFactory
     * @param \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter
     * @param \Xseed\SizeChart\Model\SizeChartFactory $sizechartFactory
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter,
        \Xseed\SizeChart\Model\SizeChartFactory $sizechartFactory,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->fileFactory = $fileFactory;
        $this->dateFilter = $dateFilter;
        $this->sizechartFactory = $sizechartFactory;
        $this->logger = $logger;
    }

    /**
     * Initialize the size chart and register it in the registry if not already registered.
     *
     * @return \Xseed\SizeChart\Model\SizeChart
     */
    protected function _initRule()
    {
        if (!$this->coreRegistry->registry('xseed_sizechart')) {
            $id = (int) $this->getRequest()->getParam('id');

            if (!$id && $this->getRequest()->getParam('chart_id')) {
                $id = (int) $this->getRequest()->getParam('chart_id');
            }

            $rule = $this->sizechartFactory->create();

            if ($id) {
                $rule->load($id);
            }

            $this->coreRegistry->register('xseed_sizechart', $rule);
        }

        return $this->coreRegistry->registry('xseed_sizechart');
    }

    /**
     * Initialize the action and check user permission before loading layout and adding a breadcrumb.
     *
     * @return \Xseed\SizeChart\Controller\Adminhtml\SizeChart
     */
    protected function _initAction()
    {
        if ($this->_authorization->isAllowed('Xseed_SizeChart::sizechart')) {
            $this->_view->loadLayout();
            $this->_setActiveMenu('Xseed_SizeChart::sizechart')
                 ->_addBreadcrumb(__('Size Chart'), __('Size Chart'));
        } else {
            $this->_forward('noroute');
        }

        return $this;
    }
}
