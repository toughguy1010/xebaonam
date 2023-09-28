<?php

/**
 * This is the model class for table "product_attribute_option_children".
 *
 * The followings are the available columns in table 'product_attribute_option_children':
 * @property string $id
 * @property string $option_id
 * @property integer $sort_order
 * @property string $value
 * @property integer $site_id
 */
class ProductAttributeOptionChildren extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('product_attribute_option_children');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('value, site_id, option_id', 'required'),
            array('sort_order, site_id', 'numerical', 'integerOnly' => true),
            array('option_id', 'length', 'max' => 11),
            array('value', 'length', 'max' => 500),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, option_id, sort_order, value, site_id', 'safe', 'on' => 'search'),
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
            'option_id' => 'Option',
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
        $criteria->compare('option_id', $this->attribute_id, true);
        $criteria->compare('sort_order', $this->sort_order);
        $criteria->compare('value', $this->value, true);
        $criteria->compare('site_id', $this->site_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function isExitName($name, $option_id) {
        $count = 0;
        $query = 'SELECT COUNT(*) FROM ' . ClaTable::getTable('product_attribute_option_children') . ' WHERE value=' . Yii::app()->db->quoteValue($name) . ' AND option_id=' . (int) $option_id . ' AND site_id=' . Yii::app()->siteinfo['site_id'];
        $count = Yii::app()->db->createCommand($query)->queryScalar();
        return $count;
    }

    public function getValueById($id) {
        return Yii::app()->db->createCommand()
                        ->select('value')
                        ->from(ClaTable::getTable('product_attribute_option_children'))
                        ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND id=:id', array(':id' => $id))
                        ->queryScalar();
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

}
