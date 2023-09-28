<?php

/**
 * This is the model class for table "videos_product_rel".
 *
 * The followings are the available columns in table 'videos_product_rel':
 * @property string $video_id
 * @property string $product_id
 * @property integer $created_time
 * @property string $order
 */
class VideosProductRel extends CActiveRecord
{
    const COURSE_DEFAUTL_LIMIT = 10;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'videos_product_rel';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('video_id, product_id', 'required'),
			array('created_time, site_id', 'numerical', 'integerOnly'=>true),
			array('video_id, product_id, order', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('video_id, product_id, created_time, order, site_id', 'safe', 'on'=>'search'),
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
			'video_id' => 'Video',
			'product_id' => 'Product',
			'created_time' => 'Created Time',
			'order' => 'Order',
			'site_id' => 'Site id',
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

		$criteria->compare('video_id',$this->video_id,true);
		$criteria->compare('product_id',$this->product_id,true);
		$criteria->compare('created_time',$this->created_time);
		$criteria->compare('order',$this->order,true);
		$criteria->compare('site_id',$this->site_id,true);
        $criteria->order = '`order`, created_time DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VideosProductRel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * return product_id list
     * @param int $product_id
     */
    static function getVideosIdInRel($product_id) {
        $results = array();
        $product_id = (int) $product_id;
        $list_rel = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('videos_product_rel'))
            ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND product_id= ' . $product_id )
            ->queryAll();
        if ($list_rel) {
            foreach ($list_rel as $each_rel) {
                $results[$each_rel['video_id']] = $each_rel['video_id'];
            }
            //
        }

        return $results;
    }


    /**
     * return product_id list
     * @param int $product_id
     */
    static function countVideoInRel($product_id) {
        $product_id = (int) $product_id;
        $count = Yii::app()->db->createCommand()->select('count(*)')
            ->from(ClaTable::getTable('videos_product_rel'))
            ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND product_id= ' . $product_id)
            ->queryScalar();
        //
        return (int) $count;
    }

    /**
     * get products and its info
     * @param int $product_id
     * @param array $options
     */
    static function getVideosInRel($product_id, $options = array()) {
        $product_id = (int) $product_id;
        if (!isset($options['limit']))
            $options['limit'] = self::COURSE_DEFAUTL_LIMIT;
        if ($product_id) {
            $data = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('videos_product_rel') . ' pg')
                ->join(ClaTable::getTable('videos') . ' p', 'pg.video_id=p.video_id')
                ->where('pg.site_id=' . Yii::app()->siteinfo['site_id'] . ' AND pg.product_id= ' . $product_id )
                ->limit($options['limit'])
                ->order('pg.order ,pg.created_time DESC')
                ->queryAll();
            return $data;
        }
        return array();
    }
}
