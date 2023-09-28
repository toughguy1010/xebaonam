<?php

/**
 * This is the model class for table "page_widget_config".
 *
 * The followings are the available columns in table 'page_widget_config':
 * @property integer $id
 * @property integer $page_widget_id
 * @property integer $site_id
 * @property integer $user_id
 * @property string $config_data
 * @property integer $created_time
 * @property integer $modified_time
 */
class PageWidgetConfig extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('page_widget_config');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('page_widget_id, site_id, user_id', 'required'),
            array('page_widget_id, site_id, user_id, created_time, modified_time', 'numerical', 'integerOnly' => true),
            array('config_data', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, page_widget_id, site_id, user_id, config_data, created_time, modified_time', 'safe', 'on' => 'search'),
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
            'page_widget_id' => 'Page Widget',
            'site_id' => 'Site',
            'user_id' => 'User',
            'config_data' => 'Config Data',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('page_widget_id', $this->page_widget_id);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('config_data', $this->config_data, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PageWidgetConfig the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * get all page widget config
     */
    static function getAllPageWidgetConfigs($options = array()) {
        //
        $site_id = isset($options['site_id']) ? $options['site_id'] : Yii::app()->controller->site_id;
        //
        $data = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('pagewidgetconfig'))
                ->where("site_id=$site_id")
                ->queryAll();
        return $data;
    }

    /**
     * Chuẩn bị dữ liệu config để build sql
     * @param type $pagewidgetconfig
     * @param type $pagewidget
     */
    static function prepareConfig($pagewidgetconfig = array(), $pagewidget = array()) {
        $widgetname = 'config_' . $pagewidget['widget_id'];
        $checkConfig = false;
        if ($pagewidget['widget_id'] != '' && class_exists($widgetname)) {
            $widget = new $widgetname;
            $primaryKey = $widget->getPrimaryKey();
            $tableName = $widget->getTableName();
            if ($primaryKey && $tableName) {
                $configData = json_decode($pagewidgetconfig['config_data'], true);
                if ($configData) {
                    //
                    $mysql_variable = $tableName . $configData[$primaryKey];
                    $configData[$primaryKey] = 'msql_variable';
                    //
                    $configData = json_encode($configData, JSON_UNESCAPED_UNICODE);
                    $temp = explode('"msql_variable"', $configData);
                    if(isset($temp[1])){
                        $temp[1] = str_replace(array('"\\','\\"'),array('"\\\\','\\\\"'), $temp[1]);
                    }
                    $configData = "CONCAT('" . implode("',@" . $mysql_variable . ",'", $temp) . "')";
                    // Tiếng việt trong mysql
                    $configData = str_replace('\u', '\\u', $configData);
                    $pagewidgetconfig['config_data'] = $configData;
                    $checkConfig = true;
                }
            }
        }
        if (!$checkConfig)
            $pagewidgetconfig['config_data'] = ClaGenerate::quoteValue($pagewidgetconfig['config_data']);
        return $pagewidgetconfig;
    }
    
    function afterSave() {
        Widgets::deleteCache(); // Xoa cache widget
        $ConfigWidget = new ConfigWidget();
        $ConfigWidget->deleteCacheConfig($this->page_widget_id);
        parent::afterSave();
    }

    function afterDelete() {
        Widgets::deleteCache(); // Xoa cache widget
        parent::afterDelete();
    }

}
