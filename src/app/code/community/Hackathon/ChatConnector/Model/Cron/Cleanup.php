<?php

/**
 * Class Hackathon_ChatConnector_Model_Cron_Cleanup
 */
class Hackathon_ChatConnector_Model_Cron_Cleanup
    extends Hackathon_ChatConnector_Model_Cron_Abstract
{
    /**
     * Run the cron
     */
    public function run()
    {
        if (!$this->getHelper()->isActive()) {
            return;
        }

        /* @var $queueResource Hackathon_ChatConnector_Model_Resource_Queue */
        $queueResource = Mage::getResourceModel('hackathon_chatconnector/queue');
        $queueResource->cleanupProcessedEntries();
    }
}
