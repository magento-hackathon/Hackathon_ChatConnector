<?php
/**
 * Hackathon_ChatConnector extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 *
 * @category       Hackathon
 * @package        Hackathon_ChatConnector
 * @copyright      Copyright (c) 2015
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Invoice event cron
 *
 * @category    Hackathon
 * @package     Hackathon_ChatConnector
 * @author      Sander Mangel <sander@sandermangel.nl>
 */
class Hackathon_ChatConnector_Model_Events_Sales_Invoice
    extends Hackathon_ChatConnector_Model_Events_Abstract
{
    /**
     * Listen to invoice creation
     *
     * @param Varien_Event_Observer $observer Observer
     */
    public function listener(Varien_Event_Observer $observer)
    {
        if (!Mage::getStoreConfigFlag('hackathon_chatconnector/notifications/new_invoice'))
            return $this;

        $order = $observer->getEvent()->getOrder();
        $shippingObj = $order->getShippingAddress();
        $street = implode(' ', (array)$shippingObj->getStreet());

        $messageTemplate = "New Invoice
        Shipping to
        {$shippingObj->getFirstname()} {$shippingObj->getLastname()}
        {$street}
        {$shippingObj->getPostcode()} {$shippingObj->getCity()} {$shippingObj->getPostcode()} ({$shippingObj->getCountryId()})

        Items
        ";

        foreach ($order->getAllVisibleItems() as $_item) {
            $qty = (int)$_item->getQtyOrdered();
            $messageTemplate .= "{$qty}x {$_item->getName()} ({$_item->getSku()})\n";
        }

        $this->_addQueueItem($messageTemplate);
    }
}
