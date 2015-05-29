<?php

class Hackathon_ChatConnector_Model_Cron
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

        // Iterate over items and try sending them
        $successIds = array();
        $failIds = array();
        foreach ($collection as $queueItem) {
            /* @var $queueItem Hackathon_ChatConnector_Model_Queue */

            // TODO: Get params from queue item
            $params = array();

            $result = $connector->notify($params);
            if (true === $result) {
                $successIds[] = $queueItem->getId();
            } else {
                $failIds[] = $queueItem->getId();
            }
        }

        // Update items with status. Either processed or failed
        $resource = Mage::getSingleton('core/resource');
        $write = $resource->getConnection('core_write');

        if (count($successIds)) {
            $write->query("
                UPDATE {$resource->getTableName('hackathon_chatconnector/queue')}
                SET `status` = '" . Hackathon_ChatConnector_Model_Queue::STATUS_PROCESSED . "'
                , `updated_at` = '" . Mage::getModel('core/date')->date('Y-m-d H:i:s') . "'
                WHERE `entity_id` IN (" . implode(',', $successIds) . ")
            ");
        }

        if (count($failIds)) {
            $write->query("
                UPDATE {$resource->getTableName('hackathon_chatconnector/queue')}
                SET `status` = '" . Hackathon_ChatConnector_Model_Queue::STATUS_FAILED . "'
                , `updated_at` = '" . Mage::getModel('core/date')->date('Y-m-d H:i:s') . "'
                WHERE `entity_id` IN (" . implode(',', $failIds) . ")
            ");
        }
    }
}
