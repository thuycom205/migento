<?php
namespace Xseed\SizeChart\Helper;

use Magento\Framework\App\Helper\Context;
use Xseed\SizeChart\Model\ResourceModel\SizeChart\CollectionFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\ObjectManagerInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper {
    protected $collection;
    protected $scopeConfig;
    protected $productRepository;
    protected $objectManager;

    public function __construct(
        Context $context,
        CollectionFactory $sizeChartCollectionFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        ProductRepositoryInterface $productRepository,
        ObjectManagerInterface $objectManager
    ) {
        parent::__construct($context);
        $this->collection = $sizeChartCollectionFactory->create();
        $this->scopeConfig = $scopeConfig;
        $this->productRepository = $productRepository;
        $this->objectManager = $objectManager;
    }
    public function getMediaUrl($fileName)
    {
        $mediaDir = $this->objectManager->get('Magento\Store\Model\StoreManagerInterface')
                                        ->getStore()
                                        ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        return $mediaDir.'xseed/feature/'.$fileName;
    }
    public function getSizeChartModelForProduct($productId) {
        try {
            $product = $this->productRepository->getById($productId);
            $categoryIds = $product->getCategoryIds();
            $sizeChartCollection = $this->collection->setOrder('priority', 'ASC');

            $matchingCharts = [];
            foreach ($sizeChartCollection as $chart) {
                $chartCategoryIds = explode(',', $chart->getCategoryId());
                if (array_intersect($categoryIds, $chartCategoryIds)) {
                    $matchingCharts[] = $chart;
                }
            }

            // Return the first item (highest priority) from matching charts or null if no charts are found
            return !empty($matchingCharts) ? $matchingCharts[0] : null;
        } catch (\Exception $e) {
            $this->_logger->error('Error getting size chart for product: ' . $e->getMessage());
        }

        return null;
    }

}
