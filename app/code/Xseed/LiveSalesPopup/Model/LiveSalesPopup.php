<?php

namespace Xseed\LiveSalesPopup\Model;

class LiveSalesPopup extends \Magento\Framework\Model\AbstractModel
{
    /**
     * @var string
     */
    protected $_entityType = 'my_company_live_sales_popup';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('MyCompany\LiveSalesPopup\Model\ResourceModel\LiveSalesPopup');
    }

    /**
     * Get live sales popup data
     *
     * @return array
     */
    public function getLiveData()
    {
        $liveData = [];

        // Get the most recent order
        $recentOrder = $this->getResource()->getRecentOrder();

        if ($recentOrder) {
            $liveData['order'] = [
                'increment_id' => $recentOrder['increment_id'],
                'customer_name' => $recentOrder['customer_name'],
                'product_name' => $recentOrder['product_name'],
                'created_at' => $recentOrder['created_at'],
            ];
        }

        return $liveData;
    }

    /**
     * Is live sales popup enabled?
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->getStatus() == 1;
    }
}
