<?php

namespace Xseed\SizeChart\Block\Adminhtml\Index;

class Index extends \Magento\Backend\Block\Widget\Grid\Listing
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_controller = 'adminhtml_index';
        $this->_headerText = __('Size Chart');
        $this->_addButtonLabel = __('Add New SizeChart');
        parent::_construct();
    }
}
