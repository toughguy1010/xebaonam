<?php

/**
 * This is the model class for table "trades".
 *
 * The followings are the available columns in table 'trades':
 * @property integer $trade_id
 * @property string $trade_name
 * @property integer $group_id
 * @property integer $count_news
 * @property string $group_name
 */
class Trades extends ActiveRecordC {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'trades';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('group_id, count_news', 'numerical', 'integerOnly' => true),
            array('trade_name, group_name', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('trade_id, trade_name, group_id, count_news, group_name', 'safe', 'on' => 'search'),
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
            'trade_id' => 'Trade',
            'trade_name' => 'Trade Name',
            'group_id' => 'Group',
            'count_news' => 'Count News',
            'group_name' => 'Group Name',
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

        $criteria->compare('trade_id', $this->trade_id);
        $criteria->compare('trade_name', $this->trade_name, true);
        $criteria->compare('group_id', $this->group_id);
        $criteria->compare('count_news', $this->count_news);
        $criteria->compare('group_name', $this->group_name, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Trades the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * return trade array
     */
    static function getTradeArr() {
        $trades = Yii::app()->db->createCommand()->select()
                ->from(Yii::app()->params['tables']['trade'])
                ->where('site_id ='.Yii::app()->controller->site_id)
                ->queryAll();
        $trades = $trades ? $trades :  Yii::app()->db->createCommand()->select()
                ->from(Yii::app()->params['tables']['trade'])
                ->where('site_id IS NULL')
                ->queryAll();

        $returns = array();
        foreach ($trades as $trade) {
            $returns[$trade['trade_id']] = $trade['trade_name'];
        }
        //
        return $returns;
    }

}
