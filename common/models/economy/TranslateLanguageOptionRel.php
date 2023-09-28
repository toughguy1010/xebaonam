<?php

/**
 * This is the model class for table "translate_language_option_rel".
 *
 * The followings are the available columns in table 'translate_language_option_rel':
 * @property integer $id
 * @property integer $lang_id
 * @property integer $option_id
 * @property string $price
 * @property string $currency
 * @property integer $status
 * @property integer $created_time
 * @property integer $site_id
 */
class TranslateLanguageOptionRel extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'translate_language_option_rel';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('lang_id, option_id', 'required'),
            array('lang_id, option_id, status, created_time, site_id', 'numerical', 'integerOnly'=>true),
            array('price', 'length', 'max'=>16),
            array('currency', 'length', 'max'=>20),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, lang_id, option_id, price, currency, status, created_time, site_id', 'safe', 'on'=>'search'),
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
            'lang_id' =>Yii::t('translate','lang'),
            'option_id' => Yii::t('translate','option'),
            'price' => Yii::t('translate','price'),
            'currency' =>Yii::t('translate','currency'),
            'status' => Yii::t('translate','status'),
            'created_time' =>  Yii::t('translate','created_time'),
            'site_id' => 'Site',
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

        $criteria->compare('id',$this->id);
        $criteria->compare('lang_id',$this->lang_id);
        $criteria->compare('option_id',$this->option_id);
        $criteria->compare('price',$this->price,true);
        $criteria->compare('currency',$this->currency,true);
        $criteria->compare('status',$this->status);
        $criteria->compare('created_time',$this->created_time);
        $criteria->compare('site_id',$this->site_id);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TranslateLanguageOptionRel the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
} 