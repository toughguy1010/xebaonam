<?php

/**
 * This is the model class for table "albums_categories".
 *
 * The followings are the available columns in table 'albums_categories':
 * @property string $cat_parent
 * @property string $site_id
 * @property string $cat_name
 * @property string $alias
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $status
 * @property integer $showinhome
 * @property string $image_path
 * @property string $image_name
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $meta_title
 * @property integer $cat_order
 * @property string $cat_description
 * @property integer $cat_countchild
 */
class InstallmentOrder extends ActiveRecord {

    public $avatar = '';
    public $from_date = null;
    public $to_date = null;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('installment_order');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username, phone, address,identity_code,shop_id', 'required'),
            array('phone, identity_code, monthly_income, other_loans, total, prepay', 'numerical', 'min' => 0),
            array('site_id', 'length', 'max' => 11),
            array('username', 'length', 'max' => 255),
            array('bankCode,paymentMethod', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, key, site_id, username, phone, email,address,identity_code,birthday,papers,papers_type,monthly_income,other_loans,shop_id,province_id,district_id,ward_id,product_id,month,prepay,installment_id,created_time,status,type_ship,payonline,bankCode,paymentMethod,modified_time,every_month,difference,interest_rate,reason,status_confirm', 'safe'),
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
            'username' => Yii::t('installment', 'Họ và tên'),
            'phone' => Yii::t('installment', 'Số điện thoại'),
            'email' => Yii::t('installment', 'Email'),
            'address' => Yii::t('installment', 'Số nhà, tên đường'),
            'identity_code' => Yii::t('installment', 'Thẻ căn cước, CMND'),
            'birthday' => Yii::t('installment', 'Ngày sinh'),
            'papers' => Yii::t('installment', 'Giấy tờ'),
            'papers_type' => Yii::t('installment', 'Loại giấy tờ'),
            'monthly_income' => Yii::t('installment', 'Thu nhập hàng tháng'),
            'other_loans' => Yii::t('installment', 'Khoản vay khác hàng tháng'),
            'shop_id' => Yii::t('installment', 'Chi nhánh duyệt hồ sơ'),
            'province_id' => Yii::t('installment', 'Tỉnh / Thành phố'),
            'district_id' => Yii::t('installment', 'Quận / Huyện'),
            'ward_id' => Yii::t('installment', 'Phường / Xã'),
            'month' => Yii::t('installment', 'Số tháng trả góp'),
            'prepay' => Yii::t('installment', 'Trả trước'),
            'installment_id' => Yii::t('installment', 'Công ty tài chính'),
            'created_time' => Yii::t('installment', 'Ngày tạo'),
            'site_id' => 'Site',
            'interes' => Yii::t('installment', 'Lãi suất %'),
            'collection_fee' => 'Phí thu hộ',
            'insurrance' => 'Bảo hiểm khoản vay %',
            'avatar' => Yii::t('common', 'avatar'),
            'total' => Yii::t('common', 'Tổng tiền'),
            'status' => Yii::t('common', 'Trạng thái'),
            'type_ship' => Yii::t('common', 'Phương thức nhận hàng'),
            'note' => Yii::t('common', 'Yêu cầu khác (Không bắt buộc)'),
            'every_month' => Yii::t('common', 'Trả hàng tháng'),
            'difference' => Yii::t('common', 'Chênh lệch'),
            'interest_rate' => Yii::t('common', 'Lãi suất'),
            'reason' => Yii::t('common', 'Trạng thái giao dịch'),
            'status_confirm' => Yii::t('common', 'Trạng thái xác nhận'),
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
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('payonline', $this->payonline);
        if ($this->from_date) {
            $this->from_date = (int)strtotime($this->from_date);
        } else {
            $this->from_date = 0;
        }
        if ($this->to_date) {
            $this->to_date = (int)strtotime($this->to_date);
        } else {
            $this->to_date = time();
        }
        $criteria->addBetweenCondition('created_time', $this->from_date, $this->to_date, "AND");
        //
        $criteria->order = 'created_time DESC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']),
                //'pageSize' => $pageSize,
                'pageVar' => 'page',
            ),
        ));
    }
    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->site_id = Yii::app()->siteinfo['site_id'];
            $this->created_time = time();
        } else {
            $this->modified_time = time();
        }
        return parent::beforeSave();
    }
    public static function getAll() {
        $result = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('installment_config'))
            ->where('site_id=:site_id', array(':site_id' => Yii::app()->controller->site_id))
            ->queryAll();

        return $result;
    }

    public static function getStatusPayment () {
        return [
            000 => 'Thành công',
            150 => 'Thẻ bị review ',
            111 => 'Thất bại',
            155 => 'Đợi người mua xác nhận trả góp',
            215 => 'Không duyệt thẻ review'
        ];
    }


    /**
     * Đếm số lượng đơn hàng
     */
    public static function getCountOrder()
    {
        $site_id = Yii::app()->controller->site_id;
        $model = Yii::app()->db->createCommand()->select('count(*)')
            ->from(self::model()->getTableName('installment_order'))
            ->where('status_confirm=:status_confirm AND site_id=:site_id', array(':status_confirm' => Orders::ORDER_WAITFORPROCESS, ':site_id' => $site_id))
            ->queryScalar();
        return $model;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AlbumsCategories the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
