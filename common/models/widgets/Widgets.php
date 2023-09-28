<?php

/**
 * This is the model class for table "widgets".
 *
 * The followings are the available columns in table 'widgets':
 * @property integer $widget_id
 * @property string $widget_key
 * @property string $widget_name
 * @property string $widget_title
 * @property integer $widget_status
 * @property string $widget_template
 * @property integer $widget_right
 * @property string $alias
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $order
 *
 */
class Widgets extends ActiveRecord {

    const POS_LEFT = 1;
    const POS_RIGHT = 2;
    const POS_LEFT_OUT = 6; // Ngoài layout bên trái
    const POS_RIGHT_OUT = 8; // Ngoài layout bên phải
    const POS_CENTER = 5;
    const POS_CENTER_BOTTOM = 9; // Ở giữa center và bottom
    const POS_CENTER_BLOCK1 = 41;
    const POS_CENTER_BLOCK2 = 42;
    const POS_CENTER_BLOCK3 = 43;
    const POS_CENTER_BLOCK4 = 44;
    const POS_CENTER_BLOCK5 = 45;
    const POS_CENTER_BLOCK6 = 46;
    const POS_CENTER_BLOCK7 = 47;
    const POS_CENTER_BLOCK8 = 48;
    const POS_CENTER_BLOCK9 = 49;
    const POS_CENTER_BLOCK10 = 50;
    const POS_CENTER_BLOCK11 = 51;
    const POS_CENTER_BLOCK12 = 52;
    const POS_CENTER_BLOCK13 = 53;
    const POS_CENTER_BLOCK14 = 54;
    const POS_CENTER_BLOCK15 = 55;
    const POS_CENTER_BLOCK16 = 56;
    const POS_CENTER_BLOCK17 = 57;
    const POS_CENTER_BLOCK18 = 58;
    const POS_CENTER_BLOCK19 = 59;
    const POS_CENTER_BLOCK20 = 60;
    const POS_BEGIN_CONTENT = 11;
    const POS_MAIN_CONTENT = 1101;
    const POS_HEADER = 3;
    const POS_HEADER_BOTTOM = 31;
    const POS_HEADER_RIGHT = 12;
    const POS_HEADER_LEFT = 13;
    const POS_FOOTER = 4;
    const POS_FOOTER_BLOCK1 = 14;
    const POS_FOOTER_BLOCK2 = 15;
    const POS_FOOTER_BLOCK3 = 16;
    const POS_FOOTER_BLOCK4 = 17;
    const POS_FOOTER_BLOCK5 = 18;
    const POS_FOOTER_BLOCK6 = 19;
    const POS_FOOTER_BLOCK7 = 20;
    const POS_FOOTER_BLOCK8 = 21;
    const POS_TOP = 21; // ở trên cùng và bên trên header
    const POS_TOP_HEADER = 10; // Ở trên cùng và header
    const POS_TOP_CENTER = 7; // Ở giữa top va center
    const POS_TOP_LEFT = 22; // O tren cung va ben trai
    const POS_TOP_RIGHT = 23; // O tren cung va ben phai
    const POS_WIGET_BLOCK1 = 2501; // các widget ở trong widget
    const POS_WIGET_BLOCK2 = 2502; // các widget ở trong widget
    const POS_WIGET_BLOCK3 = 2503; // các widget ở trong widget
    const POS_WIGET_BLOCK4 = 2504; // các widget ở trong widget
    const POS_WIGET_BLOCK5 = 2505; // các widget ở trong widget
    const POS_WIGET_BLOCK6 = 2506; // các widget ở trong widget
    const POS_WIGET_BLOCK7 = 2507; // các widget ở trong widget
    const POS_WIGET_BLOCK8 = 2508; // các widget ở trong widget
    const POS_FACEBOOK_COMMENT = 3000; // vị trí của module facebook comment trong trang detail
    // Desktop
    const POS_MENU_MAIN = 3001; // vị trí của module menu
    const POS_SHOPPING_CART = 3002; // vị trí của module shopping cart
    const POS_SEARCH_BOX = 3003; // vị trí của module search box
    const POS_BANNER_MAIN = 3004; // vị trí của module search box
    const POS_SOCIAL = 3005; // vị trí của module social
    const POS_COMMENT = 3006; // Comment của site
    const POS_RATING = 3007; // Comment của site
    const POS_QUESTION = 3008; // Comment của site
    const POS_BANNER_IN = 3009; // vị trí của module search box
    // Mobile
    const POS_MENU_MAIN_MOBILE = 3501; // vị trí của module menu
    const POS_SHOPPING_CART_MOBILE = 3502; // vị trí của module shopping cart
    const POS_SEARCH_BOX_MOBILE = 3503; // vị trí của module search box
    const POS_BANNER_MAIN_MOBILE = 3504; // vị trí của module search box
    const POS_SOCIAL_MOBILE = 3505; // vị trí của module social
    const POS_COMMENT_MOBILE = 3506; // Comment của site
    const POS_RATING_MOBILE = 3507; // Comment của site
    const POS_QUESTION_MOBILE = 3508; // Comment của site
    const POS_BANNER_IN_MOBILE = 3509; // vị trí của module search box
    const POS_PRICE_RANGE = 3510; // vị trí của module search box
    const POS_WIGET_MANU = 3511; // vị trí của module search box
    //
    const POS_DETAIL_BLOCK1 = 4000; // vị trí của module social
    const POS_DETAIL_BLOCK2 = 4001; // vị trí của module social
    const POS_DETAIL_BLOCK3 = 4002; // vị trí của module social
    const POS_DETAIL_BLOCK4 = 4003; // vị trí của module social
    const POS_DETAIL_BLOCK5 = 4004; // vị trí của module social
    const POS_COMMENT1 = 5000; // Comment
    const POS_COMMENT2 = 5001; // Comment
    const WIDGET_TYPE_CUSTOM = 0;
    const WIDGET_TYPE_SYSTEM = 1;
    const WIDGET_TYPE_CUSTOM_NAME = 'wcustom';
    const WIDGET_TYPE_SYSTEM_NAME = 'wsystem';
    const WIDGET_CONFIG_KEY = 'config';
    const WIDGET_SHOWALL_TRUE = 1;
    const WIDGET_SHOWALL_FALSE = 0;
    const WIDGEt_LIMIT_DEFAULT = 200;
    const WIDGET_CACHE_KEY_PREFIX = 'widgetcache';
    const WIDGET_CACHE_EXPIRE_TIME = 43200; // 12h

    /**
     * @return string the associated database table name
     */

    public function tableName() {
        return $this->getTableName('widgets');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('widget_name, alias', 'required'),
            array('widget_status, created_time, modified_time', 'numerical', 'integerOnly' => true),
            //array('widget_template', 'length', 'max' => 3000),
            array('widget_name', 'length', 'max' => 255),
            array('alias', 'length', 'max' => 500),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('widget_id, widget_key, widget_name, widget_status, widget_template, alias, created_time, modified_time, widget_type,showallpage', 'safe'),
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
            'widget_id' => 'Widget',
            'widget_key' => 'Widget Key',
            'widget_name' => Yii::t('widget', 'widget_name'),
            'widget_status' => 'Widget Status',
            'widget_template' => Yii::t('widget', 'widget_template'),
            'alias' => Yii::t('common', 'alias'),
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'widget_type' => Yii::t('widget', 'widget_type'),
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

        $criteria->compare('widget_id', $this->widget_id);
        $criteria->compare('widget_key', $this->widget_key, true);
        $criteria->compare('widget_name', $this->widget_name, true);
        $criteria->compare('widget_title', $this->widget_title, true);
        $criteria->compare('widget_status', $this->widget_status);
        $criteria->compare('widget_template', $this->widget_template, true);
        $criteria->compare('widget_right', $this->widget_right);
        $criteria->compare('alias', $this->alias, true);
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
     * @return Widgets the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     *
     * @return array
     */
    static function getAllowPosition() {
        return array(
            self::POS_LEFT => self::POS_LEFT,
            self::POS_RIGHT => self::POS_RIGHT,
            self::POS_CENTER => self::POS_CENTER,
            self::POS_CENTER_BLOCK1 => self::POS_CENTER_BLOCK1,
            self::POS_CENTER_BLOCK2 => self::POS_CENTER_BLOCK2,
            self::POS_CENTER_BLOCK3 => self::POS_CENTER_BLOCK3,
            self::POS_CENTER_BLOCK4 => self::POS_CENTER_BLOCK4,
            self::POS_CENTER_BLOCK5 => self::POS_CENTER_BLOCK5,
            self::POS_CENTER_BLOCK6 => self::POS_CENTER_BLOCK6,
            self::POS_CENTER_BLOCK7 => self::POS_CENTER_BLOCK7,
            self::POS_CENTER_BLOCK8 => self::POS_CENTER_BLOCK8,
            self::POS_CENTER_BLOCK9 => self::POS_CENTER_BLOCK9,
            self::POS_CENTER_BLOCK10 => self::POS_CENTER_BLOCK10,
            self::POS_CENTER_BLOCK11 => self::POS_CENTER_BLOCK11,
            self::POS_CENTER_BLOCK12 => self::POS_CENTER_BLOCK12,
            self::POS_CENTER_BLOCK13 => self::POS_CENTER_BLOCK13,
            self::POS_CENTER_BLOCK14 => self::POS_CENTER_BLOCK14,
            self::POS_CENTER_BLOCK15 => self::POS_CENTER_BLOCK15,
            self::POS_CENTER_BLOCK16 => self::POS_CENTER_BLOCK16,
            self::POS_CENTER_BLOCK17 => self::POS_CENTER_BLOCK17,
            self::POS_CENTER_BLOCK18 => self::POS_CENTER_BLOCK18,
            self::POS_CENTER_BLOCK19 => self::POS_CENTER_BLOCK19,
            self::POS_CENTER_BLOCK20 => self::POS_CENTER_BLOCK20,
            self::POS_HEADER => self::POS_HEADER,
            self::POS_CENTER_BOTTOM => self::POS_CENTER_BOTTOM,
            self::POS_TOP_CENTER => self::POS_TOP_CENTER,
            self::POS_TOP_HEADER => self::POS_TOP_HEADER,
            self::POS_HEADER_BOTTOM => self::POS_HEADER_BOTTOM,
            self::POS_BEGIN_CONTENT => self::POS_BEGIN_CONTENT,
            self::POS_MAIN_CONTENT => self::POS_MAIN_CONTENT,
            self::POS_HEADER_LEFT => self::POS_HEADER_LEFT,
            self::POS_HEADER_RIGHT => self::POS_HEADER_RIGHT,
            self::POS_LEFT_OUT => self::POS_LEFT_OUT,
            self::POS_RIGHT_OUT => self::POS_RIGHT_OUT,
            self::POS_FOOTER => self::POS_FOOTER,
            self::POS_FOOTER_BLOCK1 => self::POS_FOOTER_BLOCK1,
            self::POS_FOOTER_BLOCK2 => self::POS_FOOTER_BLOCK2,
            self::POS_FOOTER_BLOCK3 => self::POS_FOOTER_BLOCK3,
            self::POS_FOOTER_BLOCK4 => self::POS_FOOTER_BLOCK4,
            self::POS_FOOTER_BLOCK5 => self::POS_FOOTER_BLOCK5,
            self::POS_FOOTER_BLOCK6 => self::POS_FOOTER_BLOCK6,
            self::POS_FOOTER_BLOCK7 => self::POS_FOOTER_BLOCK7,
            self::POS_TOP => self::POS_TOP,
            self::POS_TOP_CENTER => self::POS_TOP_CENTER,
            self::POS_TOP_LEFT => self::POS_TOP_LEFT,
            self::POS_TOP_RIGHT => self::POS_TOP_RIGHT,
            self::POS_WIGET_BLOCK1 => self::POS_WIGET_BLOCK1,
            self::POS_WIGET_BLOCK2 => self::POS_WIGET_BLOCK2,
            self::POS_WIGET_BLOCK3 => self::POS_WIGET_BLOCK3,
            self::POS_WIGET_BLOCK4 => self::POS_WIGET_BLOCK4,
            self::POS_WIGET_BLOCK5 => self::POS_WIGET_BLOCK5,
            self::POS_WIGET_BLOCK6 => self::POS_WIGET_BLOCK6,
            self::POS_WIGET_BLOCK7 => self::POS_WIGET_BLOCK7,
            self::POS_WIGET_BLOCK8 => self::POS_WIGET_BLOCK8,
            self::POS_FACEBOOK_COMMENT => self::POS_FACEBOOK_COMMENT,
            self::POS_MENU_MAIN => self::POS_MENU_MAIN, //DESKTOP
            self::POS_SHOPPING_CART => self::POS_SHOPPING_CART,
            self::POS_SEARCH_BOX => self::POS_SEARCH_BOX,
            self::POS_BANNER_MAIN => self::POS_BANNER_MAIN,
            self::POS_SOCIAL => self::POS_SOCIAL,
            self::POS_COMMENT => self::POS_COMMENT,
            self::POS_RATING => self::POS_RATING,
            self::POS_QUESTION => self::POS_QUESTION,
            self::POS_BANNER_IN => self::POS_BANNER_IN,
            self::POS_MENU_MAIN_MOBILE => self::POS_MENU_MAIN_MOBILE, //MOBILE
            self::POS_SHOPPING_CART_MOBILE => self::POS_SHOPPING_CART_MOBILE,
            self::POS_SEARCH_BOX_MOBILE => self::POS_SEARCH_BOX_MOBILE,
            self::POS_BANNER_MAIN_MOBILE => self::POS_BANNER_MAIN_MOBILE,
            self::POS_SOCIAL_MOBILE => self::POS_SOCIAL_MOBILE,
            self::POS_COMMENT_MOBILE => self::POS_COMMENT_MOBILE,
            self::POS_RATING_MOBILE => self::POS_RATING_MOBILE,
            self::POS_QUESTION_MOBILE => self::POS_QUESTION_MOBILE,
            self::POS_BANNER_IN_MOBILE => self::POS_BANNER_IN_MOBILE, //
            self::POS_DETAIL_BLOCK1 => self::POS_DETAIL_BLOCK1,
            self::POS_DETAIL_BLOCK2 => self::POS_DETAIL_BLOCK2,
            self::POS_DETAIL_BLOCK3 => self::POS_DETAIL_BLOCK3,
            self::POS_DETAIL_BLOCK4 => self::POS_DETAIL_BLOCK4,
            self::POS_DETAIL_BLOCK5 => self::POS_DETAIL_BLOCK5,
            self::POS_COMMENT1 => self::POS_COMMENT1,
            self::POS_COMMENT2 => self::POS_COMMENT2,
            self::POS_PRICE_RANGE => self::POS_PRICE_RANGE,
            self::POS_WIGET_MANU => self::POS_WIGET_MANU,

        );
    }

    /**
     * get All postion title
     * @return array
     */
    static function getAllowPositionTitle() {
        return array(
            self::POS_HEADER => Yii::t('widget', 'POS_HEADER') . ' - ' . self::POS_HEADER,
            self::POS_HEADER_RIGHT => Yii::t('widget', 'POS_HEADER_RIGHT') . ' - ' . self::POS_HEADER_RIGHT,
            self::POS_HEADER_LEFT => Yii::t('widget', 'POS_HEADER_LEFT') . ' - ' . self::POS_HEADER_LEFT,
            self::POS_HEADER_BOTTOM => Yii::t('widget', 'POS_HEADER_BOTTOM') . ' - ' . self::POS_HEADER_BOTTOM,
            self::POS_TOP => Yii::t('widget', 'POS_TOP') . ' - ' . self::POS_TOP,
            self::POS_TOP_HEADER => Yii::t('widget', 'POS_TOP_HEADER') . ' - ' . self::POS_TOP_HEADER,
            self::POS_LEFT => Yii::t('widget', 'POS_LEFT') . ' - ' . self::POS_LEFT,
            self::POS_LEFT_OUT => Yii::t('widget', 'POS_LEFT_OUT') . ' - ' . self::POS_LEFT_OUT,
            self::POS_RIGHT => Yii::t('widget', 'POS_RIGHT') . ' - ' . self::POS_RIGHT,
            self::POS_RIGHT_OUT => Yii::t('widget', 'POS_RIGHT_OUT') . ' - ' . self::POS_RIGHT_OUT,
            self::POS_CENTER => Yii::t('widget', 'POS_CENTER') . ' - ' . self::POS_CENTER,
            self::POS_CENTER_BLOCK1 => Yii::t('widget', 'POS_CENTER_BLOCK1') . ' - ' . self::POS_CENTER_BLOCK1,
            self::POS_CENTER_BLOCK2 => Yii::t('widget', 'POS_CENTER_BLOCK2') . ' - ' . self::POS_CENTER_BLOCK2,
            self::POS_CENTER_BLOCK3 => Yii::t('widget', 'POS_CENTER_BLOCK3') . ' - ' . self::POS_CENTER_BLOCK3,
            self::POS_CENTER_BLOCK4 => Yii::t('widget', 'POS_CENTER_BLOCK4') . ' - ' . self::POS_CENTER_BLOCK4,
            self::POS_CENTER_BLOCK5 => Yii::t('widget', 'POS_CENTER_BLOCK5') . ' - ' . self::POS_CENTER_BLOCK5,
            self::POS_CENTER_BLOCK6 => Yii::t('widget', 'POS_CENTER_BLOCK6') . ' - ' . self::POS_CENTER_BLOCK6,
            self::POS_CENTER_BLOCK7 => Yii::t('widget', 'POS_CENTER_BLOCK7') . ' - ' . self::POS_CENTER_BLOCK7,
            self::POS_CENTER_BLOCK8 => Yii::t('widget', 'POS_CENTER_BLOCK8') . ' - ' . self::POS_CENTER_BLOCK8,
            self::POS_CENTER_BLOCK9 => Yii::t('widget', 'POS_CENTER_BLOCK9') . ' - ' . self::POS_CENTER_BLOCK9,
            self::POS_CENTER_BLOCK10 => Yii::t('widget', 'POS_CENTER_BLOCK10') . ' - ' . self::POS_CENTER_BLOCK10,
            self::POS_CENTER_BLOCK11 => Yii::t('widget', 'POS_CENTER_BLOCK11') . ' - ' . self::POS_CENTER_BLOCK11,
            self::POS_CENTER_BLOCK12 => Yii::t('widget', 'POS_CENTER_BLOCK12') . ' - ' . self::POS_CENTER_BLOCK12,
            self::POS_CENTER_BLOCK13 => Yii::t('widget', 'POS_CENTER_BLOCK13') . ' - ' . self::POS_CENTER_BLOCK13,
            self::POS_CENTER_BLOCK14 => Yii::t('widget', 'POS_CENTER_BLOCK14') . ' - ' . self::POS_CENTER_BLOCK14,
            self::POS_CENTER_BLOCK15 => Yii::t('widget', 'POS_CENTER_BLOCK15') . ' - ' . self::POS_CENTER_BLOCK15,
            self::POS_CENTER_BLOCK16 => Yii::t('widget', 'POS_CENTER_BLOCK16') . ' - ' . self::POS_CENTER_BLOCK16,
            self::POS_CENTER_BLOCK17 => Yii::t('widget', 'POS_CENTER_BLOCK17') . ' - ' . self::POS_CENTER_BLOCK17,
            self::POS_CENTER_BLOCK18 => Yii::t('widget', 'POS_CENTER_BLOCK18') . ' - ' . self::POS_CENTER_BLOCK18,
            self::POS_CENTER_BLOCK19 => Yii::t('widget', 'POS_CENTER_BLOCK19') . ' - ' . self::POS_CENTER_BLOCK19,
            self::POS_CENTER_BLOCK20 => Yii::t('widget', 'POS_CENTER_BLOCK20') . ' - ' . self::POS_CENTER_BLOCK20,
            self::POS_TOP_CENTER => Yii::t('widget', 'POS_TOP_CENTER') . ' - ' . self::POS_TOP_CENTER,
            self::POS_BEGIN_CONTENT => Yii::t('widget', 'POS_BEGIN_CONTENT') . ' - ' . self::POS_BEGIN_CONTENT,
            self::POS_MAIN_CONTENT => Yii::t('widget', 'POS_MAIN_CONTENT') . ' - ' . self::POS_MAIN_CONTENT,
            self::POS_CENTER_BOTTOM => Yii::t('widget', 'POS_CENTER_BOTTOM') . ' - ' . self::POS_CENTER_BOTTOM,
            self::POS_FOOTER => Yii::t('widget', 'POS_FOOTER') . ' - ' . self::POS_FOOTER,
            self::POS_FOOTER_BLOCK1 => Yii::t('widget', 'POS_FOOTER_BLOCK1') . ' - ' . self::POS_FOOTER_BLOCK1,
            self::POS_FOOTER_BLOCK2 => Yii::t('widget', 'POS_FOOTER_BLOCK2') . ' - ' . self::POS_FOOTER_BLOCK2,
            self::POS_FOOTER_BLOCK3 => Yii::t('widget', 'POS_FOOTER_BLOCK3') . ' - ' . self::POS_FOOTER_BLOCK3,
            self::POS_FOOTER_BLOCK4 => Yii::t('widget', 'POS_FOOTER_BLOCK4') . ' - ' . self::POS_FOOTER_BLOCK4,
            self::POS_FOOTER_BLOCK5 => Yii::t('widget', 'POS_FOOTER_BLOCK5') . ' - ' . self::POS_FOOTER_BLOCK5,
            self::POS_FOOTER_BLOCK6 => Yii::t('widget', 'POS_FOOTER_BLOCK6') . ' - ' . self::POS_FOOTER_BLOCK6,
            self::POS_FOOTER_BLOCK7 => Yii::t('widget', 'POS_FOOTER_BLOCK7') . ' - ' . self::POS_FOOTER_BLOCK7,
            self::POS_TOP_LEFT => Yii::t('widget', 'POS_TOP_LEFT') . ' - ' . self::POS_TOP_LEFT,
            self::POS_TOP_RIGHT => Yii::t('widget', 'POS_TOP_RIGHT') . ' - ' . self::POS_TOP_RIGHT,
            self::POS_WIGET_BLOCK1 => Yii::t('widget', 'POS_WIGET_BLOCK1') . ' - ' . self::POS_WIGET_BLOCK1,
            self::POS_WIGET_BLOCK2 => Yii::t('widget', 'POS_WIGET_BLOCK2') . ' - ' . self::POS_WIGET_BLOCK2,
            self::POS_WIGET_BLOCK3 => Yii::t('widget', 'POS_WIGET_BLOCK3') . ' - ' . self::POS_WIGET_BLOCK3,
            self::POS_WIGET_BLOCK4 => Yii::t('widget', 'POS_WIGET_BLOCK4') . ' - ' . self::POS_WIGET_BLOCK4,
            self::POS_WIGET_BLOCK5 => Yii::t('widget', 'POS_WIGET_BLOCK5') . ' - ' . self::POS_WIGET_BLOCK5,
            self::POS_WIGET_BLOCK6 => Yii::t('widget', 'POS_WIGET_BLOCK6') . ' - ' . self::POS_WIGET_BLOCK6,
            self::POS_WIGET_BLOCK7 => Yii::t('widget', 'POS_WIGET_BLOCK7') . ' - ' . self::POS_WIGET_BLOCK7,
            self::POS_WIGET_BLOCK8 => Yii::t('widget', 'POS_WIGET_BLOCK8') . ' - ' . self::POS_WIGET_BLOCK8,
            self::POS_FACEBOOK_COMMENT => Yii::t('widget', 'POS_FACEBOOK_COMMENT') . ' - ' . self::POS_FACEBOOK_COMMENT,
            self::POS_MENU_MAIN => Yii::t('widget', 'POS_MENU_MAIN') . ' - ' . self::POS_MENU_MAIN, //DESKTOP
            self::POS_SHOPPING_CART => Yii::t('widget', 'POS_SHOPPING_CART') . ' - ' . self::POS_SHOPPING_CART,
            self::POS_SEARCH_BOX => Yii::t('widget', 'POS_SEARCH_BOX') . ' - ' . self::POS_SEARCH_BOX,
            self::POS_BANNER_MAIN => Yii::t('widget', 'POS_BANNER_MAIN') . ' - ' . self::POS_BANNER_MAIN,
            self::POS_SOCIAL => Yii::t('widget', 'POS_SOCIAL') . ' - ' . self::POS_SOCIAL,
            self::POS_COMMENT => Yii::t('widget', 'POS_COMMENT') . ' - ' . self::POS_COMMENT,
            self::POS_RATING => Yii::t('widget', 'POS_RATING') . ' - ' . self::POS_RATING,
            self::POS_QUESTION => Yii::t('widget', 'POS_QUESTION') . ' - ' . self::POS_QUESTION,
            self::POS_BANNER_IN => Yii::t('widget', 'POS_BANNER_IN') . ' - ' . self::POS_BANNER_IN,
            self::POS_MENU_MAIN_MOBILE => Yii::t('widget', 'POS_MENU_MAIN_MOBILE') . ' - ' . self::POS_MENU_MAIN_MOBILE, //MOBILE
            self::POS_SHOPPING_CART_MOBILE => Yii::t('widget', 'POS_SHOPPING_CART_MOBILE') . ' - ' . self::POS_SHOPPING_CART_MOBILE,
            self::POS_SEARCH_BOX_MOBILE => Yii::t('widget', 'POS_SEARCH_BOX_MOBILE') . ' - ' . self::POS_SEARCH_BOX_MOBILE,
            self::POS_BANNER_MAIN_MOBILE => Yii::t('widget', 'POS_BANNER_MAIN_MOBILE') . ' - ' . self::POS_BANNER_MAIN_MOBILE,
            self::POS_SOCIAL_MOBILE => Yii::t('widget', 'POS_SOCIAL_MOBILE') . ' - ' . self::POS_SOCIAL_MOBILE,
            self::POS_COMMENT_MOBILE => Yii::t('widget', 'POS_COMMENT_MOBILE') . ' - ' . self::POS_COMMENT_MOBILE,
            self::POS_RATING_MOBILE => Yii::t('widget', 'POS_RATING_MOBILE') . ' - ' . self::POS_RATING_MOBILE,
            self::POS_QUESTION_MOBILE => Yii::t('widget', 'POS_QUESTION_MOBILE') . ' - ' . self::POS_QUESTION_MOBILE,
            self::POS_BANNER_IN_MOBILE => Yii::t('widget', 'POS_RATING_MOBILE') . ' - ' . self::POS_BANNER_IN_MOBILE,
            self::POS_DETAIL_BLOCK1 => Yii::t('widget', 'POS_DETAIL_BLOCK1') . ' - ' . self::POS_DETAIL_BLOCK1,
            self::POS_DETAIL_BLOCK2 => Yii::t('widget', 'POS_DETAIL_BLOCK2') . ' - ' . self::POS_DETAIL_BLOCK2,
            self::POS_DETAIL_BLOCK3 => Yii::t('widget', 'POS_DETAIL_BLOCK3') . ' - ' . self::POS_DETAIL_BLOCK3,
            self::POS_DETAIL_BLOCK4 => Yii::t('widget', 'POS_DETAIL_BLOCK4') . ' - ' . self::POS_DETAIL_BLOCK4,
            self::POS_DETAIL_BLOCK5 => Yii::t('widget', 'POS_DETAIL_BLOCK5') . ' - ' . self::POS_DETAIL_BLOCK5,
            self::POS_COMMENT1 => Yii::t('widget', 'POS_COMMENT1') . ' - ' . self::POS_COMMENT1,
            self::POS_COMMENT2 => Yii::t('widget', 'POS_COMMENT2') . ' - ' . self::POS_COMMENT2,
            self::POS_WIGET_MANU => Yii::t('widget', 'POS_WIGET_MANU') . ' - ' . self::POS_WIGET_MANU,
        );
    }

    /**
     *
     * @param int $widget_id
     * @return array
     */
    static function getCustomWidgetInfo($widget_id = '') {
        if ($widget_id == '')
            return array();
        $widget = Widgets::model()->findByPk($widget_id);
        if ($widget)
            return $widget->attributes;
        return array();
    }

    /**
     *
     * @param array $widget
     * @return array
     */
    static function getWidgetInfo($widget = array()) {
        if (!isset($widget['widget_type']))
            return array();
        switch ($widget['widget_type']) {
            case Widgets::WIDGET_TYPE_CUSTOM: return self::getCustomWidgetInfo($widget['widget_id']);
        }
    }

    /**
     * Lấy đường dẫn của các modules dùng chung cho các loại site
     * @return array
     */
    static function getAllCommonSystemWidgetPath() {
        return array(
            'breadcrumb' => 'common.widgets.modules.breadcrumb.breadcrumb', //  breacumb
            'menu' => 'common.widgets.modules.menu.menu',
            'menu_vertical' => 'common.widgets.modules.menu_vertical.menu_vertical',
            'menufooter' => 'common.widgets.modules.menufooter.menufooter',
            'wcustom' => 'common.widgets.modules.wcustom.wcustom',
            'introduce' => 'common.widgets.modules.introduce.introduce',
            'banner' => 'common.widgets.modules.banner.banner',
            'popup' => 'common.widgets.modules.popup.popup',
            'bannergroup' => 'common.widgets.modules.bannergroup.bannergroup',
            'newnews' => 'common.widgets.modules.news.newnews.newnews',
            'hotproduct' => 'common.widgets.modules.hotproduct.hotproduct',
            'hotwifi' => 'common.widgets.modules.hotwifi.hotwifi',
            'hotproductWithShortDesc' => 'common.widgets.modules.hotproductWithShortDesc.hotproductWithShortDesc',
            'categorybox' => 'common.widgets.modules.categorybox.categorybox',
            'categoryinhome' => 'common.widgets.modules.categoryinhome.categoryinhome',
            'destinationinhome' => 'common.widgets.modules.destinationinhome.destinationinhome',
            'productall' => 'common.widgets.modules.productall.productall',
            'manufacturerall' => 'common.widgets.modules.manufacturerall.manufacturerall',
            'productMembersOnly' => 'common.widgets.modules.productMembersOnly.productMembersOnly',
            'choiceTheme' => 'common.widgets.modules.choiceTheme.choiceTheme',
            'productIncategory' => 'common.widgets.modules.productIncategory.productIncategory',
            'hotnews' => 'common.widgets.modules.news.hotnews.hotnews',
            'mostreadnews' => 'common.widgets.modules.news.mostreadnews.mostreadnews',
            'homenewscategorydetail' => 'common.widgets.modules.news.homenewscategorydetail.homenewscategorydetail',
            'homenewscategory_child_detail' => 'common.widgets.modules.news.homenewscategory_child_detail.homenewscategory_child_detail',
            'newsall' => 'common.widgets.modules.newsall.newsall',
            'yahoobox' => 'common.widgets.modules.yahoobox.yahoobox',
            'customform' => 'common.widgets.modules.customform.customform',
            'onebanner' => 'common.widgets.modules.onebanner.onebanner',
            'html' => 'common.widgets.modules.html.html',
            'social' => 'common.widgets.modules.social.social',
            'newsrelation' => 'common.widgets.modules.newsrelation.newsrelation',
            'tourrelation' => 'common.widgets.modules.tourrelation.tourrelation',
            'newsrelationNextAndPrevious' => 'common.widgets.modules.newsrelationNextAndPrevious.newsrelationNextAndPrevious',
            'productsrelation' => 'common.widgets.modules.productsrelation.productsrelation',
            'newproducts' => 'common.widgets.modules.newproducts.newproducts',
            'useraccess' => 'common.widgets.modules.useraccess.useraccess',
            'map' => 'common.widgets.modules.map.map',
            'searchbox' => 'common.widgets.modules.searchbox.searchbox',
            'searchsuggest' => 'common.widgets.modules.searchsuggest.searchsuggest',
            'searchboxcat' => 'common.widgets.modules.searchboxcat.searchboxcat',
            'facebookcomment' => 'common.widgets.modules.facebookcomment.facebookcomment',
            'introducebox' => 'common.widgets.modules.introducebox.introducebox',
            'productgroup' => 'common.widgets.modules.productgroup.productgroup',
            'productviewed' => 'common.widgets.modules.productviewed.productviewed', // viewed product
            'productCompare' => 'common.widgets.modules.productCompare.productCompare', // viewed product
            'newsletter' => 'common.widgets.modules.newsletter.newsletter', // viewed product
            'logobox' => 'common.widgets.modules.logobox.logobox', // Hiển thị logo của site
            'shoppingcart' => 'common.widgets.modules.shoppingcart.shoppingcart', // Hiển thị logo của site
            'productpromotioninhome' => 'common.widgets.modules.productpromotioninhome.productpromotioninhome', // Hiển thị logo của site
            'productgroupinhome' => 'common.widgets.modules.productgroupinhome.productgroupinhome', // Hiển thị logo của site
            'promotionall' => 'common.widgets.modules.promotionall.promotionall', // Khuyến mãi
            'promotionHotAndNormal' => 'common.widgets.modules.promotionHotAndNormal.promotionHotAndNormal', // Khuyến mãi
            'productsetnew' => 'common.widgets.modules.productsetnew.productsetnew', // Hiển thị những sản phẩm được set là is new
            'productcategoryinhome' => 'common.widgets.modules.productcategoryinhome.productcategoryinhome', // Hiển thị những sản phẩm được set là is new
            'newscategoryinhome' => 'common.widgets.modules.newscategoryinhome.newscategoryinhome',
            'videoscategoryinhome' => 'common.widgets.modules.videoscategoryinhome.videoscategoryinhome', // Hiển thị những sản phẩm được set là is new
            'videohot' => 'common.widgets.modules.videohot.videohot', // Hiển thị những video dc set là nổi bật
            'videonew' => 'common.widgets.modules.videonew.videonew', // Hiển thị những video mới nhất của site
            'pagesize' => 'common.widgets.modules.pagesize.pagesize', // Hiển thị số bản ghi trên trang
            'productsort' => 'common.widgets.modules.productsort.productsort', // product order
            'productpricerange' => 'common.widgets.modules.productpricerange.productpricerange', // product price range
            'jobnew' => 'common.widgets.modules.jobnew.jobnew', // list jobs
            'albumnew' => 'common.widgets.modules.albumnew.albumnew', // list album
            'newsIncategory' => 'common.widgets.modules.newsIncategory.newsIncategory', // news in the category
            'tourIncategory' => 'common.widgets.modules.tourIncategory.tourIncategory', // tour in the category
            'courseIncategory' => 'common.widgets.modules.courseIncategory.courseIncategory', // news in the category
            'imagenew' => 'common.widgets.modules.imagenew.imagenew', // images in site
            'productFilterInCat' => 'common.widgets.modules.productFilterInCat.productFilterInCat', // images in site
            'homepostcategorydetail' => 'common.widgets.modules.homepostcategorydetail.homepostcategorydetail', // post categories show in home
            'languages' => 'common.widgets.modules.languages.languages', // languages for site
            'scrollup' => 'common.widgets.modules.scrollup.scrollup', // scroll to top
            'support' => 'common.widgets.modules.support.support', // hỗ trợ online
            'productMostView' => 'common.widgets.modules.productMostView.productMostView', // sản phẩm xem nhiều nhất
            'productNewAndGroup' => 'common.widgets.modules.productNewAndGroup.productNewAndGroup', // sản phẩm mới và nhóm
            'productCategoryWithBackground' => 'common.widgets.modules.productCategoryWithBackground.productCategoryWithBackground', // box product category with background of category
            'categoryPageSub' => 'common.widgets.modules.categoryPageSub.categoryPageSub',
            'categoryPageSubFull' => 'common.widgets.modules.categoryPageSubFull.categoryPageSubFull',
            'categoryProductSelectFull' => 'common.widgets.modules.categoryProductSelectFull.categoryProductSelectFull',
            'productNewAndHot' => 'common.widgets.modules.productNewAndHot.productNewAndHot', // sản phẩm mới và sản phẩm nổi bật
            'albumsrelation' => 'common.widgets.modules.albumsrelation.albumsrelation', // album liên quan
            'videosrelation' => 'common.widgets.modules.videosrelation.videosrelation', // video liên quan
            'albumsIncategory' => 'common.widgets.modules.albumsIncategory.albumsIncategory', // album thuộc danh mục
            'courseNew' => 'common.widgets.modules.courseNew.courseNew', // khóa học mới
            'registerForm' => 'common.widgets.modules.registerForm.registerForm', // khóa học mớ
            'lecturers' => 'common.widgets.modules.lecturers.lecturers', // các giảng viên
            'consultants' => 'common.widgets.modules.consultants.consultants', // các giảng viên
            'courseNearOpen' => 'common.widgets.modules.courseNearOpen.courseNearOpen', // khóa học sắp khai giảng
            'eventNearOpenDatePicker' => 'common.widgets.modules.eventNearOpenDatePicker.eventNearOpenDatePicker', // khóa học sắp khai giảng
            'eventOld' => 'common.widgets.modules.eventOld.eventOld', // khóa học sắp khai giảng
            'courseRelation' => 'common.widgets.modules.courseRelation.courseRelation', // khóa học sắp khai giảng
            'eventRelation' => 'common.widgets.modules.eventRelation.eventRelation', // khóa học sắp khai giảng
            'supportUser' => 'common.widgets.modules.supportUser.supportUser',
            'courseall' => 'common.widgets.modules.courseall.courseall',
            'eventall' => 'common.widgets.modules.eventall.eventall',
            'lecturerall' => 'common.widgets.modules.lecturerall.lecturerall',
            'consultantall' => 'common.widgets.modules.consultantall.consultantall',
            'albumshot' => 'common.widgets.modules.albumshot.albumshot',
            'realestateall' => 'common.widgets.modules.realestateall.realestateall',
            'realestateProjectAll' => 'common.widgets.modules.realestateProjectAll.realestateProjectAll',
            'hotRealestateProject' => 'common.widgets.modules.hotRealestateProject.hotRealestateProject',
            'courseCategoryInHome' => 'common.widgets.modules.courseCategoryInHome.courseCategoryInHome',
            'pageContent' => 'common.widgets.modules.pageContent.pageContent',
            'shopall' => 'common.widgets.modules.shopall.shopall',
            'hotcar' => 'common.widgets.modules.hotcar.hotcar',
            'instagramFeed' => 'common.widgets.modules.instagramFeed.instagramFeed',
            'carall' => 'common.widgets.modules.carall.carall',
            'tourHotelGroupInHome' => 'common.widgets.modules.tourHotelGroupInHome.tourHotelGroupInHome',
            'tourProvinceInHome' => 'common.widgets.modules.tourProvinceInHome.tourProvinceInHome',
            'hothotel' => 'common.widgets.modules.hothotel.hothotel',
            'hottour' => 'common.widgets.modules.hottour.hottour',
            'tourall' => 'common.widgets.modules.tourall.tourall',
            'hotelall' => 'common.widgets.modules.hotelall.hotelall',
            'roomInHotel' => 'common.widgets.modules.roomInHotel.roomInHotel',
            'searchhotels' => 'common.widgets.modules.searchhotels.searchhotels',
            'wishlist' => 'common.widgets.modules.wishlist.wishlist',
            'ratingcommentsproduct' => 'common.widgets.modules.ratingcommentsproduct.ratingcommentsproduct',
            'ratingcommentsproductform' => 'common.widgets.modules.ratingcommentsproductform.ratingcommentsproductform',
            'commentsRatingForm' => 'common.widgets.modules.commentsRatingForm.commentsRatingForm',
            'commentsRating' => 'common.widgets.modules.commentsRating.commentsRating',
            'commentbox' => 'common.widgets.modules.commentbox.commentbox',
            'commentboxfull' => 'common.widgets.modules.commentboxfull.commentboxfull',
            'shopstorelocation' => 'common.widgets.modules.shopstorelocation.shopstorelocation',
            'categoryPageSubProduct' => 'common.widgets.modules.categoryPageSubProduct.categoryPageSubProduct',
            'categoryPageSubProductFull' => 'common.widgets.modules.categoryPageSubProductFull.categoryPageSubProductFull',
            'relationRoomInHotel' => 'common.widgets.modules.relationRoomInHotel.relationRoomInHotel',
            'hotquestion' => 'common.widgets.modules.question.hotquestion.hotquestion',
            'mostquestionproduct' => 'common.widgets.modules.question.mostquestionproduct.mostquestionproduct',
            'newquestion' => 'common.widgets.modules.question.newquestion.newquestion',
            'relquestion' => 'common.widgets.modules.question.relquestion.relquestion',
            'questionsubmit' => 'common.widgets.modules.question.questionsubmit.questionsubmit',
            'mapNew' => 'common.widgets.modules.mapNew.mapNew',
            'postCategoryAndSub' => 'common.widgets.modules.postCategoryAndSub.postCategoryAndSub',
            'MessageGroupBySender' => 'common.widgets.modules.MessageGroupBySender.MessageGroupBySender',
            'MessageUnread' => 'common.widgets.modules.MessageUnread.MessageUnread',
            'bdsProjectConfigall' => 'common.widgets.modules.bdsProjectConfigall.bdsProjectConfigall',
            'bdsProjectConfighot' => 'common.widgets.modules.bdsProjectConfighot.bdsProjectConfighot',
            'hoteldetail' => 'common.widgets.modules.hoteldetail.hoteldetail',
            'reviews' => 'common.widgets.modules.reviews.reviews',
            'ExpertransContactForm' => 'common.widgets.modules.ExpertransContactForm.ExpertransContactForm', // ajax search suggest
            'joball' => 'common.widgets.modules.joball.joball',
            'jobfilter' => 'common.widgets.modules.jobfilter.jobfilter',
            'jobrelation' => 'common.widgets.modules.jobrelation.jobrelation',
            'jobhighsalary' => 'common.widgets.modules.jobhighsalary.jobhighsalary',
            'jobsearch' => 'common.widgets.modules.jobsearch.jobsearch',
            'sitetype' => 'common.widgets.modules.sitetype.sitetype',
            'SeServiceWidget' => 'common.widgets.modules.SeServiceWidget.SeServiceWidget',
            'SeStaffWidget' => 'common.widgets.modules.SeStaffWidget.SeStaffWidget',
            'MapIframe' => 'common.widgets.modules.MapIframe.MapIframe',
            'BusinessHour' => 'common.widgets.modules.BusinessHour.BusinessHour',
            'BackgroundMusic' => 'common.widgets.modules.BackgroundMusic.BackgroundMusic',
            'SeServiceAllWidget' => 'common.widgets.modules.SeServiceAllWidget.SeServiceAllWidget',
            'albumsImagesHot' => 'common.widgets.modules.albumsImagesHot.albumsImagesHot',
            'BrandWidget' => 'common.widgets.modules.BrandWidget.BrandWidget',
            'SiteInfoWidget' => 'common.widgets.modules.SiteInfoWidget.SiteInfoWidget',
            'HpDoctorAll' => 'common.widgets.modules.HpDoctorAll.HpDoctorAll',
            'HpDoctorSearch' => 'common.widgets.modules.HpDoctorSearch.HpDoctorSearch',
            'SeStaffSearch' => 'common.widgets.modules.SeStaffSearch.SeStaffSearch',
            'AirlineTicketNewWidget' => 'common.widgets.modules.AirlineTicketNewWidget.AirlineTicketNewWidget',
            'albumdetail' => 'common.widgets.modules.albumdetail.albumdetail',
            'productdetail' => 'common.widgets.modules.productdetail.productdetail',
            'productDetailAttribute' => 'common.widgets.modules.productDetailAttribute.productDetailAttribute',
            'QuestionCampaignHot' => 'common.widgets.modules.QuestionCampaignHot.QuestionCampaignHot',
            'QuestionCampaignNormal' => 'common.widgets.modules.QuestionCampaignNormal.QuestionCampaignNormal',
            'tourcategoryinhome' => 'common.widgets.modules.tourcategoryinhome.tourcategoryinhome',
            'Pushup' => 'common.widgets.modules.Pushup.Pushup',
            'ManufacturerCategorySearch' => 'common.widgets.modules.ManufacturerCategorySearch.ManufacturerCategorySearch',
            'ManufacturerCategorySelect' => 'common.widgets.modules.ManufacturerCategorySelect.ManufacturerCategorySelect',
            'carFilter' => 'common.widgets.modules.carFilter.carFilter',
            'productFilterManufacturerCat' => 'common.widgets.modules.productFilterManufacturerCat.productFilterManufacturerCat',
            'popupregisterproduct' => 'common.widgets.modules.popupregisterproduct.popupregisterproduct', //pupop dang ky san pham.
        );
    }

    /**
     * Lấy đường dẫn của một widget key
     * @param type $widget_key
     * @return string
     */
    static function getCommonSystemWidgetPath($widget_key = null) {
        $all = self::getAllCommonSystemWidgetPath();
        if (isset($all[$widget_key]))
            return $all[$widget_key];
        return '';
    }

    /**
     * get path of system widget
     * @param type $widget_id
     * @param type $sitetypename
     * @return string
     */
    static function getSystemWidgetPath($widget_key = '', $sitetypename = '') {
        if ($widget_key == '')
            return '';
        //Kiểm tra xem nó có phải là module dùng chung cho các loại site không
        $path = self::getCommonSystemWidgetPath($widget_key);
        if ($path != '')
            return $path;
        //
        if (!$sitetypename)
            $sitetypename = ClaSite::getSiteTypeName(Yii::app()->siteinfo);
        return 'common.widgets.modules.' . $sitetypename . '.' . $widget_key . '.' . $widget_key;
    }

    /**
     * get custom widget path
     * @return type
     */
    static function getCustomWidgetPath() {
        return 'common.widgets.modules.' . self::WIDGET_TYPE_CUSTOM_NAME . '.' . self::WIDGET_TYPE_CUSTOM_NAME;
    }

    /**
     * get Widgets of site
     * @return type
     */
    static function getWidgets($options = array()) {
        //
        $site_id = isset($options['site_id']) ? $options['site_id'] : Yii::app()->controller->site_id;
        $return = array();
        //
        $data = Yii::app()->db->createCommand()->select()->from(ClaTable::getTable('pagewidget'))
                ->where("site_id=$site_id")
                ->queryAll();
        if ($data && count($data)) {
            foreach ($data as $wid) {
                $return[$wid['page_widget_id']] = $wid;
            }
        }
        return $return;
    }

    /**
     * get widget follow position as: header, footer, lef, right, center
     * @param type $position
     * @return type
     */
    static function getWidgetsFollowPositionKey($position, $key = null) {
        $results = array();
        if ($key === null) {
            $key = ClaSite::getLinkKey();
        }
        if (in_array($position, self::getAllowPosition()) && $key) {
            $data = self::getWidgetsFromPage($key);
            if (isset($data[$position])) {
                $results = $data[$position];
            }
        }
        return $results;
    }

    /**
     * render widget
     * @param type $widget
     * @param type $data (sitetypename = null)
     * @param type $return
     * @return boolean
     */
    static function renderWidget($widget = null, $data = null, $return = false) {
        if (!$widget && !isset($widget['widget_id']))
            return false;
        if (!isset($data['sitetypename'])) {
            $sitetypename = ClaSite::getSiteTypeName(Yii::app()->siteinfo);
        }
        $position = isset($data['position']) ? $data['position'] : '';
        $key = ClaSite::getLinkKey();
        $key = ClaGenerate::encrypt($key);
        //
        $showaction = false;
        if (ClaSite::ShowModule()) {
            $showaction = true;
        }
        //
        switch ($widget['widget_type']) {
            case Widgets::WIDGET_TYPE_SYSTEM: {
                    $path = self::getSystemWidgetPath($widget['widget_id'], $sitetypename);
                    $properties = array(
                        'page_widget_id' => isset($widget['page_widget_id']) ? $widget['page_widget_id'] : null,
                        'showaction' => $showaction,
                        'key' => $key,
                        'position' => $position,
                    );
                }break;
            case Widgets::WIDGET_TYPE_CUSTOM: {
                    $path = self::getCustomWidgetPath();
                    $properties = array(
                        'page_widget_id' => isset($widget['page_widget_id']) ? $widget['page_widget_id'] : null,
                        'widget_id' => $widget['widget_id'],
                        'showaction' => $showaction,
                        'key' => $key,
                        'position' => $position,
                    );
                }break;
        }
        //
        if (isset($path) && $path) {
            if ($return)
                return Yii::app()->controller->widget($path, $properties, $return);
            else
                Yii::app()->controller->widget($path, $properties, $return);
        }
    }

    /**
     *  Lấy các loại modules
     */
    static function getWidgetTypes() {
        // system widget
        $systemwidget = self::getSystemWidget();
        // custom widget
        $customwidget = self::getCustomWidget();
        $return = array();
        if ($systemwidget && count($systemwidget))
            $return = array_merge($return, array(Yii::t('widget', 'widget_system') => $systemwidget));
        if ($customwidget && count($customwidget)) {
            $return = array_merge($return, array(Yii::t('widget', 'widget_custom') => $customwidget));
        }
        return $return;
    }

    /**
     * get system widget
     * @return array
     */
    static function getSystemWidget() {
        $admin = ClaSite::getAdminSession();
        if (isset($admin['user_id']) && $admin['user_id'] . '' != ClaUser::getSupperAdmin()) {
            return array('html' => Yii::t('widget', 'html'),);
        }
        //Những widget do theme quy định
        $themewidget = ClaTheme::getWidgetTypes();
        // Widget get đặc biệt của hệ thống để cho phép người dùng tạo ra các widget khác
        $customcreatewidget = self::getCustomCreateWidget();
        //
        $systemwidget = array_merge($themewidget, $customcreatewidget);
        return $systemwidget;
    }

    /**
     * get widget that is created by user
     * @return array
     */
    static function getCustomWidget() {
        $admin = ClaSite::getAdminSession();
        if (isset($admin['user_id']) && $admin['user_id'] . '' != ClaUser::getSupperAdmin()) {
            return array();
        }
        //
        $data = Yii::app()->db->createCommand()->select()->from(ClaTable::getTable('widget'))
                ->where('site_id=' . (int) Yii::app()->controller->site_id)
                ->queryAll();
        $return = array();
        if ($data && count($data)) {
            foreach ($data as $widget) {
                $return[json_encode(array('widget_type' => self::WIDGET_TYPE_CUSTOM, 'widget_id' => $widget['widget_id']))] = $widget['widget_name'];
            }
        }
        return $return;
    }

    /**
     *  lấy module để người dùng tạo ra các module khác
     * @return array
     */
    static function getCustomCreateWidget() {
        return array(
            self::WIDGET_TYPE_CUSTOM_NAME => Yii::t('widget', 'wcustom')
        );
    }

    //
    /**
     * get All widget follow page
     * @param type $page
     * @return array(position=>array())
     */
    static function getWidgetsFromPage($page = null) {
        $return = Yii::app()->controller->WidgetsFromPage;
        if (!$return) {
            if (!$page) {
                $page = ClaSite::getLinkKey();
            }
            $siteWidgets = self::getWidgetsFromSite();
            $widgetsFromCurrentPage = isset($siteWidgets[$page]) ? $siteWidgets[$page] : array();
            $widgetsForAll = $siteWidgets['all'];
            $positions1 = ($widgetsFromCurrentPage) ? array_keys($widgetsFromCurrentPage) : array();
            $positions2 = ($widgetsForAll) ? array_keys($widgetsForAll) : array();
            //
            $positions = array_unique(array_merge($positions1, $positions2));
            //
            foreach ($positions as $pos) {
                $currentPageWidgetFollowPos = isset($widgetsFromCurrentPage[$pos]) ? $widgetsFromCurrentPage[$pos] : array();
                $allPageWidgetsFollowPos = isset($widgetsForAll[$pos]) ? $widgetsForAll[$pos] : array();
                $return[$pos] = self::mergeSortWidgets($currentPageWidgetFollowPos, $allPageWidgetsFollowPos);
            }
            /**
              $return = array();
              $data = Yii::app()->db->createCommand()->select()->from(ClaTable::getTable('pagewidget') . ' pw')
              ->where('pw.page_key=:page_key AND pw.site_id=:site_id OR (pw.site_id=:site_id && pw.page_key!=:page_key && showallpage=:showallpage)', array(':page_key' => $page, ':site_id' => Yii::app()->controller->site_id, ':showallpage' => self::WIDGET_SHOWALL_TRUE))
              //->join(ClaTable::getTable('widget') . ' w', 'pw.widget_id = w.widget_id')
              ->limit(self::WIDGEt_LIMIT_DEFAULT)
              ->order('worder')
              ->queryAll();
              if ($data && count($data)) {
              foreach ($data as $wid) {
              $return[$wid['position']][$wid['page_widget_id']] = $wid;
              }
              }
             */
        }
        return $return;
    }

    /**
     * Trộn hai mảng lại với nhau theo thuật toán merge sort
     *
     * @param type $widgetsOne
     * @param type $widgetsTwo
     */
    static function mergeSortWidgets($widgetsOne = array(), $widgetsTwo = array()) {
        $return = array();
        $m = count($widgetsOne);
        $n = count($widgetsTwo);
        $i = 0;
        $j = 0;
        while ($i < $m && $j < $n) {
            if ($widgetsOne[$i]['worder'] <= $widgetsTwo[$j]['worder']) {
                $return[$widgetsOne[$i]['page_widget_id']] = $widgetsOne[$i];
                $i++;
            } else {
                $return[$widgetsTwo[$j]['page_widget_id']] = $widgetsTwo[$j];
                $j++;
            }
        }
        //
        if ($i < $m) {
            for ($k = $i; $k < $m; $k++) {
                $return[$widgetsOne[$k]['page_widget_id']] = $widgetsOne[$k];
            }
        } elseif ($j < $n) {
            for ($k = $j; $k < $n; $k++) {
                $return[$widgetsTwo[$k]['page_widget_id']] = $widgetsTwo[$k];
            }
        }

        return $return;
    }

    //
    /**
     * lấy module cho cấu hình của widget
     * @param type $class_name
     * @return \modelname|boolean
     */
    static function getWidgetConfigModel($class_name = '') {
        if ($class_name) {
            $modelname = self::WIDGET_CONFIG_KEY . "_" . $class_name;
            return new $modelname;
        }
        return false;
    }

    /**
     * Lấy widtet sau cùng của 1 page theo vị trí
     * @param type $page
     * @param type $position
     * @return type
     */
    static function getLastWidgetsFromPagePosition($page = null, $position = 0) {
        $widget = array();
        if (!$page)
            $page = ClaSite::getLinkKey();
        $widget = Yii::app()->db->createCommand()->select()->from(ClaTable::getTable('pagewidget') . ' pw')
                ->where('(pw.page_key=:page_key AND pw.site_id=:site_id OR (pw.site_id=:site_id AND pw.page_key!=:page_key AND showallpage=:showallpage)) AND position=:position', array(':page_key' => $page, ':position' => $position, ':site_id' => Yii::app()->controller->site_id, ':showallpage' => self::WIDGET_SHOWALL_TRUE))
                ->order('worder DESC')
                ->limit(1)
                ->queryRow();
        return $widget;
    }

    /**
     * Đếm số widget trong một trang ở một vị trí nào đó
     * @param type $page
     * @return array(position=>array())
     */
    static function countWidgetsFromPagePosition($page = null, $position = 0) {
        $count = 0;
        if (!$page)
            $page = ClaSite::getLinkKey();
        $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('pagewidget') . ' pw')
                ->where('(pw.page_key=:page_key AND pw.site_id=:site_id OR (pw.site_id=:site_id AND pw.page_key!=:page_key AND showallpage=:showallpage)) AND position=:position', array(':page_key' => $page, ':position' => $position, ':site_id' => Yii::app()->controller->site_id, ':showallpage' => self::WIDGET_SHOWALL_TRUE))
                ->queryScalar();
        return $count;
    }

    /**
     *
     */
    static function getWidgetsFromSite() {
        $return = Yii::app()->cache->get(self::getCacheKey());
        if (!$return) {
            $return = array();
            $return['all'] = array();
            $data = Yii::app()->db->createCommand()->select()->from(ClaTable::getTable('pagewidget') . ' pw')
                    ->where('pw.site_id=:site_id', array(':site_id' => Yii::app()->controller->site_id))
                    ->order('worder')
                    ->queryAll();
            if ($data) {
//                $return['all'] = array();
                foreach ($data as $wid) {
                    if ($wid['showallpage']) {
                        $return['all'][$wid['position']][] = $wid;
                    } else {
                        $return[$wid['page_key']][$wid['position']][] = $wid;
                    }
                }
                //
                Yii::app()->cache->set(self::getCacheKey(), $return, self::getExpireCacheTime());
            }
        }
        return $return;
    }

    //
    static function getCacheKey($language = '') {
        if (!$language) {
            $language = ClaSite::getLanguageTranslate();
        }
        return self::WIDGET_CACHE_KEY_PREFIX . Yii::app()->controller->site_id . $language;
    }

    static function getExpireCacheTime() {
        return self::WIDGET_CACHE_EXPIRE_TIME;
    }

    static function deleteCache($language = '') {
        return Yii::app()->cache->delete(self::getCacheKey($language));
    }

}
