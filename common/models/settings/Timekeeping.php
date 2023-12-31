<?php

/**
 * This is the model class for table "timekeeping".
 *
 * The followings are the available columns in table 'timekeeping':
 * @property string $id
 * @property string $name
 * @property string $alias
 * @property string $filepath
 * @property integer $created_at
 * @property integer $updated_at
 */
class Timekeeping extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'timekeeping';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('created_at, updated_at', 'numerical', 'integerOnly' => true),
            array('name, alias, filepath', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, alias, filepath, created_at, updated_at', 'safe', 'on' => 'search'),
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
            'name' => 'Tên tháng',
            'alias' => 'Alias',
            'filepath' => 'Đường dẫn file',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('filepath', $this->filepath, true);
        $criteria->compare('created_at', $this->created_at);
        $criteria->compare('updated_at', $this->updated_at);

        $criteria->order = 'id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Timekeeping the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        if ($this->isNewRecord) {
            $this->alias = HtmlFormat::parseToAlias($this->name);
            $this->created_at = $this->updated_at = time();
        } else {
            $this->alias = HtmlFormat::parseToAlias($this->name);
            $this->updated_at = time();
        }
        //
        return parent::beforeSave();
    }

}
