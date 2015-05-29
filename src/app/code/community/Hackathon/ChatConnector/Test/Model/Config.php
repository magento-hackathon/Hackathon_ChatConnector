<?php

/**
 * Class Hackathon_ChatConnector_Test_Model_Config
 *
 * @group Hackathon_ChatConnector
 */
class Hackathon_ChatConnector_Test_Model_Config extends EcomDev_PHPUnit_Test_Case
{
    /**
     * @var Hackathon_ChatConnector_Model_Config
     */
    protected $_model;

    /**
     * Set up test class
     */
    protected function setUp()
    {
        parent::setUp();
        $this->_model = Mage::getModel('hackathon_chatconnector/config');
    }

    /**
     * @test
     * @loadFixture
     */
    public function testIsActive()
    {
        $this->assertTrue($this->_model->isActive());
    }

    /**
     * @test
     * @loadFixture
     */
    public function testIsNotActive()
    {
        $this->assertFalse($this->_model->isActive());
    }

    /**
     * @test
     * @loadFixture
     * @loadExpectations
     */
    public function getConnectors()
    {
        $this->assertEquals(
            $this->expected('connectors')->getResult(),
            $this->_model->getConnectors()
        );
    }
}
