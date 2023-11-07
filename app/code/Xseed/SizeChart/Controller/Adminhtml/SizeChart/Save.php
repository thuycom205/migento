<?php

namespace Xseed\SizeChart\Controller\Adminhtml\SizeChart;

use Magento\Backend\App\Action;
use Xseed\SizeChart\Model\SizeChart;
use Magento\Framework\App\Request\DataPersistorInterface;
use Xseed\SizeChart\Model\ImageUploader;
class Save extends Action
{
    protected $dataPersistor;
    protected $sizeChartModel;
    protected $imageUploader;

    public function __construct(
        Action\Context $context,
        DataPersistorInterface $dataPersistor,
        SizeChart $sizeChartModel,
        ImageUploader $imageUploader
    ) {
        parent::__construct($context);
        $this->dataPersistor = $dataPersistor;
        $this->sizeChartModel = $sizeChartModel;
        $this->imageUploader = $imageUploader;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = isset($data['id']) ? $data['id'] : null;
            $model = $this->sizeChartModel;

            if ($id) {
                $model->load($id);
            }
            try {
                if (isset($data['img'][0]['name']) && isset($data['img'][0]['tmp_name'])) {
                    $data['img'] = $data['img'][0]['name'];
                    $this->imageUploader->moveFileFromTmp($data['img']);
                } elseif (isset($data['img'][0]['name']) && !isset($data['img'][0]['tmp_name'])) {
                    $data['img'] = $data['img'][0]['name'];
                } else {
                    $data['img'] = '';
                }
            } catch (\Exception $e) {
                $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
            }

            //
            try {
                if (!empty($data["category_id"]) && is_array($data["category_id"]) ) {
                    $arr = $data["category_id"];
                    $str = implode(",", $arr);
                    $data["category_id"] = $str;
                }
            } catch (\Exception $e) {
                $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
            }

            //
            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('Size Chart has been saved.'));
                $this->dataPersistor->clear('xseed_sizechart');

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['id' => $model->getId()]);
                    return;
                }

                $this->_redirect('*/*/');
                return;
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('An error occurred while saving the Size Chart: ' . $e->getMessage()));
                $this->dataPersistor->set('xseed_sizechart', $data);

                if ($id) {
                    $this->_redirect('*/*/edit', ['id' => $id]);
                } else {
                    $this->_redirect('*/*/new');
                }
                return;
            }
        }

        $this->messageManager->addErrorMessage(__('No data to save. Please provide some data.'));
        $this->_redirect('*/*/');
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Xseed_SizeChart::sizechart');
    }
}
