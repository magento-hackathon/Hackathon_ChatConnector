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

    /**
     * Retrieve the slack config
     *
     * @param null $store
     * @return array
     */
    public function getSlackConfig($store = null)
    {
        return array(
            'webhook_url' => Mage::getStoreConfig('hackathon_chatconnector/slack/webhook_url', $store),
            'channel'     => Mage::getStoreConfig('hackathon_chatconnector/slack/channel', $store),
            'username'    => Mage::getStoreConfig('hackathon_chatconnector/slack/username', $store),
            'icon'        => Mage::getStoreConfig('hackathon_chatconnector/slack/icon', $store),
        );
    }

    /**
     * Retrieve the hipchat config
     *
     * @param null $store
     * @return array
     */
    public function getHipChatConfig($store = null)
    {
        return array(
            'access_token' => Mage::getStoreConfig('hackathon_chatconnector/hipchat/access_token', $store),
            'room_id'      => Mage::getStoreConfig('hackathon_chatconnector/hipchat/room_id', $store),
        );
    }

    /**
     * Get retry frequency
     *
     * @param null $store
     * @return int
     */
    public function getRetryFrequency($store = null)
    {
        return (int)Mage::getStoreConfig('hackathon_chatconnector/general/retry_frequency', $store);
    }
}
