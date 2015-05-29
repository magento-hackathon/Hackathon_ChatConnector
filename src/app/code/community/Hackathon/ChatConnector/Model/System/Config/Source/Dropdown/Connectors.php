<?php

/**
 * Hackathon_ChatConnector extension.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 *
 * @category       Hackathon
 *
 * @copyright      Copyright (c) 2015
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * System Config Dropdown Values.
 *
 * @category    Hackathon
 *
 * @author      Marcel Hauri <marcel@hauri.me>
 */
class Hackathon_ChatConnector_Model_System_Config_Source_Dropdown_Connectors
{
    /**
     * Retrieve the configured connectors.
     *
     * @return array
     */
    public function toOptionArray()
    {
        $values = array();
        $connectors = Mage::helper('hackathon_chatconnector')->getConfiguredConnectors();
        foreach ($connectors as $key => $params) {
            $values[] = array(
                'value' => $key,
                'label' => $params['name'],
            );
        }

        return $values;
    }
}
