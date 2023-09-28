<?php

/**
 * This is the model class for table "car_attribute_category".
 *
 * The followings are the available columns in table 'car_attribute_category':
 * @property string $id
 * @property string $name
 * @property integer $group_id
 * @property integer $order
 * @property integer $site_id
 */
class CarAttributeCategory extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'car_attribute_category';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('group_id, order, site_id', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, group_id, order, site_id', 'safe'),
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
            'name' => 'Danh mục thuộc tính',
            'group_id' => 'Nhóm thuộc tính',
            'order' => 'Sắp xếp',
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('site_id', $this->site_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CarAttributeCategory the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function optionCategory() {
        $site_id = Yii::app()->controller->site_id;
        $categories = Yii::app()->db->createCommand()->select('*')
                ->from(ClaTable::getTable('car_attribute_category'))
                ->where('site_id=:site_id', array(':site_id' => $site_id))
                ->queryAll();
        $options = [];
        if (isset($categories) && $categories) {
            foreach ($categories as $category) {
                $options[$category['id']] = $category['name'];
            }
        }
        return $options;
    }

    public static function getAllCatByGroup($group_id) {
        $categories = Yii::app()->db->createCommand()->select('*')
                ->from(ClaTable::getTable('car_attribute_category'))
                ->where('group_id=:group_id', array(':group_id' => $group_id))
                ->order('order ASC')
                ->queryAll();
        //
        return $categories;
    }

    public static function getAllOptions($category_id) {
        $options = Yii::app()->db->createCommand()->select('*')
                ->from(ClaTable::getTable('car_attribute_option'))
                ->where('category_id=:category_id', array(':category_id' => $category_id))
                ->order('order ASC')
                ->queryAll();
        //
        return $options;
    }

}
