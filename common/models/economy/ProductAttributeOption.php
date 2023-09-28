<?php

/**
 * This is the model class for table "product_attribute_option".
 *
 * The followings are the available columns in table 'product_attribute_option':
 * @property string $id
 * @property string $attribute_id
 * @property string $index_key
 * @property integer $sort_order
 * @property string $value
 * @property integer $site_id
 */
class ProductAttributeOption extends ActiveRecord {

    public static $_dataMulti = array(2, 4, 8, 16, 32, 64, 128, 256, 512, 1024, 2048, 4096, 8192, 16384, 32768, 65536, 131072, 262144, 524288, 1048576, 2097152, 4194304, 8388608, 16777216, 33554432, 67108864, 134217728, 268435456, 536870912, 1073741824, 2147483648);

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('product_attribute_option');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('value, site_id, attribute_id', 'required'),
            array('sort_order, site_id', 'numerical', 'integerOnly' => true),
            array('attribute_id, index_key', 'length', 'max' => 11),
            array('value', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, attribute_id, index_key, sort_order, value, ext, site_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'attribute_id' => 'Attribute',
            'index_key' => 'Index Key',
            'sort_order' => 'Sort Order',
            'value' => 'Value',
            'site_id' => 'Site',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('attribute_id', $this->attribute_id, true);
        $criteria->compare('index_key', $this->index_key, true);
        $criteria->compare('sort_order', $this->sort_order);
        $criteria->compare('value', $this->value, true);
        $criteria->compare('site_id', $this->site_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductAttributeOption the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        return parent::beforeSave();
    }

    public function getMaxSort($attribute_id) {
        return Yii::app()->db->createCommand()
                        ->select('MAX(sort_order)')
                        ->from(ClaTable::getTable('product_attribute_option'))
                        ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND attribute_id=:attribute_id', array(':attribute_id' => $attribute_id))
                        ->queryScalar();
    }

    public function getOptionByAttribute($attribute_id) {
        return Yii::app()->db->createCommand()
                        ->select()
                        ->from(ClaTable::getTable('product_attribute_option'))
                        ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND attribute_id=:attribute_id', array(':attribute_id' => $attribute_id))
                        ->order('sort_order ASC')
                        ->queryAll();
    }

    public function isExitName($name, $attribute_id) {
        $count = 0;
        $query = 'SELECT COUNT(*) FROM ' . ClaTable::getTable('product_attribute_option') . ' WHERE value=' . Yii::app()->db->quoteValue($name) . ' AND attribute_id=' . (int) $attribute_id . ' AND site_id=' . Yii::app()->siteinfo['site_id'];
        $count = Yii::app()->db->createCommand($query)->queryScalar();
        return $count;
    }

    public function generateKeyMulti($attribute_id) {
        if (!$attribute_id) {
            return 0;
        }
        $values = self::$_dataMulti;
        $valuesExist = Yii::app()->db->createCommand()
                ->select('index_key')
                ->from(ClaTable::getTable('product_attribute_option'))
                ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND attribute_id=:attribute_id', array(':attribute_id' => $attribute_id))
                ->queryColumn();
        $valuesList = array_diff($values, $valuesExist);
        if (!empty($valuesList)) {
            return array_shift($valuesList);
        }
        return 0;
    }

    public function getValueByKey($index_key, $attribute_id = 0) {
        if ($attribute_id) {
            return Yii::app()->db->createCommand()
                            ->select('value')
                            ->from(ClaTable::getTable('product_attribute_option'))
                            ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND index_key=:index_key AND attribute_id=:attribute_id', array(':index_key' => $index_key, ':attribute_id' => $attribute_id))
                            ->queryScalar();
        } else {
            return Yii::app()->db->createCommand()
                            ->select('value')
                            ->from(ClaTable::getTable('product_attribute_option'))
                            ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND id=:id', array(':id' => $index_key))
                            ->queryScalar();
        }
    }
    public function getExtByKey($index_key, $attribute_id = 0) {
        if ($attribute_id) {
            return Yii::app()->db->createCommand()
                            ->select('ext')
                            ->from(ClaTable::getTable('product_attribute_option'))
                            ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND index_key=:index_key AND attribute_id=:attribute_id', array(':index_key' => $index_key, ':attribute_id' => $attribute_id))
                            ->queryScalar();
        } else {
            return Yii::app()->db->createCommand()
                            ->select('ext')
                            ->from(ClaTable::getTable('product_attribute_option'))
                            ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND id=:id', array(':id' => $index_key))
                            ->queryScalar();
        }
    }

}
