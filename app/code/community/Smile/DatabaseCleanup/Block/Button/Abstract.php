<?php
/**
 * Common functionality for Analyze and Clear buttons
 *
 * @category  Smile
 * @package   Smile_DatabaseCleanup
 * @author    Oleksandr Zirka <oleksandr.zirka@smile.fr>
 * @copyright 2012 Smile
 */
abstract class Smile_DatabaseCleanup_Block_Button_Abstract extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    /**
     * Action url for Analyze and Clear buttons
     */
    const ACTION_URL = 'database_cleanup/adminhtml_index/index/';

    /**
     * @var string Button label
     */
     protected $_buttonLabel;

    /**
     * Get html code for element
     *
     * @param Varien_Data_Form_Element_Abstract $element Html element
     *
     * @return string
     */
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $this->setElement($element);

        $html = $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setType('button')
            ->setClass('scalable')
            ->setLabel($this->_buttonLabel)
            ->setOnClick("setLocation('{$this->_getActionUrl()}')")
            ->toHtml();

        return $html;
    }

    /**
     * Get url of module admin page
     *
     * @return string
     */

    abstract protected function _getActionUrl();

}
