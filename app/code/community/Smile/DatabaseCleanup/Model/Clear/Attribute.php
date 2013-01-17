<?php
/**
 * Cleanup unused attributes values
 *
 * @category  Smile
 * @package   Smile_DatabaseCleanup
 * @author    Oleksandr Zirka <oleksandr.zirka@smile.fr>
 * @copyright 2012 Smile
 */
class Smile_DatabaseCleanup_Model_Clear_Attribute extends Smile_DatabaseCleanup_Model_Abstract_Attribute
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
     * Cleanup unused attributes values
     *
     * @return string
     */
    public function clear()
    {
        if (count($this->_unusedAttributesValues) > 0) {
            foreach ($this->_unusedAttributesValues as $attributeId=>$attributeInfo) {
                $resource = Mage::getSingleton('core/resource');
                $write = $resource->getConnection('core_write');

                $write->delete(
                    $resource->getTableName('eav_attribute_option'),
                    array(
                    'option_id IN (?)' => array_keys($attributeInfo['options']),
                    'attribute_id = ?' => $attributeId
                    )
                );

                $write->delete(
                    $resource->getTableName('eav_attribute_option_value'),
                    array(
                        'option_id IN (?)' => array_keys($attributeInfo['options'])
                    )
                );

                $resultHtml = $this->_getUnusedAttributesHtml();
                $resultHtml = '<i>'.Mage::helper('smile_databasecleanup')->__('Cleared attributes values').':</i>'.$resultHtml;
            }
        } else {
            $resultHtml = Mage::helper('smile_databasecleanup')->__('There is no unused attributes values');
        }

        return $resultHtml;
    }
}