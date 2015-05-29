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
 * Slack Connector
 *
 * @category    Hackathon
 * @package     Hackathon_ChatConnector
 * @author      Marcel Hauri <marcel@hauri.me>
 */

class Hackathon_ChatConnector_Model_Connectors_Slack
    extends Hackathon_ChatConnector_Model_Connectors_Abstract
{
    protected $_prefix = 'slack';

    /**
     * @return array
     */
    public function getConfig()
    {
        $store = Mage::app()->getStore()->getStoreId();
        return array(
            'webhook_url' => Mage::getStoreConfig('hackathon_chatconnector/slack/webhook_url', $store),
            'channel'     => Mage::getStoreConfig('hackathon_chatconnector/slack/channel', $store),
            'username'    => Mage::getStoreConfig('hackathon_chatconnector/slack/username', $store),
            'icon'        => Mage::getStoreConfig('hackathon_chatconnector/slack/icon', $store),
        );
    }

    /**
     * @param array $params
     * @return bool
     */
    public function notify($params = array())
    {
        $config = $this->getConfig();

        $ch     = curl_init();
        curl_setopt($ch, CURLOPT_URL, $config['webhook_url']);
        curl_setopt($ch, CURLOPT_NOBODY, 0);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('payload' => json_encode($params)));
        curl_exec($ch);

        $status = curl_getinfo($ch,CURLINFO_HTTP_CODE);
        curl_close($ch);

        if(intval($status) === 200) {
            return true;
        }
        return false;
    }
}