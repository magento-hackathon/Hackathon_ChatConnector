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
 * HipChat Connector
 *
 * @category    Hackathon
 * @package     Hackathon_ChatConnector
 * @author      Marcel Hauri <marcel@hauri.me>
 */

class Hackathon_ChatConnector_Model_Connectors_HipChat
    extends Hackathon_ChatConnector_Model_Connectors_Abstract
{
    protected $_prefix = 'hipchat';

    /**
     * @return array
     */
    public function getConfig()
    {
        $store = Mage::app()->getStore()->getStoreId();
        return array(
            'access_token' => Mage::getStoreConfig('hackathon_chatconnector/hipchat/access_token', $store),
            'room_id'      => Mage::getStoreConfig('hackathon_chatconnector/hipchat/room_id', $store),
        );
    }

    public function notify($params = array())
    {
        $config = $this->getConfig();

        $url = sprintf('http://api.hipchat.com/v2/room/%d/notification?auth_token=%s',
            intval($config['room_id']),
            $config['access_token']
        );

        $ch     = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_NOBODY, 0);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_exec($ch);

        $status = curl_getinfo($ch,CURLINFO_HTTP_CODE);
        curl_close($ch);

        if(intval($status) === 200 || intval($status) === 204) {
            return true;
        }
        return false;
    }
}