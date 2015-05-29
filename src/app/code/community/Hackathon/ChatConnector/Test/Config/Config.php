<?php

/**
 * Class Hackathon_ChatConnector_Test_Config_Config
 *
 * @group Hackathon_ChatConnector
 */
class Hackathon_ChatConnector_Test_Config_Config extends EcomDev_PHPUnit_Test_Case_Config
{
    /**
     * @test
     * @loadExpections
     */
    public function globalConfig()
    {
        $this->assertModuleVersion($this->expected('module')->getVersion());
        $this->assertModuleCodePool($this->expected('module')->getCodePool());
        $this->assertSetupResourceDefined(null, 'hackathon_chatconnector_setup');
        $this->assertSetupResourceExists(null, 'hackathon_chatconnector_setup');
        $this->assertSetupScriptVersions();
        $this->assertTableAlias('hackathon_chatconnector/queue', 'hackathon_chatconnector_queue');
    }
}
