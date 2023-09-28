<?php

/**
 * This is the model class for table "shop_product_category".
 *
 * The followings are the available columns in table 'shop_product_category':
 * @property string $id
 * @property integer $shop_id
 * @property integer $cat_id
 * @property integer $site_id
 */
class ShopProductCategory extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('shop_product_category');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('shop_id, cat_id, site_id', 'required'),
            array('shop_id, site_id, cat_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, shop_id, cat_id, site_id', 'safe', 'on' => 'search'),
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
            'shop_id' => 'Shop',
            'cat_id' => 'Cat',
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
        $criteria->compare('shop_id', $this->shop_id);
        $criteria->compare('cat_id', $this->cat_id);
        $criteria->compare('site_id', $this->site_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ShopProductCategory the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public static function getShopCategoriesByShopid($id) {
        $shop_categories = Yii::app()->db->createCommand()->select('cat_id')
                ->from(ClaTable::getTable('shop_product_category'))
                ->where('shop_id=:shop_id AND site_id=:site_id', array(':shop_id' => $id, ':site_id' => Yii::app()->controller->site_id))
                ->queryColumn();
        return $shop_categories;
    }

    public static function getShopCategories() {
        $current_shop = Shop::getCurrentShop();
        $shop_categories = Yii::app()->db->createCommand()->select('cat_id')
                ->from(ClaTable::getTable('shop_product_category'))
                ->where('shop_id=:shop_id AND site_id=:site_id', array(':shop_id' => $current_shop['id'], ':site_id' => Yii::app()->controller->site_id))
                ->queryColumn();
        return $shop_categories;
    }

    public static function getShopCategoriesAdmin() {
        $id = Yii::app()->request->getParam('id');
        $current_shop = Shop::model()->findByPk($id);
        $shop_categories = Yii::app()->db->createCommand()->select('cat_id')
                ->from(ClaTable::getTable('shop_product_category'))
                ->where('shop_id=:shop_id AND site_id=:site_id', array(':shop_id' => $current_shop['id'], ':site_id' => Yii::app()->controller->site_id))
                ->queryColumn();
        return $shop_categories;
    }

    public static function getInfoCategoryByIds($ids) {
        $data = Yii::app()->db->createCommand()->select('cat_id, cat_name')
                ->from(ClaTable::getTable('product_categories'))
                ->where('cat_id in (' . join(',', $ids) . ') AND site_id=:site_id AND status=:status', array(':site_id' => Yii::app()->controller->site_id, ':status' => ActiveRecord::STATUS_ACTIVED))
                ->queryAll();
        
        $result = array_column($data, 'cat_name', 'cat_id');
        
        return $result;
    }

}
