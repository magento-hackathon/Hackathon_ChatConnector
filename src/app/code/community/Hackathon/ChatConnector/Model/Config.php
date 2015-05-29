<?php

/**
 * Class Hackathon_ChatConnector_Model_Config
 */
class Hackathon_ChatConnector_Model_Config
{
    const XML_PATH_GENERAL_ENABLED = 'hackathon_chatconnector/general/enabled';
    const XML_PATH_GENERAL_CONNECTORS = 'hackathon_chatconnector/general/connectors';

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
    public function getConnectors($store = null)
    {
        $connectors = Mage::getStoreConfig(self::XML_PATH_GENERAL_CONNECTORS, $store);
        $connectors = explode(',', $connectors);

        return $connectors;
    }
}
