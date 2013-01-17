<?php
/**
 * Cleanup expired entities in order table and all linked tables
 *
 * @category  Smile
 * @package   Smile_DatabaseCleanup
 * @author    Oleksandr Zirka <oleksandr.zirka@smile.fr>
 * @copyright 2012 Smile
 */
class Smile_DatabaseCleanup_Model_Clear_Order extends Mage_Core_Model_Abstract
{
    /**
     * Cleanup expired entities in order table and all linked tables
     *
     * @return string Status message
     */
    public function clear()
    {
        $expirationDays = Mage::getStoreConfig('database_cleanup/order/expired');

        $resource = Mage::getSingleton('core/resource');
        $write = $resource->getConnection('core_write');

        $condition = array($write->quoteInto('updated_at < NOW() - INTERVAL ? DAY', $expirationDays));
        $write->delete($resource->getTableName('sales_flat_order'), $condition);

        return "Cleared tables:
            {$resource->getTableName('sales_flat_order')},
            {$resource->getTableName('sales_flat_order_address')},
            {$resource->getTableName('sales_flat_order_grid')},
            {$resource->getTableName('sales_flat_order_item')},
            {$resource->getTableName('sales_flat_order_payment')},
            {$resource->getTableName('sales_flat_order_status_history')},
            {$resource->getTableName('enterprise_customer_sales_flat_order')},
            {$resource->getTableName('enterprise_customer_sales_flat_order_address')}
            ";
    }
}