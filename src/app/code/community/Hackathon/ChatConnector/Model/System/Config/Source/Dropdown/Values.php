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
 * System Config Dropdown Values
 *
 * @category    Hackathon
 * @package     Hackathon_ChatConnector
 * @author      Marcel Hauri <marcel@hauri.me>
 */
class Hackathon_ChatConnector_Model_System_Config_Source_Dropdown_Values
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array(
                'value' => 'none',
                'label' => 'Please choose a connector',
            ),
            array(
                'value' => 'slack',
                'label' => 'Slack',
            ),
            array(
                'value' => 'hipchat',
                'label' => 'HipChat',
            ),
        );
    }
}
