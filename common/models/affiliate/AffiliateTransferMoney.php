<?php

/**
 * This is the model class for table "affiliate_transfer_money".
 *
 * The followings are the available columns in table 'affiliate_transfer_money':
 * @property string $id
 * @property string $user_id
 * @property string $money
 * @property integer $status
 * @property string $note
 * @property string $note_admin
 * @property string $site_id
 * @property string $created_time
 * @property string $modified_time
 * @property string $image_path
 * @property string $image_name
 */
class AffiliateTransferMoney extends ActiveRecord {

    const STATUS_WAITING = 0; // đang chờ
    const STATUS_TRANSFERED = 1; // đã chuyển
    const STATUS_FAILED = 2; // không được chấp nhận
    
    public $image = '';

    /**
     * @return string the associated database table name
     */

    public function tableName() {
        return 'affiliate_transfer_money';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('money', 'required'),
            array('status', 'numerical', 'integerOnly' => true),
            array('user_id, money, site_id, created_time, modified_time', 'length', 'max' => 10),
            array('note, note_admin', 'length', 'max' => 1000),
            array('image_path, image_name', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, money, status, note, note_admin, site_id, created_time, modified_time, image_path, image_name, image', 'safe'),
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
            'user_id' => 'User',
            'money' => 'Số tiền yêu cầu chuyển',
            'status' => 'Trạng thái',
            'note' => 'Ghi chú',
            'note_admin' => 'Ghi chú của admin',
            'site_id' => 'Site',
            'created_time' => 'Thời gian yêu cầu',
            'modified_time' => 'Thời gian cập nhật',
            'image_path' => 'Image Path',
            'image_name' => 'Image Name',
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
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('site_id', $this->site_id, true);
        
        $criteria->order = 'id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AffiliateTransferMoney the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->modified_time = $this->created_time;
        } else {
            $this->modified_time = time();
        }
        return parent::beforeSave();
    }

    public static function arrStatus() {
        return [
            self::STATUS_WAITING => 'Đang chờ duyệt',
            self::STATUS_TRANSFERED => 'Đã chuyển tiền',
            self::STATUS_FAILED => 'Không được chấp nhận'
        ];
    }

    public static function getNameStatus($status) {
        $arrStatus = self::arrStatus();
        return $arrStatus[$status];
    }
    
    public static function getTotalMoneyKeep($status) {
        $condition = 'user_id=:user_id AND status=:status';
        $params = [
            ':user_id' => Yii::app()->user->id,
            ':status' => $status
        ];
        $total = Yii::app()->db->createCommand()
                ->select('SUM(money)')
                ->from('affiliate_transfer_money')
                ->where($condition, $params)
                ->queryScalar();
        return $total;
    }

}
