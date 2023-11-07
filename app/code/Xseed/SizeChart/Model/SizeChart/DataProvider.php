<?php

namespace Xseed\SizeChart\Model\SizeChart;

use Xseed\SizeChart\Model\ResourceModel\SizeChart\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Xseed\SizeChart\Helper\Data;

class DataProvider extends \Magento\Ui\DataProvider\ModifierPoolDataProvider
{
    /**
     * @var \Xseed\SizeChart\Model\ResourceModel\SizeChart\Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;
    protected  $helper;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $sizeChartCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $sizeChartCollectionFactory,
        DataPersistorInterface $dataPersistor,
        Data $sizeChartHelper,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    ) {
        $this->collection = $sizeChartCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->helper = $sizeChartHelper;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var \Xseed\SizeChart\Model\SizeChart $sizeChart */
        foreach ($items as $sizeChart) {
            $this->loadedData[$sizeChart->getId()] = $sizeChart->getData();
        }

        $data = $this->dataPersistor->get('xseed_sizechart');
        if (!empty($data)) {
            $sizeChart = $this->collection->getNewEmptyItem();
            $sizeChart->setData($data);
            $this->loadedData[$sizeChart->getId()] = $sizeChart->getData();
            $this->dataPersistor->clear('xseed_sizechart');
        }

        foreach ($this->loadedData as &$item) {

            $imgUrl =  $this->helper->getMediaUrl($item['img']);
            $item['img'] = [[
                'name'=> $item['img'],
                'size'=> '16522',
                'type'=> '"image/png"',
                'url'=> $imgUrl,
            ]

            ];
        }
        return $this->loadedData;
    }
}
