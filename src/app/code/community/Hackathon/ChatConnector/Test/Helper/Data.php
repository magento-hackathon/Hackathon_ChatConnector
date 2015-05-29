<?php

/**
 * Class Hackathon_ChatConnector_Test_Helper_Data.
 *
 * @group Hackathon_ChatConnector
 */
class Hackathon_ChatConnector_Test_Helper_Data extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var Hackathon_ChatConnector_Helper_Data
     */
    protected $_helper;

    /**
     * Set up test class.
     */
    protected function setUp()
    {
        parent::setUp();
        $this->_helper = Mage::helper('hackathon_chatconnector');
    }

    /**
     * @test
     * @loadFixture
     */
    public function testIsActive()
    {
        $this->assertTrue($this->_helper->isActive());
    }

    /**
     * @test
     * @loadFixture
     */
    public function testIsNotActive()
    {
        $this->assertFalse($this->_helper->isActive());
    }

    /**
     * @test
     * @loadFixture
     * @loadExpectations
     */
    public function getActiveConnectors()
    {
        $this->assertEquals(
            $this->expected('connectors')->getResult(),
            $this->_helper->getActiveConnectors()
        );
    }

    /**
     * @test
     * @loadFixture
     */
    public function getRetryFrequency()
    {
        $this->assertEquals(7200, $this->_helper->getRetryFrequency());
    }
}
