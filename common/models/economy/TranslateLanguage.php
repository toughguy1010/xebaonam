<?php

/**
 * This is the model class for table "translate_language".
 *
 * The followings are the available columns in table 'translate_language':
 * @property integer $id
 * @property string $from_lang
 * @property string $to_lang
 * @property integer $site_id
 * @property string $price
 * @property string $currency
 * @property bol status
 */
class TranslateLanguage extends ActiveRecord
{
    const UNIT_USD = 'USD'; // usd
    const UNIT_VND = 'VND'; // vnd
    const STANDARD = '1'; // vnd
    const BUSINESS = '2'; // vnd
    const ADVANCED = '3'; // vnd
    public static $_dataCurrency = array(self::UNIT_VND => self::UNIT_VND, self::UNIT_USD => self::UNIT_USD);
    public static $_options = array(self::STANDARD => 'STANDARD', self::BUSINESS => 'BUSINESS', self::UNIT_USD => 'ADVANCED');

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return ClaTable::getTable('translate_language');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('from_lang, to_lang', 'required'),
            array('id, site_id', 'numerical', 'integerOnly' => true),
            array('from_lang, to_lang', 'length', 'max' => 3),
            array('price, price_business, aff_percent', 'length', 'max' => 16),
            array('currency', 'length', 'max' => 20),
            array('from_lang', 'validateLang'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, from_lang, to_lang, site_id, price, currency, status, created_time, aff_percent', 'safe'),
        );
    }

    public function validateLang()
    {
        if (!$this->compareLang($this->from_lang, $this->to_lang)) {
            $this->addError('lang_not_same', Yii::t('translate', 'from_lang and to_lang not the same'));
        }
    }


    public function compareLang($from_lang, $to_lang)
    {
        if ($from_lang == $to_lang) {
            return false;
        }
        return true;
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
            'from_lang' => Yii::t('translate', 'from_lang'),
            'to_lang' => Yii::t('translate', 'to_lang'),
            'site_id' => 'Site',
            'price' => Yii::t('translate', 'price'),
            'currency' => Yii::t('translate', 'currency'),
            'status' => Yii::t('translate', 'status'),
            'price_business' => Yii::t('translate', 'price_business'),
            'aff_percent' => Yii::t('translate', 'aff_percent'),
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
        $criteria->compare('price', $this->price, true);
        $criteria->compare('currency', $this->currency, true);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('aff_percent', $this->aff_percent);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TranslateLanguage the static model class
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
            ->from(ClaTable::getTable('translate_language'))
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
            ->from(ClaTable::getTable('translate_language'))
            ->where('from_lang =:lang_from_key', array(':lang_from_key' => $lang_from_key))
            ->queryAll();
        foreach ($data as $lang) {
            $result[$lang['to_lang']] = ClaLanguage::getCountryName($lang['to_lang']);
        }
        return $result;
    }

    public static function getOptionsName($option_key)
    {
        return self::$_options[$option_key];
    }
}
