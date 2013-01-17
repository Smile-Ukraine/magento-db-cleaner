<?php
/**
 * Cleanup expired entities in quote table and all linked tables
 *
 * @category  Smile
 * @package   Smile_DatabaseCleanup
 * @author    Oleksandr Zirka <oleksandr.zirka@smile.fr>
 * @copyright 2012 Smile
 */
class Smile_DatabaseCleanup_Model_Clear_Quote extends Mage_Core_Model_Abstract
{
    /**
     * Cleanup expired entities in quote table and all linked tables
     *
     * @return string Status message
     */
    public function clear()
    {
        $expirationDays = Mage::getStoreConfig('database_cleanup/quote/expired');

        $resource = Mage::getSingleton('core/resource');
        $write = $resource->getConnection('core_write');

        $condition = array($write->quoteInto('updated_at < NOW() - INTERVAL ? DAY', $expirationDays));
        $write->delete($resource->getTableName('sales_flat_quote'), $condition);

        return "Cleared tables:
            {$resource->getTableName('sales_flat_quote')},
            {$resource->getTableName('sales_flat_quote_address')},
            {$resource->getTableName('sales_flat_quote_item')},
            {$resource->getTableName('sales_flat_quote_item_option')},
            {$resource->getTableName('sales_flat_quote_payment')},
            {$resource->getTableName('sales_flat_quote_shipping_rate')},
            {$resource->getTableName('enterprise_customer_sales_flat_quote')},
            {$resource->getTableName('enterprise_customer_sales_flat_quote_address')}
            ";
    }
}