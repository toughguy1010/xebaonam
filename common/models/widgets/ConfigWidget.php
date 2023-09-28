<?php

/**
 * Description of ConfigWidget
 *
 * @author minhbn
 */
class ConfigWidget extends FormModel {

    const time_cache_default = 900;

    //
    public $config_name = ''; // Tên của loại config như banner, menu...
    public $page_widget_id = 0; // page widget id
    public $widget_title = ''; // widget title để hiển thị trên widget header 
    public $showallpage = Widgets::WIDGET_SHOWALL_FALSE; // show all page?
    public $show_wiget_title = self::STAtUS_FALSE; // có hiển thị widget title không?
    public $help_text = ''; //
    public $config_data = array();
    public $isnew = true;
    public $table = '';

    public function __construct($scenario = '', $options = array()) {
        if (isset($options['page_widget_id']))
            $this->page_widget_id = $options['page_widget_id'];
        $this->table = ClaTable::getTable('pagewidgetconfig');
        $this->loadDefaultConfig();
        $this->loadConfig();
        return parent::__construct($scenario);
    }

    public function rules() {
        return array(
            array('widget_title', 'required'),
            array('showallpage, page_widget_id,widget_title,show_wiget_title, help_text', 'safe'),
        );
    }

    // hàm abstract
    public function loadDefaultConfig() {
        
    }

    public function loadConfig() {
        $this->attributes = $this->loadConfigInDB();
    }

    /**
     * Load những cấu hình lưu trong db
     * @param type $page_widget_id
     * @return boolean
     */
    public function loadConfigInDB($page_widget_id = 0) {
        $page_widget_id = (int) $page_widget_id;
        if (!$page_widget_id)
            $page_widget_id = $this->page_widget_id;
        //
        if (!$page_widget_id)
            return array();
        $data = $this->getCacheConfig($page_widget_id);
        if (!$data) {
            //Mỗi một widget có 1 config
            $data = Yii::app()->db->createCommand()->select()
                    ->from($this->table)
                    ->where('page_widget_id=:page_widget_id AND site_id=:site_id', array(':page_widget_id' => $page_widget_id, ':site_id' => Yii::app()->controller->site_id))
                    ->queryRow();
            if (!$data) {
                return $data;
            }
            $this->setCacheConfig($page_widget_id, $data);
        }
        $this->isnew = false;
        $config_data = json_decode($data['config_data'], true);
        return $config_data;
    }

    public function save($runValidation = true, $attributes = null) {
        if (!$runValidation || $this->validate($attributes))
            return $this->getIsNewRecord() ? $this->insert($attributes) : $this->update($attributes);
        else
            return false;
    }

    public function insert($attributes = null) {
        if ($this->beforeSave()) {
            $builder = $this->getCommandBuilder();
            if (!$attributes)
                $attributes = $this->buildConfigAttributes();
            $command = $builder->createInsertCommand($this->table, $attributes);
            if ($command->execute()) {
                $this->page_widget_id = $builder->getLastInsertID($this->table);
                $this->afterSave();
                $this->isnew = false;
                return true;
            }
        }
        return false;
    }

    public function update($attributes = null) {
        if ($this->getIsNewRecord())
            throw new CDbException(Yii::t('yii', 'The active record cannot be updated because it is new.'));
        if ($this->beforeSave()) {
            $builder = $this->getCommandBuilder();
            if (!$attributes)
                $attributes = $this->buildConfigAttributes();
            $command = $builder->createUpdateCommand($this->table, $attributes, new CDbCriteria(array(
                "condition" => "page_widget_id = :page_widget_id",
                "params" => array(
                    "page_widget_id" => $this->page_widget_id,
                ))
                    )
            );
            if ($command->execute()) {
                $this->afterSave();
                return true;
            }
        } else
            return false;
    }

    function buildConfigAttributes() {
        return array_merge(array('site_id' => Yii::app()->controller->site_id, 'page_widget_id' => $this->page_widget_id), $this->getIsNewRecord() ? array('created_time' => time(), 'modified_time' => time(),) : array('modified_time' => time()));
    }

    function getCacheConfig($page_widget_id = '') {
        $key = $this->getCacheKey($page_widget_id);
        $data = Yii::app()->cache->get($key);
        if (!$data) {
            $data = array();
        }
        return $data;
    }

    function setCacheConfig($page_widget_id = '', $data = array()) {
        $expire = 0;
        $expire = ((int) $expire == 0) ? $this->getExpireTimeDefault() : (int) $expire;
        $key = '';
        if (!$key) {
            $key = $this->getCacheKey($page_widget_id);
        }
        return Yii::app()->cache->set($key, $data, $expire);
    }

    function deleteCacheConfig($page_widget_id = '') {
        $key = $this->getCacheKey($page_widget_id);
        return Yii::app()->cache->delete($key);
    }

    public function getCacheKey($page_widget_id = '') {
        //
        $site_id = Yii::app()->controller->site_id;
        $key = base64_encode($page_widget_id . ':' . $site_id);
        return $key;
    }

    /**
     * 
     * @return type
     */
    function getExpireTimeDefault() {
        return self::time_cache_default;
    }

    function getIsNewRecord() {
        return $this->isnew;
    }

    public function getCommandBuilder() {
        return $this->getDbConnection()->getSchema()->getCommandBuilder();
    }

    //
    public function getDbConnection() {
        $db = Yii::app()->getDb();
        return $db;
    }

    /**
     * trả về khóa chính của đối tượng
     * @return string
     */
    public function getPrimaryKey() {
        return '';
    }

    /**
     * trả về tên table mà đói tượng config trỏ đến
     * @return string
     */
    public function getTableName() {
        return '';
    }

    //
    public function beforeSave() {
        return true;
    }

    //
    public function afterSave() {
        $this->deleteCacheConfig($this->page_widget_id);
    }

}
