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
 * Customer register event
 *
 * @category    Hackathon
 * @package     Hackathon_ChatConnector
 * @author      Wouter Cleymans <wouter.cleymans@phpro.be>
 */
class Hackathon_ChatConnector_Model_Events_Customer_Register
    extends Hackathon_ChatConnector_Model_Events_Abstract
{
    /**
     * Listen to customer register success event
     *
     * @param Varien_Event_Observer $observer Observer
     */
    public function listener(Varien_Event_Observer $observer)
    {
        $customer = $observer->getEvent()->getCustomer();
        $helper = $this->getHelper();

        $messageTemplate = $helper->__('%1$s %2$s has created an account in store view: %3$s',
            $customer->getFirstname(),
            $customer->getLastname(),
            $customer->getCreatedIn()
        );

        $this->_addQueueItem($messageTemplate);
    }

}
