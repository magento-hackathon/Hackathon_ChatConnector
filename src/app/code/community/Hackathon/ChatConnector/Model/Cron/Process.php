<?php

/**
 * Class Hackathon_ChatConnector_Model_Cron
 */
class Hackathon_ChatConnector_Model_Cron_Process
    extends Hackathon_ChatConnector_Model_Cron_Abstract
{
    /**
     * Run the cron
     */
    public function run()
    {
        $connectors = $this->getHelper()->getActiveConnectors();
        foreach ($connectors as $connectorCode) {
            /* @var $connector Hackathon_ChatConnector_Model_Connectors_Interface */
            $connector = $this->getConnectorByCode($connectorCode);
            if (!$connector) {
                continue;
            }

            $this->_processQueue($connector);
        }
    }

    /**
     * Process the queue for the given connector
     *
     * @param Hackathon_ChatConnector_Model_Connectors_Interface $connector
     */
    protected function _processQueue(Hackathon_ChatConnector_Model_Connectors_Interface $connector)
    {
        $retryFreq = $this->getHelper()->getRetryFrequency();

        /* @var $collection Hackathon_ChatConnector_Model_Resource_Queue_Collection */
        $collection = Mage::getResourceModel('hackathon_chatconnector/queue_collection');
        $collection->addConnectorFilter($connector->getCode());
        $collection->getSelect()->where("
            `status` = " . Hackathon_ChatConnector_Model_Queue::STATUS_PENDING . "
            OR (
                `status` = " . Hackathon_ChatConnector_Model_Queue::STATUS_FAILED . "
                AND `updated_at` <= '" . Mage::getModel('core/date')->date(null, time() - $retryFreq) . "'
        )");

        // Check if there are messsages to process
        if (!$collection->count()) {
            return;
        }

        // Iterate over items and try sending them
        $successIds = array();
        $failIds = array();
        foreach ($collection as $queueItem) {
            /* @var $queueItem Hackathon_ChatConnector_Model_Queue */

            $params = json_decode($queueItem->getData('message_params'), true);

            $result = $connector->notify($params);
            if (true === $result) {
                $successIds[] = $queueItem->getId();
            } else {
                $failIds[] = $queueItem->getId();
            }
        }

        /* @var $queueResource Hackathon_ChatConnector_Model_Resource_Queue */
        $queueResource = Mage::getResourceModel('hackathon_chatconnector/queue');

        // Update the successful items
        if (count($successIds)) {
            $queueResource->updateStatus($successIds, Hackathon_ChatConnector_Model_Queue::STATUS_PROCESSED);
        }

        // Update the failed items
        if (count($failIds)) {
            $queueResource->updateStatus($failIds, Hackathon_ChatConnector_Model_Queue::STATUS_FAILED);
        }
    }
}
