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
 * Newsletter subscriber event.
 *
 * @category    Hackathon
 *
 * @author      Wouter Cleymans <wouter.cleymans@phpro.be>
 */
class Hackathon_ChatConnector_Model_Events_Newsletter_Subscriber
    extends Hackathon_ChatConnector_Model_Events_Abstract
{
    /**
     * Listen to a newsletter subscription.
     *
     * @param Varien_Event_Observer $observer Observer
     */
    public function listener(Varien_Event_Observer $observer)
    {
        // TODO: Implement listener() method.
    }
}
