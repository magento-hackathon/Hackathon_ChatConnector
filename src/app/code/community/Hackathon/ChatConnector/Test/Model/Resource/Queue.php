<?php

class Hackathon_ChatConnector_Test_Model_Resource_Queue extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var Hackathon_ChatConnector_Model_Resource_Queue
     */
    protected $_model;

    /**
     * Set up test class.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->_model = Mage::getResourceModel('hackathon_chatconnector/queue');
    }

    /**
     * @loadFixture
     * @dataProvider dataProvider
     */
    public function testUpdateStatus($entityIds)
    {
        // Test update
        $this->_model->updateStatus($entityIds, Hackathon_ChatConnector_Model_Queue::STATUS_PROCESSED);

        // Check result
        if (!is_array($entityIds)) {
            $entityIds = array($entityIds);
        }

        $collection = Mage::getResourceModel('hackathon_chatconnector/queue_collection');
        $collection->addFieldToFilter('entity_id', array('in' => $entityIds));
        $this->assertEquals(count($entityIds), $collection->count());
        foreach ($collection as $item) {
            $this->assertEquals(2, $item->getData('status'));
        }
    }

    /**
     * @loadFixture
     */
    public function testCleanupProcessedEntries()
    {
        $this->_model->cleanupProcessedEntries();

        $collection = Mage::getResourceModel('hackathon_chatconnector/queue_collection');
        $this->assertEquals(0, $collection->count());
    }
}
