<?php
namespace Xseed\SizeChart\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\Registry;
use Xseed\SizeChart\Model\SizeChart;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\View\Element\Template\Context;
use Xseed\SizeChart\Helper\Data;

class SizeChartTab extends Template
{
    protected $_coreRegistry;
    protected $objectManager;

    public function __construct(
        Context $context,
        Registry $registry,
        SizeChart $sizeChartModel,
        ObjectManagerInterface $objectManager,
        Data $sizeChartHelper,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        $this->_sizeChartModel = $sizeChartModel;
        $this->objectManager = $objectManager;
        $this->sizeChartHelper = $sizeChartHelper;
        parent::__construct($context, $data);
    }
    public function getRegistry() {
        return $this->_coreRegistry;
    }

    public function checkProductCategory($productId, $categoryId) {
        $product = $this->getRegistry()->registry('current_product');

        $categories = $product->getCategoryIds();

        if(in_array($categoryId, $categories)){
            return true; // Product belongs to this category
        }

        return false; // Product doesn't belong to this category
    }

    public function getRelatedSizeChart()
    {
//        if (!$this->sizeChartHelper->isEnabledInFrontend()) {
//            return null;
//        }

        $product = $this->_coreRegistry->registry('current_product');
        $sizeChart = $this->sizeChartHelper->getSizeChartModelForProduct($product->getId());

        if (is_object($sizeChart)) {
            return $sizeChart;
        }

        return null;
    }

    public function getMediaUrl($fileName)
    {
        $mediaDir = $this->objectManager->get('Magento\Store\Model\StoreManagerInterface')
                                        ->getStore()
                                        ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        return $mediaDir.'xseed/feature/'.$fileName;
    }
}
