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
 * @author      Sander Mangel <sander@sandermangel.nl>
 */
class Hackathon_ChatConnector_Model_Connectors_Abstract extends Mage_Core_Model_Abstract
{
    protected $_prefix = '';

    /**
     * processQueue
     *
     * @access protected
     * @return Void
     */
    public function processQueue()
    {
        // Get queued items
        $collection = Mage::getResourceModel('hackathon_chatconnector/queue_collection')
            ->addFieldToSelect(array('entity_id', 'message_params'))
            ->addFieldToFilter('connector', $this->_prefix);

        $retryFreq = Mage::getModel('hackathon_chatconnector/config')->getRetryFrequency();

        $collection->getSelect()->where("
            `status` = " . Hackathon_ChatConnector_Model_Queue::STATUS_PENDING . "
            OR (
                `status` = " . Hackathon_ChatConnector_Model_Queue::STATUS_FAILED . "
                AND `updated_at` <= '" . Mage::getModel('core/date')->date('Y-m-d H:i:s', time() - $retryFreq) . "'
        )");

        // Iterate over items and try sending them
        $succesIds = array();
        $failIds = array();
        foreach ($collection as $_item) {
            if ($this->notify()) {
                $succesIds[] = $_item->getId();
            } else {
                $failIds[] = $_item->getId();
            }
        }

        // Update items with status. Either processed or failed
        $resource = Mage::getSingleton('core/resource');
        $write = $resource->getConnection('core_write');

        if (count($succesIds)) {
            $write->query("
                UPDATE {$resource->getTableName('hackathon_chatconnector/queue')}
                SET `status` = '" . Hackathon_ChatConnector_Model_Queue::STATUS_PROCESSED . "'
                , `updated_at` = '" . Mage::getModel('core/date')->date('Y-m-d H:i:s') . "'
                WHERE `entity_id` IN (" . implode(',', $succesIds) . ")
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
