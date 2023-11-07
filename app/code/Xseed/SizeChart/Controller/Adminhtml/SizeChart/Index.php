<?php

namespace Xseed\SizeChart\Controller\Adminhtml\SizeChart;

class Index extends \Xseed\SizeChart\Controller\Adminhtml\SizeChart
{
    /**
     * Index action
     *
     * @return \Magento\Framework\Controller\Result\Page
     */
    public function execute()
    {
        $this->_initAction();

        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Size Chart'));
        $this->_view->renderLayout('root');

    }
}
