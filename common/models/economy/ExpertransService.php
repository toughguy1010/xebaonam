<?php

/**
 * This is the model class for table "expertrans_service".
 *
 * The followings are the available columns in table 'expertrans_service':
 * @property string $id
 * @property string $name
 * @property string $aff_percent
 * @property integer $type
 * @property integer $status
 */
class ExpertransService extends ActiveRecord
{
    const LANGUAGE_SOLUTIONS = 1;
    const BPO = 2;
    const STAFFING_SOLUTIONS  = 3;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return $this->getTableName('expertrans_service');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, aff_percent, type, status', 'required'),
            array('type, status', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 255),
            array('aff_percent', 'length', 'max' => 5),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, aff_percent, type, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'name' => Yii::t('translate','name'),
            'aff_percent' => Yii::t('translate','aff_percent'),
            'type' => Yii::t('translate','type'),
            'status' => Yii::t('translate','status'),
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('aff_percent', $this->aff_percent, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('status', $this->status);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('updated_time', $this->updated_time);
        $criteria->order = 'id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ExpertransService the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public static function getOptions($options = [])
    {
        $sql = 'site_id=:site_id AND status=:status';
        $params = array(':site_id' => Yii::app()->controller->site_id, ':status' => ActiveRecord::STATUS_ACTIVED);
        if($options['type']){
            $sql.= ' AND type=:type';
            $params[':type'] = $options['type'];
        }
        $data = Yii::app()->db->createCommand()->select('id, name')
            ->from(ClaTable::getTable('expertrans_service'))
            ->where($sql, $params)
            ->order('id ASC')
            ->queryAll();

        return array_column($data, 'name', 'id');
    }

    public static function getType($options = [])
    {
        return array(
            self::LANGUAGE_SOLUTIONS => Yii::t('translate', 'language_solution'),
            self::STAFFING_SOLUTIONS => Yii::t('translate', 'staffing_solution'),
            self::BPO => Yii::t('translate', 'bpo_solution'),
        );
    }

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->updated_time = $this->created_time;
        } else {
            $this->updated_time = time();
        }
        return parent::beforeSave();
    }

}
