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
    class Hackathon_ChatConnector_Model_Events_Customer_Register extends Hackathon_ChatConnector_Model_Events_Abstract
        implements Hackathon_ChatConnector_Model_Events_Interface
    {

        /**
         * @param $customer
         */
        public function customerRegisterSuccess($customer)
        {
            $this->_addQueueItem('A new customer has..');
        }

        /**
         * Listen to customer register success event
         *
         * @param Varien_Event_Observer $event
         * @return mixed|void
         */
        public function listener(Varien_Event_Observer $event)
        {
            $customer          = $event->getCustomer();
            //$accountController = $event->getAccountController();

            $this->customerRegisterSuccess($customer);
        }

    }
