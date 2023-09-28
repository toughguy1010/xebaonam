<?php

/**
 * This is the model class for table "product_info".
 *
 * The followings are the available columns in table 'product_info':
 * @property string $product_id
 * @property string $product_sortdesc
 * @property string $product_desc
 * @property string $dynamic_field
 * @property integer $avatar_id
 * @property string $avatar_name
 * @property string $avatar_path
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property integer $site_id
 */
class ProductInfo extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('product_info');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('product_id', 'required'),
            array('meta_keywords, meta_description', 'length', 'max' => 255),
            array('product_note', 'length', 'max' => 3000),
            array('meta_title', 'length', 'max' => 400),
            array('product_sortdesc, product_desc, product_note, dynamic_field,list_product_relate', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('product_id, product_sortdesc, product_desc, dynamic_field, meta_title, meta_keywords, meta_description,list_product_relate, site_id, total_rating, total_votes, shop_store, product_desc', 'safe'),
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
            'product_id' => 'Product',
            'product_sortdesc' => Yii::t('product', 'product_sortdescription'),
            'product_desc' => Yii::t('product', 'product_description'),
            'product_note' => Yii::t('product', 'product_note'),
            'dynamic_field' => Yii::t('product', 'product_dynamic_field'),
            'meta_title' => Yii::t('common', 'meta_title'),
            'meta_keywords' => Yii::t('common', 'meta_keywords'),
            'meta_description' => Yii::t('common', 'meta_description'),
            'list_product_relate' => 'List Product Relate',
            'site_id' => 'Site',
            'total_rating' => 'total_rating',
            'total_votes' => 'total_votes',
            'shop_store' => Yii::t('shop', 'shop_store'),
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

        $criteria->compare('product_id', $this->product_id, true);
        $criteria->compare('product_sortdesc', $this->product_sortdesc, true);
        $criteria->compare('product_desc', $this->product_desc, true);
        $criteria->compare('dynamic_field', $this->dynamic_field, true);
        $criteria->compare('product_note', $this->product_note, true);
        $criteria->compare('meta_title', $this->meta_title, true);
        $criteria->compare('meta_keywords', $this->meta_keywords, true);
        $criteria->compare('meta_description', $this->meta_description, true);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('total_rating', $this->total_rating);
        $criteria->compare('total_votes', $this->total_votes);
        $criteria->compare('shop_store', $this->shop_store);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductInfo the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        return parent::beforeSave();
    }

    /**
     * Get all product
     * @param type $options
     * @return array
     */
    public static function getProductInfoInSite($options = array()) {
        if (!isset($options['limit']))
            $options['limit'] = self::PRODUCT_DEFAUTL_LIMIT;
        if (!isset($options[ClaSite::PAGE_VAR]))
            $options[ClaSite::PAGE_VAR] = 1;
        if (!(int) $options[ClaSite::PAGE_VAR])
            $options[ClaSite::PAGE_VAR] = 1;
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        $siteid = Yii::app()->controller->site_id;
        $products = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('product_info'))
                ->where("site_id=$siteid")
                ->limit($options['limit'], $offset)
                ->queryAll();
        $results = array();
        foreach ($products as $p) {
            $results[$p['product_id']] = $p;
        }
        return $results;
    }

    public static function getProductInfoByProductids($ids, $select) {
        if (count($ids)) {
            $results = Yii::app()->db->createCommand()->select($select)
                    ->from(ClaTable::getTable('product_info'))
                    ->where('product_id IN (' . join(',', $ids) . ') AND site_id=:site_id', array(':site_id' => Yii::app()->controller->site_id))
                    ->queryAll();
            return $results;
        } else {
            return array();
        }
    }

}
