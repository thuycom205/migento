<?php

namespace Xseed\LiveSalesPopup\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Xseed\LiveSalesPopup\Model\YourModel; // Replace with your actual model

class Sales extends Template
{
    protected $yourModel;

    public function __construct(Context $context, YourModel $yourModel, array $data = [])
    {
        $this->yourModel = $yourModel;
        parent::__construct($context, $data);
    }

    public function getSalesData()
    {
        // Implement this method to fetch and return sales data from your model
        return $this->yourModel->getSalesData();
    }
}
