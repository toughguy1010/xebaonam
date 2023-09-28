<?php

/**
 * 
 * Enter description here ...
 * @author tony
 *
 */
class AttributeHelper extends BaseHelper {

    public static function helper($className = __CLASS__) {
        return parent::helper($className);
    }

    public function getDynamicProduct($pro, $attributesShow) {
        $results = array();
        $dynamic = ($pro->product_info->dynamic_field) ? json_decode($pro->product_info->dynamic_field) : array();
        if (!empty($dynamic)) {
            foreach ($dynamic as $objAtt) {
                if (isset($attributesShow[$objAtt->id])) {
                    $results[$objAtt->id]['attribute_id'] = $attributesShow[$objAtt->id]['id'];
                    $results[$objAtt->id]['name'] = $attributesShow[$objAtt->id]['name'];
                    if (isset($objAtt->value_child) && $objAtt->value_child) {
                        $results[$objAtt->id]['value'] = ProductAttributeOptionChildren::model()->getValueById($objAtt->value_child);
                    } else {
                        $results[$objAtt->id]['value'] = $this->getValueAttribute($attributesShow[$objAtt->id], $objAtt->index_key, $objAtt->value);
                        //hatv get ext to select color detal page
                        $results[$objAtt->id]['ext'] = $this->getExtAttribute($attributesShow[$objAtt->id], $objAtt->index_key, $objAtt->value);
                    }
                }
            }
        }
        return $results;
    }

    public function getValueAttribute($attribute, $index_key, $value = "") {
        if ($attribute['frontend_input'] == 'select') {
            return ProductAttributeOption::model()->getValueByKey($index_key);
        } elseif ($attribute['frontend_input'] == 'multiselect') {
            if (is_array($index_key) && !empty($index_key)) {
                $val = array();
                foreach ($index_key as $ikey) {
                    $v = ProductAttributeOption::model()->getValueByKey($ikey, $attribute['id']);
                    if ($v)
                        $val[] = $v;
                }
                return empty($val) ? '' : $val;
            }else {
                return $value;
            }
        } else {
            return $value;
        }
    }

    public function getExtAttribute($attribute, $index_key, $value = "") {
        if ($attribute['frontend_input'] == 'select') {
            return ProductAttributeOption::model()->getExtByKey($index_key);
        } elseif ($attribute['frontend_input'] == 'multiselect') {
            if (is_array($index_key) && !empty($index_key)) {
                $val = array();
                foreach ($index_key as $ikey) {
                    $v = ProductAttributeOption::model()->getExtByKey($ikey, $attribute['id']);
                    if ($v)
                        $val[] = $v;
                }
                return empty($val) ? '' : $val;
            }else {
                return $value;
            }
        } else {
            return $value;
        }
    }

    /**
     * return attributes is set is_configurable equal 1 of attribute set
     */
    function getConfigurableAttributes($att_set_id = 0) {
        $atttibutes = array();
        $_atttibutes = ProductAttribute::model()->findAll(
                'site_id=' . Yii::app()->controller->site_id . ' AND is_configurable=1 AND attribute_set_id=:attribute_set_id order by sort_order asc limit 3', array(':attribute_set_id' => $att_set_id)
        );
        if (count($_atttibutes)) {
            foreach ($_atttibutes as $att) {
                $atttibutes[$att->id] = $att->attributes;
                $atttibutes[$att->id]['options'] = FilterHelper::helper()->getAttributeOption($att);
            }
        }
        //
        return $atttibutes;
    }

    /**
     * get configurable attribute values
     * @param type $attribute
     */
    function geProducttConfigurableValues($product = array(), $isArray = true) {
        $configs = array();
        if (!$isArray) {
            $proConfigs = ProductConfigurableValue::model()->findAll(
                    'site_id=' . Yii::app()->controller->site_id . ' AND product_id=:product_id  limit 30', array(':product_id' => $product['id'])
            );
        } else {
            $proConfigs = Yii::app()->db->createCommand()->select()->from(ProductConfigurableValue::model()->tableName())
                    ->where('site_id=' . Yii::app()->controller->site_id . ' AND product_id=:product_id', array(':product_id' => $product['id']))
                    ->limit(30)
                    ->queryAll();
        }
        if (count($proConfigs)) {
            foreach ($proConfigs as $conf)
                $configs[$conf['id']] = $conf;
        }
        return $configs;
    }

    //
    /**
     * Lấy ra các thuộc tính của product được set là configurable và các giá trị của nó
     * @param type $att_set_id
     * @param type $product
     */
    function getConfiguableFilter($att_set_id = 0, $product = array()) {
        // các attributes dc set là configurable của
        $attributeConfigurables = AttributeHelper::helper()->getConfigurableAttributes($att_set_id);
        //Các giá trị configurable của product
        $productConfigurableValues = AttributeHelper::helper()->geProducttConfigurableValues($product);

        foreach ($attributeConfigurables as $attribute_id => $attribute) {

            $configurableField = $attribute['field_configurable'];
            if (!$configurableField)
                continue;
            $configurableField = 'attribute' . $configurableField . "_value";
            foreach ($productConfigurableValues as $config) {

                if (isset($config[$configurableField]) && (int) $config[$configurableField] && !isset($attributeConfigurables[$attribute_id]['configuable'][$config[$configurableField]])) {
                    $attributeConfigurables[$attribute_id]['configuable'][$config[$configurableField]]['id'] = $config['id'];
                    $attributeConfigurables[$attribute_id]['configuable'][$config[$configurableField]]['value'] = $config[$configurableField];
                    $attributeConfigurables[$attribute_id]['configuable'][$config[$configurableField]]['name'] = $this->getOptionNameByIndexKey($config[$configurableField], $attributeConfigurables[$attribute_id]['options']);
                    $attributeConfigurables[$attribute_id]['configuable'][$config[$configurableField]]['text'] = $this->getOptionTextByIndexKey($config[$configurableField], $attributeConfigurables[$attribute_id]['options']);
                    $attributeConfigurables[$attribute_id]['configuable'][$config[$configurableField]]['price'] = HtmlFormat::money_format($config['price']);
                }
            }
        }
        //
        return $attributeConfigurables;
    }

    //
    function getOptionNameByIndexKey($index_key_value = '', $attributeOptions = array()) {
        foreach ($attributeOptions as $option)
            if ($option['index_key'] == $index_key_value)
                return isset($option['name']) ? $option['name'] : $option['value'];
        return '';
    }

    //
    function getOptionTextByIndexKey($index_key_value = '', $attributeOptions = array()) {
        foreach ($attributeOptions as $option)
            if ($option['index_key'] == $index_key_value)
                return isset($option['text']) ? $option['text'] : $option['text'];
        return '';
    }

    /**
     * 
     * @param type $attribute
     * @param type $index_key
     */
    function getSingleAttributeOption($attribute_id = 0, $index_key = '') {
        return ProductAttributeOption::model()->find('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND attribute_id = :attribute_id AND index_key = :index_key', array(':attribute_id' => $attribute_id, ':index_key' => $index_key));
    }

    /**
     * return attributes is set is_change_price via attribute set id
     */
    function getChangePriceAttributes($att_set_id = 0) {
        $atttibutes = array();
        $_atttibutes = ProductAttribute::model()->findAll(
                'site_id=' . Yii::app()->controller->site_id . ' AND is_change_price=1 AND attribute_set_id=:attribute_set_id order by sort_order asc limit 10', array(':attribute_set_id' => $att_set_id)
        );
        if (count($_atttibutes)) {
            foreach ($_atttibutes as $att) {
                $atttibutes[$att->id] = $att->attributes;
                $atttibutes[$att->id]['options'] = ProductAttributeOption::model()->getOptionByAttribute($att->id);
            }
        }
        return $atttibutes;
    }

    /**
     * return attributes is set is_change_price via attribute set id and product
     */
    function getChangePriceProduct($product_id, $att_set_id = 0) {        
        $atttibutes = array();
        if ($product_id) {
            $_atttibutes = ProductAttribute::model()->findAll(
                    'site_id=' . Yii::app()->controller->site_id . ' AND is_change_price=1 AND attribute_set_id=:attribute_set_id order by sort_order asc limit 10', array(':attribute_set_id' => $att_set_id)
            );
            if (count($_atttibutes)) {
                $count = ProductAttributeOptionPrice::model()->getCountByProduct($product_id);
                if ($count) {
                    foreach ($_atttibutes as $att) {                        
                        $options = ProductAttributeOptionPrice::model()->getOptionProduct($product_id, $att->id);
                        if(!empty($options)){
                            $atttibutes[$att->id] = $att->attributes;
                            $atttibutes[$att->id]['options'] = $options;
                        }
                    }
                }
            }
        }        
        return $atttibutes;
    }

    /**
     * @hungtm
     */
    function getProductConfigurable($product_id, $configurable_id) {
        $prdc = ProductConfigurable::model()->findByPk($product_id);
        $attribute_options = array();
        $attributes = array();
        if ($prdc) {
            $condition = '';
            $params = array();
            if (isset($prdc->attribute1_id) && $prdc->attribute1_id) {
                $condition .= 'id=:attribute1_id';
                $params[':attribute1_id'] = $prdc->attribute1_id;
            }
            if (isset($prdc->attribute2_id) && $prdc->attribute2_id) {
                $condition .= ' OR id=:attribute2_id';
                $params[':attribute2_id'] = $prdc->attribute2_id;
            }
            if (isset($prdc->attribute3_id) && $prdc->attribute3_id) {
                $condition .= ' OR id=:attribute3_id';
                $params[':attribute3_id'] = $prdc->attribute3_id;
            }
            $attributes = Yii::app()->db->createCommand()->select('*')
                    ->from('product_attribute')
                    ->where($condition, $params)
                    ->queryAll();
            $att_ids = array_column($attributes, 'id');
            if (isset($attributes) && count($attributes)) {
                $attribute_options = Yii::app()->db->createCommand()->select()
                        ->from('product_attribute_option')
                        ->where('attribute_id IN(' . join($att_ids, ',') . ')')
                        ->queryAll();
            }
        }
        //
        $data_attributes = array();
        $attribute_color = 0;
        if (count($attributes)) {
            foreach ($attributes as $attribute) {
                $data_attributes[$attribute['id']] = $attribute;
                if ($attribute['type_option'] == ProductAttribute::TYPE_OPTION_COLOR) {
                    $attribute_color = $attribute['id'];
                }
            }
        }
        $data_options = array();
        if (count($attribute_options)) {
            foreach ($attribute_options as $option) {
                $data_options[$option['attribute_id']][$option['index_key']] = $option;
            }
        }

        //
        $product_configurable = ProductConfigurableValue::model()->findByPk($configurable_id);
        $product = Product::model()->findByPk($product_id);
        $result = array();
        $result = $product->attributes;
        $result['price'] = $product_configurable->price;
        $result['id_product_link'] = $product_configurable->id_product_link;
        $result['label_ext'] = '';
        $result['color_code'] = '';
        if (isset($prdc->attribute1_id) && $prdc->attribute1_id > 0) {
            $result['attibute1'] = $data_options[$prdc->attribute1_id][$product_configurable['attribute1_value']];
            $result['label_ext'] .= $data_options[$prdc->attribute1_id][$product_configurable['attribute1_value']]['value'];
            if($prdc->attribute1_id == $attribute_color) {
                $result['color_code'] = $result['attibute1']['index_key'];
            }
        }
        if (isset($prdc->attribute2_id) && $prdc->attribute2_id > 0) {
            $result['attibute2'] = $data_options[$prdc->attribute2_id][$product_configurable['attribute2_value']];
            $result['label_ext'] .= ' - ' . $data_options[$prdc->attribute2_id][$product_configurable['attribute2_value']]['value'];
            if($prdc->attribute2_id == $attribute_color) {
                $result['color_code'] = $result['attibute2']['index_key'];
            }
        }
        if (isset($prdc->attribute3_id) && $prdc->attribute3_id > 0) {
            $result['attibute3'] = $data_options[$prdc->attribute3_id][$product_configurable['attribute3_value']];
            $result['label_ext'] .= ' - ' . $data_options[$prdc->attribute3_id][$product_configurable['attribute3_value']]['value'];
            if($prdc->attribute3_id == $attribute_color) {
                $result['color_code'] = $result['attibute3']['index_key'];
            }
        }
        return $result;
    }

    /**
     * @hungtm
     * function get all product configurable
     * if product type is configurable
     */
    function getAllProductConfigurable($product) {
        $prdc = ProductConfigurable::model()->findByPk($product['id']);
        $attribute_options = array();
        $attributes = array();
        //
        $condition = '';
        $params = array();
        if(isset($prdc->attribute1_id) && $prdc->attribute1_id) {
            $condition .= 'id=:attribute1_id';
            $params[':attribute1_id'] = $prdc->attribute1_id;
        }
        if(isset($prdc->attribute2_id) && $prdc->attribute2_id) {
            $condition .= ' OR id=:attribute2_id';
            $params[':attribute2_id'] = $prdc->attribute2_id;
        }
        if(isset($prdc->attribute3_id) && $prdc->attribute3_id) {
            $condition .= ' OR id=:attribute3_id';
            $params[':attribute3_id'] = $prdc->attribute3_id;
        }
        //
        if ($prdc) {
            $attributes = Yii::app()->db->createCommand()->select('*')
                    ->from('product_attribute')
                    ->where($condition, $params)
                    ->queryAll();
            $att_ids = array_column($attributes, 'id');
            if (isset($attributes) && count($attributes)) {
                $attribute_options = Yii::app()->db->createCommand()->select()
                        ->from('product_attribute_option')
                        ->where('attribute_id IN(' . join($att_ids, ',') . ')')
                        ->queryAll();
            }
        }
        $data_attributes = array();
        if (count($attributes)) {
            foreach ($attributes as $attribute) {
                $data_attributes[$attribute['id']] = $attribute;
            }
        }
        $data_options = array();
        if (count($attribute_options)) {
            foreach ($attribute_options as $option) {
                $data_options[$option['attribute_id']][$option['index_key']] = $option;
            }
        }

        $product_configurable = Yii::app()->db->createCommand()->select()
                ->from('product_configurable_value')
                ->where('product_id=:product_id', array(':product_id' => $product['id']))
                ->queryAll();
        $products = array();
        foreach ($product_configurable as $k => $prd) {
            $products[$k] = $prd;
            $products[$k]['label_ext'] = '';
            $products[$k]['attribute_code'] = '';
            if (isset($prdc->attribute1_id) && $prdc->attribute1_id > 0) {
                $products[$k]['attibute1'] = $data_options[$prdc->attribute1_id][$prd['attribute1_value']];
                $products[$k]['label_ext'] .= $data_options[$prdc->attribute1_id][$prd['attribute1_value']]['value'];
                $products[$k]['attribute_code'] .= $data_options[$prdc->attribute1_id][$prd['attribute1_value']]['index_key'];
            }
            if (isset($prdc->attribute2_id) && $prdc->attribute2_id > 0) {
                $products[$k]['attibute2'] = $data_options[$prdc->attribute2_id][$prd['attribute2_value']];
                $products[$k]['label_ext'] .= ' - ' . $data_options[$prdc->attribute2_id][$prd['attribute2_value']]['value'];
                $products[$k]['attribute_code'] .= $data_options[$prdc->attribute2_id][$prd['attribute2_value']]['index_key'];
            }
            if (isset($prdc->attribute3_id) && $prdc->attribute3_id > 0) {
                $products[$k]['attibute3'] = $data_options[$prdc->attribute3_id][$prd['attribute3_value']];
                $products[$k]['label_ext'] .= ' - ' . $data_options[$prdc->attribute3_id][$prd['attribute3_value']]['value'];
                $products[$k]['attribute_code'] .= $data_options[$prdc->attribute3_id][$prd['attribute3_value']]['index_key'];
            }
        }
        return $products;
    }

}
