<?php

/**
 * This is the model class for table "page_widgets".
 *
 * The followings are the available columns in table 'page_widgets':
 * @property integer $page_widget_id
 * @property integer $site_id
 * @property integer $user_id
 * @property integer $position
 * @property string $page_key
 * @property integer $widget_type
 * @property string $widget_id
 * @property integer $created_time
 * @property integer $showallpage
 * @property integer $worder
 */
class PageWidgets extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('page_widgets');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('site_id, position, page_key, widget_id, created_time', 'required'),
            array('site_id, user_id, position, widget_type, created_time, showallpage', 'numerical', 'integerOnly' => true),
            array('page_key, widget_id', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('page_widget_id, site_id, user_id, position, page_key, widget_type, widget_id, created_time, widget_title, showallpage,worder', 'safe', 'on' => 'search'),
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
            'page_widget_id' => 'Page Widget',
            'site_id' => 'Site',
            'user_id' => 'User',
            'position' => 'Position',
            'page_key' => 'Page Key',
            'widget_type' => 'Widget Type',
            'widget_id' => 'Widget',
            'created_time' => 'Created Time',
            'showallpage' => 'Showallpage',
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

        $criteria->compare('page_widget_id', $this->page_widget_id);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('position', $this->position);
        $criteria->compare('page_key', $this->page_key, true);
        $criteria->compare('widget_type', $this->widget_type);
        $criteria->compare('widget_id', $this->widget_id, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('showallpage', $this->showallpage);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PageWidgets the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    function afterSave() {
        Widgets::deleteCache();
        parent::afterSave();
    }

    /**
     * Sau khi xóa widget thì xóa các config của nó
     */
    function afterDelete() {
        Widgets::deleteCache();
        PageWidgetConfig::model()->deleteAllByAttributes(array('page_widget_id' => $this->page_widget_id));
    }

    /**
     * get all page widget config
     */
    static function getAllPageWidget($options = array()) {
        //
        $site_id = isset($options['site_id']) ? $options['site_id'] : 0;
        //
        $data = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('page_widgets'))
            ->where("site_id=$site_id")
            ->queryAll();
        return $data;
    }

}
