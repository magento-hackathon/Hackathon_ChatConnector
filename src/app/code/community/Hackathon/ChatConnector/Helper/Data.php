<?php

/**
 * Class Hackathon_ChatConnector_Helper_Data
 */
class Hackathon_ChatConnector_Helper_Data extends Mage_Core_Helper_Abstract
{
    const XML_PATH_GENERAL_ENABLED = 'hackathon_chatconnector/general/enabled';
    const XML_PATH_GENERAL_CONNECTORS = 'hackathon_chatconnector/general/connectors';
    const XML_PATH_GENERAL_FREQUENCY = 'hackathon_chatconnector/general/retry_frequency';

    /**
     * Check if chat connector is active
     *
     * @param null $store
     * @return bool
     */
    public function isActive($store = null)
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_GENERAL_ENABLED, $store);
    }

    /**
     * Retrieve all active chat connectors
     *
     * @param null $store
     * @return array|mixed
     */
    public function activeConnectors($store = null)
    {
        $connectors = Mage::getStoreConfig(self::XML_PATH_GENERAL_CONNECTORS, $store);
        $connectors = explode(',', $connectors);

        return $connectors;
    }

    /**
     * Get retry frequency
     *
     * @param null $store
     * @return int
     */
    public function getRetryFrequency($store = null)
    {
        return (int)Mage::getStoreConfig(self::XML_PATH_GENERAL_FREQUENCY, $store);
    }

    /**
     * getConfiguredConnectors
     *
     * @param null $key
     * @param null $store
     * @return array
     */
    public function getConfiguredConnectors($key = null, $store = null)
    {
        if (!is_null($key)) {
            $key = '/' . trim($key, '/');
        }

        $connectors = Mage::getConfig()->getNode('chatconnector/connectors' . $key);

        return $connectors->asArray();
    }
}
