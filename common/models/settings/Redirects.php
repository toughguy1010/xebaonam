<?php

/**
 * This is the model class for table "redirects".
 *
 * The followings are the available columns in table 'redirects':
 * @property string $id
 * @property integer $user_id
 * @property string $site_id
 * @property string $from_url
 * @property string $to_url
 * @property string $created_time
 * @property string $updated_time
 */
class Redirects extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('redirects');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('from_url, to_url', 'filter', 'filter' => 'trim'),
            array('from_url, to_url', 'filter', 'filter' => 'strip_tags'),
            array('from_url, to_url', 'required'),
            array('user_id', 'numerical', 'integerOnly' => true),
            array('site_id, created_time, updated_time', 'length', 'max' => 11),
            array('from_url', 'length', 'max' => 250),
            array('to_url', 'length', 'max' => 255),
            array('to_url', 'isUrl',),
            array('from_url', 'isUnique', 'on' => 'create'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, site_id, from_url, to_url, created_time, updated_time', 'safe'),
        );
    }

    /**
     * add rule: from_url
     * @param type $attribute
     * @param type $params
     */
    public function isUnique($attribute, $params) {
        if ($this->$attribute) {
            if ($this->findByAttributes(array('from_url' => $this->$attribute, 'site_id' => Yii::app()->controller->site_id))) {
                $this->addError($attribute, Yii::t('errors', Yii::t('errors', 'exist', array('{attribute}' => $this->getAttributeLabel($attribute)))));
                return false;
            }
        }
        return true;
    }

    /**
     * add rule: to_url
     * @param type $attribute
     * @param type $params
     */
    public function isUrl($attribute, $params) {
        if ($this->$attribute) {
            if (!ClaRE::isUrl($this->$attribute)) {
                $this->addError($attribute, Yii::t('errors', Yii::t('errors', 'url_invalid')));
                return false;
            }
        }
        return true;
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
            'site_id' => 'Site',
            'from_url' => Yii::t('setting', 'redirect_from_url'),
            'to_url' => Yii::t('setting', 'redirect_to_url'),
            'created_time' => 'Created Time',
            'updated_time' => 'Update Time',
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
        if(!$this->site_id){
            $this->site_id = Yii::app()->controller->site_id;
        }
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('from_url', $this->from_url, true);
        $criteria->compare('to_url', $this->to_url, true);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('updated_time', $this->updated_time, true);
        $criteria->order = 'created_time DESC';
        $dataprovider = new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']),
                'pageVar' => ClaSite::PAGE_VAR,
            ),
        ));
        //
        return $dataprovider;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Redirects the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = $this->updated_time = time();
            $this->user_id = Yii::app()->user->id;
        } else {
            $this->updated_time = time();
        }
        return parent::beforeSave();
    }

    /**
     * check current url 
     */
    static function redirect301() {
        $fromUrl = Yii::app()->request->url;
        $redirect = Yii::app()->db->createCommand()
                ->select('*')
                ->from(ClaTable::getTable('redirects'))
                ->where('from_url=:from_url AND site_id=:site_id', array(':from_url' => $fromUrl, ':site_id' => (int) Yii::app()->siteinfo['site_id']))
                ->queryRow();
        if ($redirect) {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: " . $redirect['to_url']);
            Yii::app()->end();
        }
    }

}
