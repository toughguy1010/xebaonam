<?php

/**
 * This is the model class for table "product_images".
 *
 * The followings are the available columns in table 'product_images':
 * @property integer $img_id
 * @property integer $shop_id
 * @property string $name
 * @property string $path
 * @property string $display_name
 * @property string $description
 * @property string $alias
 * @property integer $site_id
 * @property integer $user_id
 * @property integer $height
 * @property integer $width
 * @property integer $created_time
 * @property integer $modified_time
 * @property string $resizes
 */
class ShopStoreImages extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('shop_store_images');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('shop_id, site_id, user_id, height, width, created_time, modified_time, order', 'numerical', 'integerOnly' => true),
            array('name, path, display_name, description, alias', 'length', 'max' => 255),
            array('resizes', 'length', 'max' => 500),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('img_id, shop_id, name, path, display_name, description, alias, site_id, user_id, height, width, created_time, modified_time, resizes, order', 'safe', 'on' => 'search'),
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
            'img_id' => 'Img',
            'shop_id' => 'Product',
            'name' => 'Name',
            'path' => 'Path',
            'display_name' => 'Display Name',
            'description' => 'Description',
            'alias' => 'Alias',
            'site_id' => 'Site',
            'user_id' => 'User',
            'height' => 'Height',
            'width' => 'Width',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'resizes' => 'Resizes',
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

        $criteria->compare('img_id', $this->img_id);
        $criteria->compare('shop_id', $this->shop_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('path', $this->path, true);
        $criteria->compare('display_name', $this->display_name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('height', $this->height);
        $criteria->compare('width', $this->width);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('resizes', $this->resizes, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductImages the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
