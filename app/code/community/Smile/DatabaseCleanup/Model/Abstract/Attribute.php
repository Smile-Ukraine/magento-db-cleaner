<?php
/**
 * Abstract class for attributes cleaning functionality
 *
 * @category  Smile
 * @package   Smile_DatabaseCleanup
 * @author    Oleksandr Zirka <oleksandr.zirka@smile.fr>
 * @copyright 2012 Smile
 */
class Smile_DatabaseCleanup_Model_Abstract_Attribute extends Mage_Core_Model_Abstract
{
    /**
     * @var array The list of unused attributes and values
     */
    protected $_unusedAttributesValues = array();

    /**
     * Get the list of unused attributes values
     *
     * @return string Status message
     */
    protected function _findUnusedAttributesValues()
    {
        $resource = Mage::getSingleton('core/resource');
        $read = $resource->getConnection('core_read');
        $select = $read->select()
            ->from(
                array('eaov' => $resource->getTableName('eav_attribute_option_value')),
                array(
                    'eao.attribute_id',
                    'eaov.option_id',
                    'attribute_name'=>'eal.value',
                    'option_value'=>'eaov.value'
                )
            )
            ->join(array('eao' => 'eav_attribute_option'), 'eaov.option_id = eao.option_id', array())
            ->join(
                array('eal' => 'eav_attribute_label'),
                'eal.attribute_id = eao.attribute_id AND eal.store_id = eaov.store_id ',
                array()
            );

        $attributesInfo = $read->fetchAll($select);

        if (count($attributesInfo) > 0) {
            foreach ($attributesInfo as $attributeInfo) {


                $select = $read->select()->from($resource->getTableName('catalog_product_entity_int'))
                    ->reset(Zend_Db_Select::COLUMNS)
                    ->columns('count(*) as cnt')
                    ->where('attribute_id = ?', $attributeInfo['attribute_id'])
                    ->where('value = ?', $attributeInfo['option_id']);


                $rowsNumber = $read->fetchOne($select);

                if ($rowsNumber == 0) {
                    if (!array_key_exists($attributeInfo['attribute_id'], $this->_unusedAttributesValues)) {
                        $this->_unusedAttributesValues[$attributeInfo['attribute_id']] = array();
                        $this->_unusedAttributesValues[$attributeInfo['attribute_id']]['name'] = $attributeInfo['attribute_name'];
                        $this->_unusedAttributesValues[$attributeInfo['attribute_id']]['options'] =array();
                    }
                    $this->_unusedAttributesValues[$attributeInfo['attribute_id']]['options'][$attributeInfo['option_id']]
                        = $attributeInfo['option_value'];
                }
            }
        }
    }

    /**
     * Build unused attributes values list in HTML format
     *
     * @return string
     */
    protected function _getUnusedAttributesHtml()
    {
        $unusedAttributesString = '';
        if (count($this->_unusedAttributesValues) > 0) {
            foreach ($this->_unusedAttributesValues as $id=>$info) {
                $unusedAttributesString .= '<br /><i>'.$info['name'].'</i>: '.implode(', ', $info['options']);
            }
        }
        return $unusedAttributesString;
    }
}