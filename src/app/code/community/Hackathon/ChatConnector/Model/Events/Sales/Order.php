<?php

/**
 * Hackathon_ChatConnector extension.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 *
 * @category       Hackathon
 *
 * @copyright      Copyright (c) 2015
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Sales order event.
 *
 * @category    Hackathon
 *
 * @author      Wouter Cleymans <wouter.cleymans@phpro.be>
 */
class Hackathon_ChatConnector_Model_Events_Sales_Order
    extends Hackathon_ChatConnector_Model_Events_Abstract
{

    /**
     * Listen to order cancel payment event
     *
     * @param Varien_Event_Observer $event
     *
     * @return mixed|void
     */
    public function listener(Varien_Event_Observer $event)
    {
        $itemTemplate = '';
        $orderIds     = $event->getOrderIds();
        $helper       = $this->getHelper();

        $items = Mage::getModel('sales/order_item')
            ->getCollection()
            ->addFieldToFilter('order_id', array('in' => $orderIds))
            ->getItems();

        foreach ($items as $item) {
            $itemTemplate .= "{$item->getName()} ({$item->getSku()}) : {$item->getPrice()}";
        }

        $this->_addQueueItem($helper->__('A new order was placed: %1$s', $itemTemplate));
    }

}
