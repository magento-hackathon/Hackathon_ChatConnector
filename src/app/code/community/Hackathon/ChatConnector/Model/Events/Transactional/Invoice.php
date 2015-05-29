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
    implements Hackathon_ChatConnector_Model_Events_Interface
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
    }
}
