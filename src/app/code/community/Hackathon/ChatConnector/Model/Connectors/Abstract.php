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
 * Abstract connector model
 *
 * @category    Hackathon
 * @package     Hackathon_ChatConnector
 * @author      Sander Mangel <sander@sandermangel.nl>, Marcel Hauri <marcel@hauri.me>
 */
class Hackathon_ChatConnector_Model_Connectors_Queue extends Mage_Core_Model_Abstract
{

    /**
     * _processQueue
     *
     * @access protected
     * @return Void
     */
    protected function _processQueue()
    {
    }


    /**
     * @param array $params
     * @param null $connector
     * @return bool
     */
    public function sendNotification($params = array(), $connector = null)
    {
        // TODO: Check if ChatConnector is enabled

        $url    = null;
        $data   = json_encode($params);
        $ch     = curl_init();

        /**
         * connector specific curl configuration
         */
        switch ($connector) {
            case 'slack':
                $data = array('payload' => json_encode($params));
                break;
            case 'hipchat':
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                break;
            default:
                // TODO: Log error, or throw new exception
                curl_close($ch);
                return false;
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_NOBODY, 0);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        if(!curl_exec($ch)) {
            // TODO: Log error, or throw new exception
            curl_close($ch);
            return false;
        }
        curl_close($ch);
        return true;
    }
}
