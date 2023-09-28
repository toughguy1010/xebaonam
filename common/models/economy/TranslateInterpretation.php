<?php

/**
 * This is the model class for table "translate_interpretation".
 *
 * The followings are the available columns in table 'translate_interpretation':
 * @property integer $id
 * @property string $from_lang
 * @property string $to_lang
 * @property integer $site_id
 * @property string $default
 * @property integer $status
 * @property integer $created_time
 * @property string $currency
 * @property string $aff_percent
 * @property string $escort_negotiation_inter
 * @property string $consecutive_inter
 * @property string $simultaneous_inter
 */
class TranslateInterpretation extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'translate_interpretation';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('country, from_lang, to_lang', 'required'),
            array('site_id, status, created_time', 'numerical', 'integerOnly' => true),
            array('from_lang, to_lang, currency', 'length', 'max' => 3),
            array('default', 'length', 'max' => 255),
            array('aff_percent', 'length', 'max' => 5),
            array('escort_negotiation_inter_price, consecutive_inter_price, simultaneous_inter_price', 'length', 'max' => 16),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, , site_id, default, status, created_time, currency, aff_percent, escort_negotiation_inter_price, consecutive_inter_price, simultaneous_inter_price, country', 'safe'),
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
            'id' => 'ID',
            'site_id' => 'Site',
            'default' => 'Default',
            'created_time' => 'Created Time',
            'escort_negotiation_inter_price' => 'Escort negotiation Price',
            'consecutive_inter_price' => 'Consecutive Inter Price',
            'simultaneous_inter_price' => 'Simultaneous Inter Price',
            'from_lang' => Yii::t('translate', 'from_lang'),
            'to_lang' => Yii::t('translate', 'to_lang'),
            'price' => Yii::t('translate', 'price'),
            'currency' => Yii::t('translate', 'currency'),
            'status' => Yii::t('translate', 'status'),
            'price_business' => Yii::t('translate', 'price_business'),
            'aff_percent' => Yii::t('translate', 'aff_percent'),
            'country' => Yii::t('common', 'country'),
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
        $criteria->compare('from_lang', $this->from_lang, true);
        $criteria->compare('to_lang', $this->to_lang, true);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('default', $this->default, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('currency', $this->currency, true);
        $criteria->compare('aff_percent', $this->aff_percent);
        $criteria->compare('escort_negotiation_inter_price', $this->escort_negotiation_inter_price, true);
        $criteria->compare('consecutive_inter_price', $this->consecutive_inter_price, true);
        $criteria->compare('simultaneous_inter_price', $this->simultaneous_inter_price, true);
        $criteria->compare('country', $this->country, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']),
                //'pageSize' => $pageSize,
                'pageVar' => 'page',
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TranslateInterpretation the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function getAllLanguageId()
    {
        $result = array();
        $site_id = Yii::app()->controller->site_id;
        $data = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('translate_language'))
            ->where('site_id=' . $site_id)
            ->queryAll();
        foreach ($data as $lang) {
            $result[$lang['id']] = ClaLanguage::getCountryName($lang['from_lang']) . ' -> ' . ClaLanguage::getCountryName($lang['to_lang']);
        }
        return $result;
    }

    public static function getAllLanguageTranslateFrom()
    {
        $result = array();
        $site_id = Yii::app()->controller->site_id;
        $data = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('translate_interpretation'))
            ->where('site_id=' . $site_id)
            ->queryAll();
        //
        foreach ($data as $lang) {
            $result[$lang['from_lang']] = ClaLanguage::getCountryName($lang['from_lang']);
        }
        //
        return $result;
    }

    public static function getAllLanguageTranslateTo($lang_from_key)
    {
        $result = array();
        $site_id = Yii::app()->controller->site_id;
        $data = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('translate_interpretation'))
            ->where('from_lang =:lang_from_key', array(':lang_from_key' => $lang_from_key))
            ->queryAll();
        foreach ($data as $lang) {
            $result[$lang['to_lang']] = ClaLanguage::getCountryName($lang['to_lang']);
        }
        return $result;
    }

    public static function getLanguagePairByCountry($lang_key)
    {
        $result = array();
        $site_id = Yii::app()->controller->site_id;
        $data = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('translate_interpretation'))
            ->where('country =:country', array(':country' => $lang_key))
            ->queryAll();
//        foreach ($data as $lang) {
//            $result[$lang['id']] = ClaLanguage::getCountryName($lang['from_lang']) . ' <-> ' . ClaLanguage::getCountryName($lang['to_lang']);
//        }
        return $data;
    }

}
