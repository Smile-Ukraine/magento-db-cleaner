<?php
/**
 * Clear Wishlist button block
 *
 * @category  Smile
 * @package   Smile_DatabaseCleanup
 * @author    Oleksandr Zirka <oleksandr.zirka@smile.fr>
 * @copyright 2012 Smile
 */
class  Smile_DatabaseCleanup_Block_Button_ClearWishlist extends Smile_DatabaseCleanup_Block_Button_Abstract
{
    /**
     * @var string Button label
     */
    protected $_buttonLabel = 'Run cleaner';

    /**
     * Get action url for Clear button (Wishlist block)
     *
     * @return string Action url
     */
    protected function _getActionUrl()
    {
        return Mage::helper('adminhtml')->
            getUrl(
                Smile_DatabaseCleanup_Block_Button_Abstract::ACTION_URL,
                array('entity_type'=>'wishlist', 'action'=>'clear')
            );
    }
}
