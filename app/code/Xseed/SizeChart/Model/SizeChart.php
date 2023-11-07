<?php
namespace Xseed\SizeChart\Model;

class SizeChart extends \Magento\Framework\Model\AbstractModel
{
    protected $_objectManager;

    protected $_coreResource;

    /**---Functions---*/
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Framework\App\ResourceConnection $coreResource,
        \Xseed\SizeChart\Model\ResourceModel\SizeChart $resource,
        \Xseed\SizeChart\Model\ResourceModel\SizeChart\Collection $resourceCollection
    ) {
        $this->_objectManager = $objectManager;
        $this->_coreResource = $coreResource;
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection
        );
    }

    public function _construct()
    {
        $this->_init('Xseed\SizeChart\Model\ResourceModel\SizeChart');
    }
}
