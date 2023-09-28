<?php

/**
 * This is the model class for table "site_page_size".
 *
 * The followings are the available columns in table 'site_page_size':
 * @property string $id
 * @property string $page_key
 * @property string $site_id
 * @property string $created_time
 * @property string $modified_time
 * @property integer $page_size
 */
class SitePageSize extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'site_page_size';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('site_id', 'required'),
			array('page_size', 'numerical', 'integerOnly'=>true),
			array('page_key', 'length', 'max'=>100),
			array('site_id, created_time, modified_time', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, page_key, site_id, created_time, modified_time, page_size', 'safe'),
		);
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
			'page_key' => 'Page Key',
			'site_id' => 'Site',
			'created_time' => 'Created Time',
			'modified_time' => 'Modified Time',
			'page_size' => 'Page Size',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('page_key',$this->page_key,true);
		$criteria->compare('site_id',$this->site_id,true);
		$criteria->compare('created_time',$this->created_time,true);
		$criteria->compare('modified_time',$this->modified_time,true);
		$criteria->compare('page_size',$this->page_size);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SitePageSize the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * Trả về list trang cần chia pagesize
     * @return type
     */
    static function getPageKeyArr()
    {
        $pages = array(
            'economy/product/category' => Yii::t('product', 'product_category'),
            'news/news/category' => Yii::t('news', 'news_category'),
            'search/search/search' => Yii::t('common', 'search'),
            'work/job' => Yii::t('work', 'work'),
            'media/video/category' => Yii::t('video', 'video_category'),
            'media/album/all' => Yii::t('album', 'album'),
            'media/album/category' => Yii::t('album', 'album_category'),
            'content/post/category' => Yii::t('post', 'post_category'),
            'profile/profile/notice' => Yii::t('post', 'profile_notice'),
            'economy/question/' => Yii::t('post', 'question_index'),
            'economy/course/' => Yii::t('post', 'course_index'),
            'economy/course/category' => Yii::t('post', 'course_category'),
        );
//        $list_category = ClaCategory::getAllProductCategoryPage();
//        foreach ($list_category as $ca) {
//            $pages['ppage_' . $ca['cat_id']] = $ca['cat_name'];
//        }
        //
        return $pages;
    }

    public static function getPageSizeSite($site_id = false) {
        $page_site_id = $site_id;
        if(!$site_id){
            $page_site_id = Yii::app()->controller->site_id;
        }
        $data = Yii::app()->db->createCommand()->select('*')
            ->from('site_page_size')
            ->where('site_id=:site_id', array(':site_id' => $page_site_id))
            ->queryAll();
        $results = array();
        if ($data) {
            foreach ($data as $item) {
                $results[$item['page_key']] = $item['page_size'];
            }
        }
        return $results;
    }

    public static function getPageSizeByKey($key) {
        $data = SitePageSize::model()->findByAttributes(array(
            'key' => $key,
            'site_id' => Yii::app()->controller->site_id
        ));
        return $data;
    }

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->modified_time = $this->created_time;
        } else {
            $this->modified_time = time();
        }
        return parent::beforeSave();
    }

    function afterSave() {
        //
//        $translate_language = ClaSite::getLanguageTranslate();
        $translate_language = null;
        //
        Yii::app()->cache->delete(ClaSite::CACHE_PAGE_SIZE_PRE . $this->site_id . $translate_language);
        //
        parent::afterSave();
    }

}
