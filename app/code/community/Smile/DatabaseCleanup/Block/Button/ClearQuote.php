<?php
/**
 * Clear Quote button block
 *
 * @category  Smile
 * @package   Smile_DatabaseCleanup
 * @author    Oleksandr Zirka <oleksandr.zirka@smile.fr>
 * @copyright 2012 Smile
 */
class  Smile_DatabaseCleanup_Block_Button_ClearQuote extends Smile_DatabaseCleanup_Block_Button_Abstract
{
    /**
     * @var string Button label
     */
    protected $_buttonLabel = 'Run cleaner';

    /**
     * Get action url for Clear button (Quote block)
     *
     * @return string Action url
     */
    protected function _getActionUrl()
    {
        return Mage::helper('adminhtml')->
            getUrl(
                Smile_DatabaseCleanup_Block_Button_Abstract::ACTION_URL,
                array('entity_type'=>'quote', 'action'=>'clear')
            );
    }

}
