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
 * Queue collection resource model.
 *
 * @category    Hackathon
 *
 * @author      Sander Mangel <sander@sandermangel.nl>
 */
class Hackathon_ChatConnector_Model_Resource_Queue_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Init collection model.
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('hackathon_chatconnector/queue');
    }

    /**
     * Filter the collection by the connector code.
     *
     * @param string $connector Connector
     *
     * @return Hackathon_ChatConnector_Model_Resource_Queue_Collection
     */
    public function addConnectorFilter($connector)
    {
        $this->getSelect()->where('connector = ?', $connector);

        return $this;
    }
}
