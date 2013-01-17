<?php
/**
 * Cleanup expired entities in wishlist table and all linked tables
 *
 * @category  Smile
 * @package   Smile_DatabaseCleanup
 * @author    Oleksandr Zirka <oleksandr.zirka@smile.fr>
 * @copyright 2012 Smile
 */
class Smile_DatabaseCleanup_Model_Clear_Wishlist extends Mage_Core_Model_Abstract
{
    /**
     * Cleanup expired entities in wishlist table and all linked tables
     *
     * @return string Status message
     */
    public function clear()
    {
        $expirationDays = Mage::getStoreConfig('database_cleanup/wishlist/expired');

        $resource = Mage::getSingleton('core/resource');
        $write = $resource->getConnection('core_write');

        $condition = array($write->quoteInto('updated_at < NOW() - INTERVAL ? DAY', $expirationDays));
        $write->delete($resource->getTableName('wishlist'), $condition);

        return "Cleared tables:
            {$resource->getTableName('wishlist')},
            {$resource->getTableName('wishlist_item')}
            ";
    }
}