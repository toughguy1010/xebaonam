<?php

/**
 * This is the model class for table "airline_ticket".
 *
 * The followings are the available columns in table 'airline_ticket':
 * @property string $id
 * @property string $name
 * @property string $alias
 * @property string $price
 * @property string $departure
 * @property string $departure_date
 * @property string $destination
 * @property string $destination_date
 * @property string $created_time
 * @property string $modified_time
 * @property string $site_id
 * @property string $ticket_category_id
 * @property string $category_track
 * @property string $status
 */
class AirlineTicket extends ActiveRecord {

    const TICKET_DEFAUTL_LIMIT = 10;

    public $avatar = '';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'airline_ticket';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, provider_id, departure, departure_date, destination, destination_date, ticket_category_id', 'required'),
            array('name, alias, departure, destination', 'length', 'max' => 255),
            array('price, departure_date, destination_date, created_time, modified_time, site_id', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, alias, price, departure, departure_date, destination, destination_date, created_time, modified_time, site_id, avatar, provider_id, ticket_category_id, category_track, status', 'safe'),
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
            'name' => 'Tên vé',
            'alias' => 'Alias',
            'price' => 'Giá',
            'departure' => 'Xuất phát',
            'departure_date' => 'Ngày đi',
            'destination' => 'Điểm đến',
            'destination_date' => 'Ngày về',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'site_id' => 'Site',
            'provider_id' => 'Hãng hàng không',
            'ticket_category_id' => 'Danh mục vé',
            'status' => 'Trạng thái'
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
        $criteria->compare('site_id', $this->site_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AirlineTicket the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->modified_time = $this->created_time;
            $this->alias = HtmlFormat::parseToAlias($this->name);
        } else {
            $this->modified_time = time();
            if (!trim($this->alias) && $this->name) {
                $this->alias = HtmlFormat::parseToAlias($this->name);
            }
        }
        return parent::beforeSave();
    }

    public static function getTicketAll($options = array()) {
        if (!isset($options['limit'])) {
            $options['limit'] = self::TICKET_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int) $options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        $site_id = Yii::app()->controller->site_id;
        //
        $condition = 't.site_id=:site_id AND t.status=:status';
        $params = array(':site_id' => $site_id, ':status' => ActiveRecord::STATUS_ACTIVED);
        //
        $offset = ((int) $options[ClaSite::PAGE_VAR] - 1) * $options ['limit'];
        //
        $order = 't.id DESC';
        if (isset($options['order']) && $options['order']) {
            $order = $options['order'];
        }
        //
        $data = Yii::app()->db->createCommand()->select('t.*, r.avatar_path AS provider_avatar_path, r.avatar_name AS provider_avatar_name, r.name AS provider_name')->from(ClaTable::getTable('airline_ticket') . ' t')
                        ->leftJoin('airline_provider r', 'r.id = t.provider_id')
                        ->where($condition, $params)
                        ->order($order)
                        ->limit($options['limit'], $offset)->queryAll();
        //
        return $data;
    }

}
