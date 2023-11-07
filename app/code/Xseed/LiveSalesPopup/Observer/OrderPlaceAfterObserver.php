<?php


namespace Xseed\LiveSalesPopup\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class OrderPlaceAfterObserver implements ObserverInterface
{
    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();

        // Your custom logic here
        // For example, you can save data to the database or perform any other action
        // based on the $order object or other data associated with the order.

        // Example: Logging the order increment ID
        $orderIncrementId = $order->getIncrementId();
        $logger = \Magento\Framework\App\ObjectManager::getInstance()->get(\Psr\Log\LoggerInterface::class);
        $logger->info("Order placed with Increment ID: " . $orderIncrementId);
    }
}
