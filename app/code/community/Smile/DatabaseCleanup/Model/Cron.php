<?php
/**
 * Clear database periodically by cron
 *
 * @category  Smile
 * @package   Smile_DatabaseCleanup
 * @author    Oleksandr Zirka <oleksandr.zirka@smile.fr>
 * @copyright 2012 Smile
 */
class Smile_DatabaseCleanup_Model_Cron extends Mage_Core_Model_Abstract
{
    /**
     * @var array Entities that can be cleared by cron
     */
    protected $_entitiesToClean = array ('order', 'wishlist', 'quote');

    /**
     * Clear all entities scheduled by cron
     *
     * @return void
     */
    public function cleanupAll()
    {
        foreach ($this->_entitiesToClean as $entityType) {
            $status = Mage::getStoreConfig("database_cleanup/{$entityType}/cron");
            if ($status == 1) {
                $resultMessage = Mage::getModel('smile_databaseCleanup/clear_'.$entityType)->clear();
                Mage::log("Cleaning {$entityType}", null, 'database_cleanup.log');
                Mage::log("$resultMessage", null, 'database_cleanup.log');
            }
        }
    }
}