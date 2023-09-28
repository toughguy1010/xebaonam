<?php

/**
 * This is the model class for table "product_images_tag".
 *
 * The followings are the available columns in table 'product_images_tag':
 * @property string $id
 * @property integer $img_id
 * @property string $data
 * @property integer $site_id
 * @property integer $created_time
 * @property integer $modified_time
 */
class ProductImagesTag extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('product_images_tag');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('data', 'required'),
            array('img_id, site_id, created_time, modified_time', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, img_id, data, site_id, created_time, modified_time', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'products' => array(self::HAS_MANY, 'ProductToImageTag', 'tag_id')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'img_id' => 'Img',
            'data' => 'Data',
            'site_id' => 'Site',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('img_id', $this->img_id);
        $criteria->compare('data', $this->data, true);
        $criteria->compare('site_id', $this->site_id);
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
     * @return ProductImagesTag the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * delete products in group after delete group
     */
    public function afterDelete() {
        //deleete product in group
        ProductToImageTag::model()->deleteAllByAttributes(array('tag_id' => $this->id));
    }

    public function beforeSave() {
        if ($this->isNewRecord) {
            $this->created_time = $this->modified_time = time();
            if (!$this->site_id) {
                $this->site_id = Yii::app()->controller->site_id;
            }
        } else {
            $this->modified_time = time;
        }
        return parent::beforeSave();
    }

    /**
     * search all product and return CArrayDataProvider
     */
    public function SearchProducts() {
        $pagesize = Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']) * 4;
        if ($this->isNewRecord) {
            return new CArrayDataProvider([], array(
                'pagination' => array(
                    'pageSize' => $pagesize,
                    'pageVar' => ClaSite::PAGE_VAR,
                ),
                'totalItemCount' => 0,
            ));
        }
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        if (!$page)
            $page = 1;
        $products = $this->products(array(
            'limit' => $pagesize * $page,
            //'offset' => ($page - 1) * $pagesize,
            'order' => '`order` ASC, id DESC'
        ));
        return new CArrayDataProvider($products, array(
            'pagination' => array(
                'pageSize' => $pagesize,
                'pageVar' => ClaSite::PAGE_VAR,
            ),
            'totalItemCount' => ProductImagesTag::countProductInTag($this->id),
        ));
    }

    /**
     * return product_id list
     * @param type $tag_id
     */
    static function countProductInTag($tag_id) {
        $group_id = (int) $group_id;
        $count = Yii::app()->db->createCommand()->select('count(*)')
                ->from(ClaTable::getTable('product_to_image_tag'))
                ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND tag_id=' . $tag_id)
                ->queryScalar();
        //
        return (int) $count;
    }

    /**
     * get products and its info
     * @param type $group_id
     * @param array $options
     */
    static function getProductInTab($tag_id, $options = array()) {
        $tag_id = (int) $tag_id;
        if (!isset($options['limit']))
            $options['limit'] = self::PRODUCT_DEFAUTL_LIMIT;
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int) $options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        if ($tag_id) {
            $products = Yii::app()->db->createCommand()->select()
                    ->from(ClaTable::getTable('product_images_tag') . ' pIt')
                    ->join(ClaTable::getTable('product_to_image_tag') . ' pTiT', 'pTiT.tag_id=pIt.id')
                    ->join(ClaTable::getTable('product') . ' p', 'pTiT.product_id=p.id')
                    ->where('pTiT.tag_id=' . $tag_id)
                    ->limit($options['limit'], $offset)
                    ->order('pTiT.order ASC, pTiT.created_time DESC')
                    ->queryAll();


            $product_ids = array_map(function ($product) {
                return $product['id'];
            }, $products);

            $product_info_array = ProductInfo::getProductInfoByProductids($product_ids, 'product_id, product_sortdesc, total_rating, total_votes');

            $results = array();
            foreach ($products as $p) {
                $results[$p['id']] = $p;
                foreach ($product_info_array as $kpi => $product_info) {
                    if ($product_info['product_id'] == $p['id']) {
                        $results[$p['id']]['product_info'] = $product_info;
                        unset($product_info_array[$kpi]);
                    }
                }
                $results[$p['id']]['link'] = Yii::app()->createUrl('economy/product/detail', array('id' => $p['id'], 'alias' => $p['alias']));
                $results[$p['id']]['price_text'] = Product::getPriceText($p);
                $results[$p['id']]['price_market_text'] = Product::getPriceText($p, 'price_market');
                $results[$p['id']]['price_save_text'] = Product::getPriceText($p, 'price_save');
            }
            return $results;
        }
        return array();
    }

}
