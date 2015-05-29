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
 * Queue resource model
 *
 * @category    Hackathon
 * @package     Hackathon_ChatConnector
 * @author      Sander Mangel <sander@sandermangel.nl>
 */
class Hackathon_ChatConnector_Model_Resource_Queue extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Init the main table and primary key field
     */
    public function _construct()
    {
        $this->_init('hackathon_chatconnector/queue', 'entity_id');
    }

    /**
     * _beforeSave
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Mage_Core_Model_Resource_Db_Abstract
     */
    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        $object->setUpdatedAt($this->formatDate(true));
        if ($object->isObjectNew()) {
            $object->setCreatedAt($this->formatDate(true));
        }

        $status = $object->getStatus();
        if ($object->isObjectNew() && empty($status)) {
            $object->setStatus(Hackathon_ChatConnector_Model_Queue::STATUS_PENDING);
        }

        return parent::_beforeSave($object);
    }

    /**
     * Update the given queue items with the given status
     *
     * @param array $entityIds Entity IDs
     * @param int   $status    Status
     */
    public function updateStatus($entityIds, $status)
    {
        if (!is_array($entityIds)) {
            $entityIds = array($entityIds);
        }

        $adapter = $this->_getWriteAdapter();
        $bind = array(
            'status'     => $status,
            'updated_at' => Mage::getModel('core/date')->gmtDate(),
        );
        $where = array(
            'entity_id IN(?)' => $entityIds
        );
        $adapter->update($this->getMainTable(), $bind, $where);
    }

    /**
     * Update all non-processed rma entries to processed
     */
    public function cleanupProcessedEntries()
    {
        $adapter = $this->_getWriteAdapter();
        $where = array('status = ?' => Hackathon_ChatConnector_Model_Queue::STATUS_PROCESSED);
        $adapter->delete($this->getMainTable(), $where);
    }
}
