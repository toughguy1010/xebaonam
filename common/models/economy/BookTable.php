<?php

/**
 * This is the model class for table "book_table".
 *
 * The followings are the available columns in table 'book_table':
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property integer $quantity
 * @property string $book_time
 * @property string $book_date
 * @property string $message
 * @property integer $branch
 * @property string $created_time
 * @property string $modified_time
 * @property integer $status
 * @property integer $site_id
 */
class BookTable extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'book_table';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, phone, quantity, book_time, book_date, branch', 'required'),
            array('quantity, branch, status', 'numerical', 'integerOnly' => true),
            array('name, email, book_time', 'length', 'max' => 255),
            array('phone', 'length', 'max' => 20),
            array('created_time, modified_time', 'length', 'max' => 10),
            array('message', 'length', 'max' => 1000),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, email, phone, quantity, book_time, book_date, message, branch, created_time, modified_time, status, site_id, address', 'safe', 'on' => 'search'),
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
            'name' => Yii::t('common','name'),
            'email' => Yii::t('common','email'),
            'phone' =>  Yii::t('common','phone'),
            'quantity' =>  Yii::t('common','quantity'),
            'book_time' => Yii::t('common','book_time'),
            'book_date' => Yii::t('common','book_date'),
            'message' => Yii::t('common','message'),
            'branch' => Yii::t('common','branch'),
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'status' => Yii::t('common','status'),
            'address' => Yii::t('common','address'),
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('quantity', $this->quantity);
        $criteria->compare('book_time', $this->book_time, true);
        $criteria->compare('book_date', $this->book_date, true);
        $criteria->compare('message', $this->message, true);
        $criteria->compare('branch', $this->branch);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('modified_time', $this->modified_time, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('address', $this->address);

        $criteria->order = 'id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return BookTable the static model class
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

}
