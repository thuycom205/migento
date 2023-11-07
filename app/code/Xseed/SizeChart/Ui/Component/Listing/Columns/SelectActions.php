<?php

namespace Xseed\SizeChart\Ui\Component\Listing\Columns;
use Magento\Ui\Component\Listing\Columns\Column;

class SelectActions extends Column {
    /**
     * {@inheritdoc}
     * @since 100.1.0
     */
    public function prepareDataSource(array $dataSource)
    {
        $dataSource = parent::prepareDataSource($dataSource);

        if (empty($dataSource['data']['items'])) {
            return $dataSource;
        }

        foreach ($dataSource['data']['items'] as &$item) {
            $item[$this->getData('name')]['edit'] = [
                'href' => $this->context->getUrl(
                    'xsizechart/sizechart/edit',
                    ['id' => $item['chart_id']]
                ),
                'label' => __('Edit'),
                'hidden' => false,
            ];
        }

        return $dataSource;
    }

}
