<?php

/**
 * model base custormer
 *
 */
class ActiveRecordC extends ActiveRecord {
    public $promt = '---chọn---';

    function options($options = []) {
        $data = Yii::app()->db->createCommand()->select()
                ->from($this->tableName())
                ->where('site_id ='.Yii::app()->controller->site_id)
                ->queryAll();
        $data = $data ? $data :  Yii::app()->db->createCommand()->select()
                ->from($this->tableName())
                ->where('site_id IS NULL')
                ->queryAll();
        $value = isset($options['value']) && $options['value'] ? $options['value'] : 'name';
        $key = isset($options['key']) && $options['key'] ? $options['key'] : 'id';
        $return = array_column($data, $value, $key); 
        if(isset($options['promt']) && $options['promt']) {
            $promt = ($options['promt'] === true) ? array('' => $this->promt) : array('' => $options['promt']);
            $return = $promt + $return;
        } 
        if(isset($options['other']) && $options['other']) {
            $return = $return + array(-1 => 'Thêm mới');
        }
        return $return;
    }

}
