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
 * Abstract event model
 *
 * @category    Hackathon
 * @package     Hackathon_ChatConnector
 * @author      Sander Mangel <sander@sandermangel.nl>
 */
class Hackathon_ChatConnector_Model_Events_Abstract extends Mage_Core_Model_Abstract
{
    /**
     * processQueue
     *
     * @access protected
     * @parm array $params
     * @return Void
     */
    protected function _addQueueItem($params)
    {
        $serializedParams = json_encode((array)$params);
        $connectors = Mage::helper('hackathon_chatconnector')->getActiveConnectors();

        foreach ($connectors as $code) {
            $connectorParams = Mage::helper('hackathon_chatconnector')->getConfiguredConnectors($code);
            $connector = Mage::getModel($connectorParams['class']);
            if (!$connector) {
                continue;
            }

            $queueItem = Mage::getModel('hackathon_chatconnector/queue')->setData(array(
                'message_params' => $serializedParams,
                'connector' => $connector->getPrefix()
            ));

            try {
                $queueItem->save();
            } catch(Exception $e) {
                Mage::logException($e);
            }
        }
    }
}
