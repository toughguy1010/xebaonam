<?php

/**
 * This is the model class for table "newsletters".
 *
 * The followings are the available columns in table 'newsletters':
 * @property integer $id
 * @property integer $site_id
 * @property string $name
 * @property string $email
 * @property integer $created_time
 * @property integer $viewed
 */
class Newsletters extends ActiveRecord
{
    const DEFAUTL_LIMIT = 100000;
    public $oldMail = '';

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return $this->getTableName('newsletters');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('email', 'required'),
            array('name', 'length', 'max' => 255),
            array('email', 'length', 'max' => 100),
            array('email', 'email'),
            array('email', 'checkEmailInsite'),
            array('phone', 'length', 'max' => 20),
            //array(array('email', 'site_id'), 'unique'),
            array('id, site_id, name, email, phone, created_time, viewed', 'safe'),
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
            'name' => Yii::t('user', 'name'),
            'email' => Yii::t('common', 'email'),
            'phone' => Yii::t('common', 'phone'),
            'created_time' => 'Created Time',
        );
    }

    function beforeSave()
    {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->name)
            $this->name = strip_tags($this->name);
        if ($this->isNewRecord) {
            $this->created_time = time();
        }
        return parent::beforeSave();
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
        $this->site_id = Yii::app()->controller->site_id;
        $criteria->compare('id', $this->id);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('created_time', $this->created_time);

        $criteria->order = 'created_time DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']),
                'pageVar' => ClaSite::PAGE_VAR,
            ),
        ));
    }

    /**
     * add rule: checking phone number
     * @param type $attribute
     * @param type $params
     */
    public function isPhone($attribute, $params)
    {
        if (!ClaRE::isPhoneNumber($this->$attribute))
            $this->addError($attribute, Yii::t('errors', 'phone_invalid'));
    }


    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Newsletters the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     *
     * @param type $attribute
     * @param type $params
     */
    public function checkEmailInsite($attribute, $params)
    {
        if ($this->isNewRecord || $this->$attribute != $this->oldMail)
            $site_id = $this->site_id;
        $record = $this->findByAttributes(array(
            'site_id' => $site_id,
            'email' => $this->$attribute,
        ));
        if ($record)
            $this->addError($attribute, Yii::t('errors', 'existinsite', array('{name}' => $this->$attribute)));
    }

    /**
     * Get all newsletters
     * @param type $options
     * @return array
     */
    public static function getAllNewsletter($options = array())
    {
        if (!isset($options['limit']))
            $options['limit'] = self::DEFAUTL_LIMIT;
        if (!isset($options[ClaSite::PAGE_VAR]))
            $options[ClaSite::PAGE_VAR] = 1;
        if (!(int)$options[ClaSite::PAGE_VAR])
            $options[ClaSite::PAGE_VAR] = 1;
        $select = '*';
        //
        $offset = ((int)$options[ClaSite::PAGE_VAR] - 1) * $options ['limit'];
        $siteid = Yii::app()->controller->site_id;
        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('newsletters'))
            ->where("site_id=$siteid")
            ->order('created_time DESC')
            ->limit($options['limit'], $offset)->queryAll();
        return $data;
        //
    }

}
