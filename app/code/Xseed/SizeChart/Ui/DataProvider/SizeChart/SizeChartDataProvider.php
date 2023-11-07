<?php

namespace Xseed\SizeChart\Ui\DataProvider\SizeChart;

class SizeChartDataProvider extends
    \Magento\Ui\DataProvider\AbstractDataProvider {
    protected $collection;
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        \Xseed\SizeChart\Model\ResourceModel\SizeChart\CollectionFactory
        $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $meta,
            $data
        );
        $this->collection = $collectionFactory->create();
    }
    public function getData() {
        if (!$this->getCollection()->isLoaded()) {
            $this->getCollection()->load();
        }
        $items = $this->getCollection()->toArray();
        $raws =  array_values($items);
        $r = $raws[1];
        foreach ($r as &$item) {
            $item['category_id'] = explode(',', $item['category_id']);
            $item['img'] = [$item['img']];
        }
        return [
            'totalRecords' => $this->getCollection()->getSize(),
            'items' =>$r,
        ];
    }
}
