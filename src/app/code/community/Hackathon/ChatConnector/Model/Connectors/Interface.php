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
 * Connector interface
 *
 * @category    Hackathon
 * @package     Hackathon_ChatConnector
 * @author      Sander Mangel <sander@sandermangel.nl>
 */
interface Hackathon_ChatConnector_Model_Connectors_Interface
{
    /**
     * Send the notification for the given connector
     *
     * @param array $params Params
     * @return bool
     */
    public function notify($params = array());

    /**
     * Retrieve the connector config
     *
     * @param null $store Store
     * @return array
     */
    public function getConfig($store = null);

    /**
     * Retrieve the connector code
     *
     * @return string
     */
    public function getCode();
}
