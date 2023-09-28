<?php

/**
 * This is the model class for table "popup_register_product_form".
 *
 * The followings are the available columns in table 'popup_register_product_form':
 * @property string $id
 * @property integer $site_id
 * @property integer $product_id
 * @property integer $popup_id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $note
 * @property string $address
 * @property integer $ward_id
 * @property integer $district_id
 * @property integer $province_id
 * @property integer $viewed
 * @property integer $status
 * @property integer $user_update
 * @property integer $created_at
 * @property integer $updated_at
 */
class PopupRegisterProductForm extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'popup_register_product_form';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('site_id, product_id, popup_id, name, phone, address, ward_id, district_id, province_id, viewed, status, user_update, created_at, updated_at', 'required'),
			array('site_id, product_id, popup_id, viewed, status, user_update, created_at, updated_at', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
			array('phone', 'length', 'max'=>20),
			array('email', 'length', 'max'=>100),
			array('note', 'length', 'max'=>500),
			array('address', 'length', 'max'=>250),
			array('ward_id, district_id, province_id', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, site_id, product_id, popup_id, name, phone, email, note, address, ward_id, district_id, province_id, viewed, status, user_update, created_at, updated_at', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'site_id' => 'Site',
			'product_id' => 'Product',
			'popup_id' => 'Popup',
			'name' => 'Họ và tên',
			'phone' => 'Số điện thoại',
			'email' => 'Email',
			'note' => 'Ghi chú',
			'address' => 'Địa chỉ',
			'ward_id' => 'Xã/phường',
			'district_id' => 'Quận/Huyện',
			'province_id' => 'Tỉnh/Thành phố',
			'viewed' => 'Viewed',
			'status' => 'Status',
			'user_update' => 'User Update',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('site_id',$this->site_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('popup_id',$this->popup_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('ward_id',$this->ward_id);
		$criteria->compare('district_id',$this->district_id);
		$criteria->compare('province_id',$this->province_id);
		$criteria->compare('viewed',$this->viewed);
		$criteria->compare('status',$this->status);
		$criteria->compare('user_update',$this->user_update);
		$criteria->compare('created_at',$this->created_at);
		$criteria->compare('updated_at',$this->updated_at);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PopupRegisterProductForm the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function beforeSave() {
        if ($this->isNewRecord) {
            $this->created_at = $this->updated_at = time();
        } else {
			$this->user_update = Yii::app()->user->id;
            $this->updated_at = time();
        }
        return parent::beforeSave();
    }

    public function getArrStatus() {
        return [
            -1 => 'Đã hủy',
            0 => 'Chưa xác nhận',
            1 => 'Đã xác nhận',
        ];
    }

    public function getStatusName($status = '') {
        $status = ($status === '') ? $this->status : $status;
        $arr = $this->getArrStatus();
        return isset($arr[$status]) ? $arr[$status] :  '';
    }
}
