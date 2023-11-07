<?php

namespace Xseed\SizeChart\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action  {
    /**
     * Index action
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute() {
        phpinfo();
       echo "hello world";
    }
}

