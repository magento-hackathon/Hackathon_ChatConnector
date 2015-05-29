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
class Hackathon_ChatConnector_Model_Events_Transactional_Invoice
    extends Hackathon_ChatConnector_Model_Events_Abstract
{
    /**
     * listener
     *
     * @access public
     * @param Varien_Event_Observer $observer
     * @return Void
     */
    public function listener($observer)
    {
        $order = $observer->getEvent()->getOrder();
        $shippingObj = $order->getShippingAddress();

        $messageTemplate = "New Invoice
        Shipping to
        {$shippingObj->getFirstname()} {{$shippingObj->getLastname()}}
        {$shippingObj->getStreet()}}
        {$shippingObj->getPostcode()}} {$shippingObj->getCity()}} ({$shippingObj->getPostcode()}} {$shippingObj->getCountryId()}})

        Items
        ";

        foreach ($order->getAllVisibleItems() as $_item) {
            $qty = (int)$_item->getQtyOrdered();
            $messageTemplate .= "{$qty}x {$_item->getName()} ({$_item->getSku()})\n";
        }

        $this->_addQueueItem($messageTemplate);
    }
}
