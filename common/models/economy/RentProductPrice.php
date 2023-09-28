<?php

/**
 * This is the model class for table "rent_product_price".
 *
 * The followings are the available columns in table 'rent_product_price':
 * @property string $id
 * @property integer $rent_product_id
 * @property integer $rent_category_id
 * @property string $price_market
 * @property string $price
 * @property string $insurance_fee
 * @property string $deposits
 * @property integer $site_id
 */
class RentProductPrice extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'rent_product_price';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('rent_product_id, rent_category_id', 'required'),
            array('rent_product_id, rent_category_id, site_id', 'numerical', 'integerOnly' => true),
            array('price_market, price, insurance_fee, deposits', 'length', 'max' => 16),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, rent_product_id, rent_category_id, price_market, price, insurance_fee, deposits, site_id', 'safe'),
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
            'rent_product_id' => 'Sản phẩm',
            'rent_category_id' => 'Danh mục',
            'price_market' => 'Giá thị trường',
            'price' => 'Giá',
            'insurance_fee' => 'Phí bảo hiểm',
            'deposits' => 'Đặt cọc',
            'site_id' => 'Site Id'
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
        $criteria->compare('rent_product_id', $this->rent_product_id);
        $criteria->compare('rent_category_id', $this->rent_category_id);
        $criteria->compare('price_market', $this->price_market, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('insurance_fee', $this->insurance_fee, true);
        $criteria->compare('deposits', $this->deposits, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RentProductPrice the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        return parent::beforeSave();
    }

    public static function getAllDataPrice() {
        $data = Yii::app()->db->createCommand()
                ->select()
                ->from('rent_product_price')
                ->where('site_id=:site_id', [
                    ':site_id' => Yii::app()->siteinfo['site_id']
                ])
                ->queryAll();
        $result = [];
        if (isset($data) && $data) {
            foreach ($data as $item) {
                $result[$item['rent_product_id']][] = $item;
            }
        }
        return $result;
    }

    public static function getAllPriceByProductId($rent_product_id) {
        return Yii::app()->db->createCommand()
                        ->select()
                        ->from('rent_product_price')
                        ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND rent_product_id=:rent_product_id', array(
                            ':rent_product_id' => $rent_product_id
                        ))
                        ->queryAll();
    }
    public static function getPriceByProductId($rent_product_id, $rent_category_id) {
        return Yii::app()->db->createCommand()
                        ->select()
                        ->from('rent_product_price')
                        ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND rent_product_id=:rent_product_id AND rent_category_id=:rent_category_id', array(
                            ':rent_category_id' => $rent_category_id, ':rent_product_id' => $rent_product_id
                        ))
                        ->queryAll();
    }

    public static function getOptionsCategory($rent_product_id) {
        $data = Yii::app()->db->createCommand()
                ->select()
                ->from('rent_product_price')
                ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND rent_product_id=:rent_product_id', array(
                    ':rent_product_id' => $rent_product_id
                ))
                ->queryAll();
        $result = [];
        if (isset($data) && $data) {
            foreach ($data as $item) {
                $category = RentCategories::model()->findByPk($item['rent_category_id']);
                $result[$item['rent_category_id']] = $category['cat_name'];
            }
        }
        return $result;
    }

}
