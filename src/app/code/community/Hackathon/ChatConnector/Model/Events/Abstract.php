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
abstract class Hackathon_ChatConnector_Model_Events_Abstract
    implements Hackathon_ChatConnector_Model_Events_Interface
{
    /**
     * @var Hackathon_ChatConnector_Helper_Data
     */
    protected $_helper = null;

    /**
     * Add the item to the queue
     *
     * @param string $message Message
     * @param array  $params  Additional Params
     */
    protected function _addQueueItem($message, $params = array())
    {
        if (!$this->getHelper()->isActive()) {
            return;
        }

        $params = array_merge(array('message' => $message), $params);

        $serializedParams = json_encode((array)$params);
        $connectors = $this->getHelper()->getActiveConnectors();

        foreach ($connectors as $code) {
            $connectorParams = $this->getHelper()->getConfiguredConnectors($code);

            /* @var $connector Hackathon_ChatConnector_Model_Connectors_Interface */
            $connector = Mage::getModel($connectorParams['class']);
            if (!$connector) {
                continue;
            }

            /* @var $queueItem Hackathon_ChatConnector_Model_Queue */
            $queueItem = Mage::getModel('hackathon_chatconnector/queue')->setData(array(
                'message_params' => $serializedParams,
                'connector'      => $connector->getCode()
            ));

            try {
                $queueItem->save();
            } catch (Exception $e) {
                Mage::logException($e);
            }
        }
    }

    /**
     * Retrieve the helper
     *
     * @return Hackathon_ChatConnector_Helper_Data
     */
    public function getHelper()
    {
        if (null === $this->_helper) {
            $this->setHelper(Mage::helper('hackathon_chatconnector'));
        }

        return $this->_helper;
    }

    /**
     * Set the helper
     *
     * @param Hackathon_ChatConnector_Helper_Data $helper Helper
     */
    public function setHelper($helper)
    {
        $this->_helper = $helper;
    }
}
