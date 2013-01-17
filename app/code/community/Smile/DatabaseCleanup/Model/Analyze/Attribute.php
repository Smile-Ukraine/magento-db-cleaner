<?php
/**
 * Find unused attributes values
 *
 * @category  Smile
 * @package   Smile_DatabaseCleanup
 * @author    Oleksandr Zirka <oleksandr.zirka@smile.fr>
 * @copyright 2012 Smile
 */
class Smile_DatabaseCleanup_Model_Analyze_Attribute extends Smile_DatabaseCleanup_Model_Abstract_Attribute
{
    /**
     * Initialize array of unused attributes
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_findUnusedAttributesValues();
        parent::_construct();
    }

    /**
     * Create the list of unused attributes values
     *
     * @return string List message
     */
    public function getTablesInfo()
    {
        $resultHtml = $this->_getUnusedAttributesHtml();
        if ($resultHtml!='') {
            $resultHtml = '<i>'.Mage::helper('smile_databasecleanup')->__('Unused attributes values').':</i>'.$resultHtml;
        } else {
            $resultHtml = Mage::helper('smile_databasecleanup')->__('There is no unused attributes values');
        }
        return $resultHtml;
    }
}