<?php
/**
 * Process Analyze / Clear request for orders, quotes, wishlist
 *
 * @category  Smile
 * @package   Smile_DatabaseCleanup
 * @author    Oleksandr Zirka <oleksandr.zirka@smile.fr>
 * @copyright 2012 Smile
 */
class Smile_DatabaseCleanup_Adminhtml_IndexController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Process Analyze / Clear request for orders, quotes, wishlist
     *
     * @return void
     */
    public function indexAction()
    {
        $result = array();
        $entityType = $this->getRequest()->getParam('entity_type');
        $action = $this->getRequest()->getParam('action');
        if (in_array($entityType, array('order', 'quote', 'wishlist'))) {
            $expirationDays = Mage::getStoreConfig("database_cleanup/{$entityType}/expired");
            if (!$expirationDays) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('You need to set expiration days'));
                $this->_redirectReferer();
                return;
            }
        }
        switch ($action) {
            case 'analyze':
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Analyzing %s tables', $entityType));
                $resultMessage = Mage::getModel('smile_databaseCleanup/analyze_'.$entityType)->getTablesInfo();
                break;
            case 'clear':
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Cleaning database / %s', $entityType));
                $resultMessage = Mage::getModel('smile_databaseCleanup/clear_'.$entityType)->clear();
                break;
            default:
                Mage::getSingleton('adminhtml/session')->addError($this->__('Unknown request'));
                break;
        }

        if ($resultMessage!='') {
                Mage::getSingleton('adminhtml/session')->addSuccess($resultMessage);
        } else {
            Mage::getSingleton('adminhtml/session')->addError($this->__('No information available'));
        }
        $this->_redirectReferer();
    }
}