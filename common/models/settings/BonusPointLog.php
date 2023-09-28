<?php

/**
 * This is the model class for table "bonus_point".
 *
 * The followings are the available columns in table 'bonus_point':
 * @property integer $id
 * @property integer $user_id
 * @property integer $site_id
 * @property integer $order_id
 * @property integer $point
 * @property integer $type
 * @property integer $created_time
 * @property string $note
 * @property string $
 */
class BonusPointLog extends CActiveRecord {

    const BONUS_TYPE_PLUS_POINT = 1; //Điểm cộng
    const BONUS_TYPE_USE_POINT = 2; //Điểm trừ
    const BONUS_NOTE_COMPLETE_ORDER = 10; //Cộng điểm hoàn thành đơn hàng.
    const BONUS_NOTE_USE_POINT_IN_ORDER = 11; //Sử dụng điểm mua hàng.
    const BONUS_NOTE_REFUND = 12; //Hoàn điểm do của hàng hủy hóa đơn.
    const BONUS_NOTE_TRANSFER = 13; //Chuyển tiền
    const BONUS_NOTE_RECEIVER = 14; // Nhận tiền


    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'bonus_point_log';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, user_id, site_id, order_id, point, type, created_time', 'numerical', 'integerOnly' => true),
            array('custom_note', 'length', 'max' => 500),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, site_id, order_id, point, type, created_time, note, receiver_id, custom_note', 'safe'),
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
            'user_id' => Yii::t('common','user'),
            'site_id' => Yii::t('common','site'),
            'order_id' => Yii::t('bonus','order_id'),
            'point' => Yii::t('bonus','point'),
            'type' => Yii::t('bonus','type'),
            'created_time' => Yii::t('bonus','created_time'),
            'note' => Yii::t('bonus','note'),
            'receiver_id' => Yii::t('bonus','receiver_id'),
            'custom_note' => Yii::t('bonus','custom_note'),
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
    public function search($show_donate = null) {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('user_id', $this->user_id);
        $this->site_id = Yii::app()->controller->site_id;
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('order_id', $this->order_id);
        $criteria->compare('point', $this->point);
        $criteria->compare('type', $this->type);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('note', $this->note);
        $criteria->compare('receiver_id', $this->receiver_id);
        $criteria->compare('custom_note', $this->custom_note);
        if (!$show_donate) {
            $criteria->addCondition('type != 3');
        } else {
            $criteria->addCondition('type = 3');
        }
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return BonusPointLog the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
