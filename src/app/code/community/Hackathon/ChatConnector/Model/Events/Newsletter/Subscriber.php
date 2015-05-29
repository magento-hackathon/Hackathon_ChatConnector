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
     * Newsletter subscriber event
     *
     * @category    Hackathon
     * @package     Hackathon_ChatConnector
     * @author      Wouter Cleymans <wouter.cleymans@phpro.be>
     */
    class Hackathon_ChatConnector_Model_Events_Newsletter_Subscriber
        extends Hackathon_ChatConnector_Model_Events_Abstract
        implements Hackathon_ChatConnector_Model_Events_Interface
    {

        /**
         * @TODO Probably not the best event to observe.. could it be customer save before/after?
         *
         * @param Varien_Event_Observer $event
         */
//        public function controllerActionPostdispatchNewsletterSubscriberConfirm(Varien_Event_Observer $event)
//        {
//            $session = Mage::getSingleton('core/session');
//
//            /** @var Mage_Core_Model_Message_Collection $messages */
//            $messages = $session->getMessages();
//
//            $lastAddedMessage = $messages->getLastAddedMessage();
//
//            // if lastAddedMessage === '';
//        }

        public function listener()
        {
            // TODO: Implement listener() method.
        }

    }
