<?php

/**
 * This is the model class for table "shop_cat_self".
 *
 * The followings are the available columns in table 'shop_cat_self':
 * @property string $cat_id
 * @property integer $cat_parent
 * @property string $cat_name
 * @property string $alias
 * @property integer $cat_order
 * @property integer $shop_id
 * @property integer $site_id
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $status
 */
class ShopCatSelf extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('shop_cat_self');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cat_parent, cat_name, shop_id', 'required'),
            array('cat_parent, cat_order, shop_id, site_id, created_time, modified_time, status', 'numerical', 'integerOnly' => true),
            array('cat_name, alias', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('cat_id, cat_parent, cat_name, alias, cat_order, shop_id, site_id, created_time, modified_time, status', 'safe'),
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
            'cat_id' => 'Cat',
            'cat_parent' => 'Cat Parent',
            'cat_name' => 'Cat Name',
            'alias' => 'Alias',
            'cat_order' => 'Cat Order',
            'shop_id' => 'Shop',
            'site_id' => 'Site',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'status' => 'Status',
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

        $criteria->compare('cat_id', $this->cat_id, true);
        $criteria->compare('cat_parent', $this->cat_parent);
        $criteria->compare('cat_name', $this->cat_name, true);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('cat_order', $this->cat_order);
        $criteria->compare('shop_id', $this->shop_id);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ShopCatSelf the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->modified_time = $this->created_time;
            $this->alias = HtmlFormat::parseToAlias($this->cat_name);
        } else {
            $this->modified_time = time();
            if (!trim($this->alias) && $this->name) {
                $this->alias = HtmlFormat::parseToAlias($this->cat_name);
            }
        }
        return parent::beforeSave();
    }

}
