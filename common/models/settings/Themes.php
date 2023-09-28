<?php

/**
 * This is the model class for table "themes".
 *
 * The followings are the available columns in table 'themes':
 * @property string $theme_id
 * @property string $theme_name
 * @property integer $theme_type
 * @property integer $created_time
 * @property string $previewlink
 * @property string $basepath
 * @property string $order
 */
class Themes extends ActiveRecord {

    const DEFAULT_LIMIT = 10;
    const STATUS_UNAVAILABLE = 0; // Chưa sẵn sàng để đưa ra cho người dùng
    const STATUS_AVAILABLE = 1; // Đã sẵn sàng và có thể buil từ theme này
    const STATUS_DEMO = 2;  // Chỉ có giao diện demo và khách hàng phải đăng ký để thiết kế theo theme này
    const ID_AUTO_DEFAULT = 100;

    public $autoIncreament = 0;
    public $theme_src = null;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'themes';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('theme_id, theme_name', 'required'),
            array('created_time, order', 'numerical', 'integerOnly' => true, 'min' => 0),
            array('theme_id', 'length', 'max' => 100),
            array('theme_name', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('theme_id, theme_name, theme_type, created_time, description, category_id, category_track, avatar_path, avatar_name, avatar_id, status, previewlink, basepath, order', 'safe'),
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
            'theme_id' => Yii::t('theme', 'theme_id'),
            'theme_name' => Yii::t('theme', 'theme_name'),
            'theme_type' => Yii::t('theme', 'theme_type'),
            'category_id' => Yii::t('common', 'category'),
            'created_time' => 'Created Time',
            'status' => Yii::t('common', 'status'),
            'avatar_id' => Yii::t('common', 'picture'),
            'previewlink' => Yii::t('theme', 'previewlink'),
            'description' => Yii::t('common', 'description'),
            'theme_src' => Yii::t('theme', 'theme_src'),
            'order' => Yii::t('common', 'order'),
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

        $criteria->compare('theme_id', $this->theme_id, true);
        $criteria->compare('theme_name', $this->theme_name, true);
        $criteria->compare('theme_type', $this->theme_type, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->order = '`order`, created_time DESC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 20,
            ),
        ));
    }

    function beforeSave() {
        if ($this->isNewRecord)
            $this->created_time = time();
        return parent::beforeSave();
    }

    function afterSave() {
        if ($this->isNewRecord) {
            $autoId = (int) $this->autoIncreament + 1;
            $this->setIdAutoIncrement($autoId);
        }
        parent::afterSave();
    }

    function afterDelete() {
        //$this->deleteThemeFolder();
        parent::afterDelete();
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Themes the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Cho phép những loại file nào
     * @return type
     */
    static function allowExtensions() {
        return array(
            'application/x-bzip' => 'application/x-bzip',
            'application/x-bzip2' => 'application/x-bzip2',
            'application/x-zip' => 'application/x-zip',
            'application/x-zip-compressed' => 'application/x-zip-compressed',
            'application/zip' => 'application/zip',
        );
    }

    /**
     * theme status
     * @return type
     */
    static function getThemeStatus() {
        return array(
            self::STATUS_UNAVAILABLE => Yii::t('theme', 'status_unavailable'),
            self::STATUS_AVAILABLE => Yii::t('theme', 'status_available'),
            self::STATUS_DEMO => Yii::t('theme', 'status_demo'),
        );
    }

    /**
     * trả về mảng các key của menu bên trái cho admin
     * @return type
     */
    static function getMenuKeyArr() {
        $menus = array(
            'content' => array(
                'title' => Yii::t('menu', 'left_module_content'),
                'items' => array(
                    'news.index' => array(
                        'title' => Yii::t('news', 'news_manager'),
                    ),
                    'newscategory.index' => array(
                        'title' => Yii::t('news', 'news_category'),
                    ),
                    'categorypage.index' => array(
                        'title' => Yii::t('categorypage', 'categorypage_manager'),
                    ),
                ),
            ),
            'economy' => array(
                'title' => Yii::t('menu', 'left_module_product'),
                'items' => array(
                    'product.index' => array(
                        'title' => Yii::t('product', 'product_manager'),
                    ),
                    'productcategory.index' => array(
                        'title' => Yii::t('product', 'product_category'),
                    ),
                    'product.create' => array(
                        'title' => Yii::t('product', 'product_create'),
                    ),
                ),
            ),
            'banner' => array(
                'title' => Yii::t('banner', 'banner'),
                'items' => array(
                    'banner.index' => array(
                        'title' => Yii::t('banner', 'banner_manager'),
                    ),
                    'bannergroup.index' => array(
                        'title' => Yii::t('banner', 'banner_group_manager'),
                    ),
                ),
            ),
            'media' => array(
                'title' => Yii::t('menu', 'left_module_media'),
                'items' => array(
                    'album.index' => array(
                        'title' => Yii::t('album', 'album_manager'),
                    ),
                    'video.index' => array(
                        'title' => Yii::t('video', 'video_manager'),
                    ),
                    'folder.index' => array(
                        'title' => Yii::t('file', 'folder_manager'),
                    ),
                    'file.all' => array(
                        'title' => Yii::t('file', 'file_manager'),
                    ),
                ),
            ),
            'interface' => array(
                'title' => Yii::t('common', 'interface'),
                'items' => array(
                    'menugroup.index' => array(
                        'title' => Yii::t('menu', 'menu_manager'),
                    ),
                    'sitesettings.contact' => array(
                        'title' => Yii::t('common', 'setting_contact'),
                    ),
                    'sitesettings.footersetting' => array(
                        'title' => Yii::t('common', 'setting_footer'),
                    ),
                ),
            ),
            'setting' => array(
                'title' => Yii::t('common', 'setting'),
                'items' => array(
                    'setting.index' => array(
                        'title' => Yii::t('common', 'setting_site'),
                    ),
                    'mailsettings.contact' => array(
                        'title' => Yii::t('common', 'setting_mail'),
                    ),
                    'setting.domainsetting' => array(
                        'title' => Yii::t('domain', 'domain_manager'),
                    ),
                    'themesetting.index' => array(
                        'title' => Yii::t('theme', 'theme_manager'),
                    ),
                ),
            ),
            'custom' => array(
                'title' => Yii::t('common', 'customer'),
                'items' => array(
                    'customform.statistic' => array(
                        'title' => Yii::t('common', 'contact'),
                    ),
                ),
            ),
            'widget' => array(
                'title' => Yii::t('widget', 'left_module_widgets'),
                'items' => array(
                    'widget.index' => array(
                        'title' => Yii::t('widget', 'widget_manager'),
                    ),
                ),
            ),
        );

        return $menus;
    }

    /**
     * kiểm tra xem theme này cho hiển thị những menu gì
     */
    public static function checkShowMenu($module = '', $key = null, $returndefault = true) {
        if (!$module)
            return false;
        $menu_rules = Yii::app()->themeinfo['rules'];
        if (isset($menu_rules) && count($menu_rules)) {
            //Kiểm tra hiển thị module hay không
            if (!$key) {
                if (isset($menu_rules[$module]))
                    return true;
            }else {
                if (isset($menu_rules[$module]) && isset($menu_rules[$module][$key]))
                    return true;
            }
            return false;
        }
        return $returndefault;
    }

    /**
     * get Images of theme
     * @return array
     */
    public function getImages() {
        $result = array();
        if ($this->isNewRecord)
            return $result;
        $result = Yii::app()->db->createCommand()->select()
                ->from(Yii::app()->params['tables']['themeimage'])
                ->where('theme_id=:theme_id AND site_id=:site_id', array(':theme_id' => $this->theme_id, ':site_id' => Yii::app()->controller->site_id))
                ->queryAll();

        return $result;
    }

    /**
     * get the first image of theme
     * @return array
     */
    public function getFirstImage() {
        $result = array();
        if ($this->isNewRecord)
            return $result;
        $result = Yii::app()->db->createCommand()->select()
                ->from(Yii::app()->params['tables']['themeimage'])
                ->where('theme_id=:theme_id AND site_id=:site_id', array(':theme_id' => $this->theme_id, ':site_id' => Yii::app()->controller->site_id))
                ->limit(1)
                ->queryRow();

        return $result;
    }

    /**
     * Return themes found in database
     * @param type $options
     * @return array
     */
    public static function getThemes($options = array()) {
        $condition = 'status<>' . self::STATUS_UNAVAILABLE;
        $params = array();
        //
        if (isset($options['cat_id']) && (int) $options['cat_id']) {
            
            $condition .= " AND MATCH (category_track) AGAINST ('" . (int)$options['cat_id'] . "' IN BOOLEAN MODE)";
            
//            $condition.= ' AND category_id=:category_id';
//            $params[':category_id'] = $options['cat_id'];
        }
        //
        if (isset($options['type']) && $options['type']) {
            $condition .= ' AND theme_type=:theme_type';
            $params[':theme_type'] = $options['type'];
        }
        if(isset($options['keyword']) && $options['keyword']){
            $keyword = self::processKeyWord($options['keyword']);
            $condition.= " AND (theme_name LIKE $keyword OR description LIKE $keyword)";
        }
        //
        $limit = isset($options['limit']) ? (int) $options['limit'] : self::DEFAULT_LIMIT;
        $offset = (isset($options[ClaSite::PAGE_VAR]) ? ( (int) $options[ClaSite::PAGE_VAR] - 1) : 0) * $limit;
        //
        $dbcommand = Yii::app()->db->createCommand()->select('*')
                ->from(Yii::app()->params['tables']['theme'])
                ->where($condition, $params)
                ->order('status,created_time DESC')
                ->limit($limit, $offset);
        //
        $data = $dbcommand->queryAll();
        //
        return $data;
    }

    /**
     * Return number of themes found in database
     * @param type $options
     * @return Interger
     */
    public static function countThemes($options = array()) {
        $condition = 'status<>' . self::STATUS_UNAVAILABLE;
        $params = array();
        //
        if (isset($options['cat_id']) && (int) $options['cat_id']) {
            $condition .= " AND MATCH (category_track) AGAINST ('" . (int)$options['cat_id'] . "' IN BOOLEAN MODE)";
//            $condition.= ' AND category_id=:category_id';
//            $params[':category_id'] = $options['cat_id'];
        }
        //
        if (isset($options['type']) && $options['type']) {
            $condition .= ' AND theme_type=:theme_type';
            $params[':theme_type'] = $options['type'];
        }
        //
         if(isset($options['keyword']) && $options['keyword']){
            $keyword = self::processKeyWord($options['keyword']);
            $condition.= " AND (theme_name LIKE $keyword OR description LIKE $keyword)";
        }
        //
        $count = Yii::app()->db->createCommand()->select('count(*)')
                ->from(Yii::app()->params['tables']['theme'])
                ->where($condition, $params)
                ->queryScalar();
        //
        return $count;
        //
    }

    function getThemeId() {
        if (isset($this->theme_name) && isset($this->theme_type)) {
            $idauto = $this->getIdAutoIncrement();
            $prefix = $this->getThemeTypePrefix();
            $this->autoIncreament = $idauto;
            //
            return $prefix . $idauto;
        }
        return '';
    }

    /**
     * get root path of themes
     * @return type
     */
    function getThemeRootPath() {
        return Yii::getPathOfAlias('root') . '/themes';
    }

    /**
     * get base path of theme
     * @return string
     */
    function getThemeBasePath() {
        if (isset($this->theme_name) && isset($this->theme_type)) {
            $sitetypealias = ClaSite::getSiteTypeAlias();
            $themetypename = isset($sitetypealias[$this->theme_type]) ? $sitetypealias[$this->theme_type] : '';
            if ($themetypename) {
                $path = $themetypename . '/' . $this->theme_id;
                return $path;
            }
        }
        return '';
    }

    /**
     * return full path of theme
     * @return string
     */
    function getThemePath() {
        $basepath = $this->getThemeBasePath();
        $rootpath = $this->getThemeRootPath();
        if ($basepath && $rootpath) {
            $path = $rootpath . '/' . $basepath;
            return $path;
        }
        return '';
    }

    /**
     * return path of default data for theme
     * @return string
     */
    function getPathOfDefaultData() {
        $basepath = $this->getThemePath();
        if ($basepath) {
            $path = $basepath . '/data.sql';
            return $path;
        }
        return '';
    }

    /**
     * return AutoIncrement
     * @return type
     */
    function getIdAutoIncrement() {
        $file = $this->getIdAutoIncrementFile();
        if (file_exists($file)) {
            $value = require $file;
            $value = (int) $value;
            if ($value)
                return $value;
        }
        return self::ID_AUTO_DEFAULT;
    }

    /**
     * set Id for Auto
     * @param type $id
     * @return type
     */
    function setIdAutoIncrement($id) {
        $id = (int) $id;
        return $this->writeAutoIncrementFileData($id);
    }

    /**
     * wire data
     */
    function writeAutoIncrementFileData($data) {
        $data = '' . $data;
        //
        $file = $this->getIdAutoIncrementFile();
        $str = "<?php return " . $data . ';';
        if (file_put_contents($file, $str)) {
            @chmod($file, 0777);
            return true;
        }
        //
        return false;
    }

    /**
     * return auto increment file name
     * @return type
     */
    function getIdAutoIncrementFile() {
        $rootPath = $this->getThemeRootPath();
        return $rootPath . '/idauto.php';
    }

    /**
     * create theme folder
     * @return type
     */
    function createThemeFolder() {
        $path = $this->getThemePath();
        $res = false;
        if (!is_dir($path)) {
            $res = @mkdir($path, 0775, true);
        }
        return $res;
    }

    /**
     * delete theme folder
     * @return type
     */
    function deleteThemeFolder() {
        $path = $this->getThemePath();
        $res = true;
        if (is_dir($path)) {
            $res = @rmdir($path);
        }
        return $res;
    }

    /**
     * extract file to folder
     * @param type $file ($_FILES)
     */
    function extractFile($file) {
        if (!$file['tmp_name'])
            return false;
        //
        $folder = $this->getThemePath();
        //
        $zip = new ZipArchive();
        $zip->open($file['tmp_name']);
        $zip->extractTo($folder);
        $zip->close();
        return true;
    }

    /**
     * return prefix
     * @return string
     */
    function getThemeTypePrefix() {
        switch ($this->theme_type) {
            case ClaSite::SITE_TYPE_NEWS: return 'w3nn';
                break;
            case ClaSite::SITE_TYPE_ECONOMY: return 'w3ne';
                break;
            case ClaSite::SITE_TYPE_INTRODUCE: return 'w3ni';
                break;
        }

        return 'w3n';
    }

    /**
     * 
     * @param type $options
     */
    static function getThemeInRelaction($theme_id = '', $options = array()) {
        if (!$theme_id)
            return array();
        //
        $created_time = (int) $options['created_time'];
        //
        $condition = 'status<>' . self::STATUS_UNAVAILABLE;
        $params = array();
        $condition.=' AND theme_id<>:id';
        $params[':id'] = $theme_id;
        //
        if (isset($options['cat_id']) && (int) $options['cat_id']) {
            $condition.= ' AND category_id=:category_id';
            $params[':category_id'] = $options['cat_id'];
        }
        //
        $limit = isset($options['limit']) ? (int) $options['limit'] : self::DEFAULT_LIMIT;
        //
        $dbcommand = Yii::app()->db->createCommand()->select('*')
                ->from(Yii::app()->params['tables']['theme'])
                ->where($condition, $params)
                ->order("ABS($created_time - created_time)")
                ->limit($limit);
        //
        $data = $dbcommand->queryAll();
        //
        return $data;
    }

    /**
     * Kiểm tra xem theme này đã có site nào dùng hay chưa, nếu chưa có site nào dùng thì có thể xóa ko thì ko dc xóa
     * @param type $id
     */
    static function isUsing($id) {
        $site = Yii::app()->db->createCommand()->select()->from(Yii::app()->params['tables']['site'])
                        ->where('site_skin=:skin', array(':skin' => $id))->limit(1)->queryRow();
        if ($site)
            return true;
        return false;
    }
    
    /**
     * process keyword
     * 
     * @param type $keyword
     * @return type
     */
    static function processKeyWord($keyword = '') {
        $return = '';
        $keyword = trim($keyword);
        if ($keyword) {
            $keywords = explode(' ', $keyword);
            if ($keywords) {
                $return = implode('%', $keywords);
                $return = '%' . $return . '%';
                $return = ClaGenerate::quoteValue($return);
            }
        }
        return $return;
    }

}
