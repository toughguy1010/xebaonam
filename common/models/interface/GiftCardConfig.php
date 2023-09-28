<?php

/**
 * This is the model class for table "gift_card_config".
 *
 * The followings are the available columns in table 'gift_card_config':
 * @property string $site_id
 * @property string $name
 * @property string $min_value
 * @property string $max_value
 * @property string $expire_days
 * @property string $term
 * @property string $created_time
 * @property string $modified_time
 * @property string $note
 * @property string $business
 */
class GiftCardConfig extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'gift_card_config';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('site_id, name, expire_days, term, min_value, max_value', 'required'),
            array('site_id, expire_days, created_time, modified_time', 'length', 'max' => 10),
            array('name', 'length', 'max' => 255),
            array('note', 'length', 'max' => 500),
            array('min_value, max_value', 'length', 'max' => 16),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('site_id, name, min_value, max_value, expire_days, term, created_time, modified_time, note, business', 'safe'),
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
            'site_id' => 'Site',
            'name' => 'Name',
            'min_value' => 'Min Value',
            'max_value' => 'Max Value',
            'expire_days' => 'Expire Days',
            'term' => 'Terms & conditions',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'note' => 'Note'
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

        $criteria->compare('site_id', $this->site_id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('min_value', $this->min_value, true);
        $criteria->compare('max_value', $this->max_value, true);
        $criteria->compare('expire_days', $this->expire_days, true);
        $criteria->compare('term', $this->term, true);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('modified_time', $this->modified_time, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return GiftCardConfig the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    function beforeSave() {
        if ($this->isNewRecord) {
            $this->created_time = $this->modified_time = time();
        } else {
            $this->modified_time = time();
        }
        return parent::beforeSave();
    }

}
