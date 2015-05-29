<?php

/**
 * Class Hackathon_ChatConnector_Model_Cron_Abstract
 */
abstract class Hackathon_ChatConnector_Model_Cron_Abstract
{
    /**
     * @var Hackathon_ChatConnector_Helper_Data
     */
    protected $_helper = null;

    /**
     * Run the cron
     */
    abstract public function run();

    /**
     * Retrieve the connector by code
     *
     * @param string $code
     * @return bool|Hackathon_ChatConnector_Model_Connectors_Interface
     */
    public function getConnectorByCode($code)
    {
        $connectorConfig = $this->getHelper()->getConfiguredConnectors($code);
        if (!$connectorConfig) {
            return false;
        }

        /* @var $connector Hackathon_ChatConnector_Model_Connectors_Interface */
        $connector = Mage::getModel($connectorConfig['class']);
        if (!$connector) {
            return false;
        }

        return $connector;
    }

    /**
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
     * @param Hackathon_ChatConnector_Helper_Data $helper
     */
    public function setHelper($helper)
    {
        $this->_helper = $helper;
    }
}
