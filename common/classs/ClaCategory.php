<?php

/*
 * @author minhbn <minhcoltech@gmail.com>
 * @date 18-02-2014
 * Class for create and show category
 *
 */

class ClaCategory
{

    const CATEGORY_ROOT = 0;
    const CATEGORY_ = '';
    const CATEGORY_NEWS = 'news';
    const CATEGORY_JOBS = 'jobs';
    const CATEGORY_QUESTION = 'question';
    const CATEGORY_VIDEO = 'video';
    const CATEGORY_PRODUCT = 'product';
    const CATEGORY_RENT = 'rent';
    const CATEGORY_COURSE = 'course';
    const CATEGORY_EVENT = 'event';
    const CATEGORY_PROMOTION = 'promotion';
    const CATEGORY_CAR = 'car';
    const CATEGORY_TOUR = 'tour';
    const CATEGORY_MANUFACTURER = 'manufacturer';
    const CATEGORY_REAL_ESTATE = 'real_estate';
    const CATEGORY_PROJECT = 'project';
    const CATEGORY_ALBUMS = 'albums';
    const CATEGORY_POST = 'post';
    const CATEGORY_SERVICE = 'service';
    const CATEGORY_AIRLINE_TICKET = 'airline_ticket';
    const CATEGORY_KEY = 'cat';
    const CATEGORY_SPLIT = ' ';
    //
    const CATEGORY_THEME = 'theme';
    const CATEGORY_STEP = 0;

    //
    protected $items = array(); // list category
    protected $relations = array(); // list category array('parent'=>'list children');
    protected $dbname = '';
    public $type = '';   // Type of category such as: news, video,...
    public $route = '';
    public $application = 'backoffice';
    protected $showAll = false; // Hiển thị tất cả các trạng thái
    protected $selectFull = false;
    protected $expireCacheTime = 28800; // Cache 8h
    protected $cacheKey = 'CatCache';

    /**
     * construct
     */
    function __construct($options = array())
    {
        if (isset($options['type']))
            $this->type = $options['type'];
        if (isset($options['application']))
            $this->application = $options['application'];
        if (isset($options['showAll']))
            $this->showAll = $options['showAll'];
        if (isset($options['selectFull']))
            $this->selectFull = $options['selectFull'];
        if (isset($options['create']) && $options['create'] === true) {
            $this->generateCategory();
        }
    }

    /**
     * Khởi tạo data chứa các category
     * @param type $options ('selectFull')
     */
    function generateCategory($options = array())
    {
        $dbname = $this->getCategoryTable();
        //
        $data = array('items' => array(), 'relations' => array());
        //
        $site_id = Yii::app()->controller->site_id;
        // ----------------------------------------------------- get data -------------------------------------------------------
        $select = '*';
        $dataread = false;
        if ($this->type == self::CATEGORY_PRODUCT && !$this->showAll) {
            $dataread = Yii::app()->cache->get($this->getCacheKey());
        }
        if (!$dataread) {
            if (isset($options['selectFull']) && $options['selectFull'] || $this->selectFull || (Yii::app()->cache->enable && $this->type == self::CATEGORY_PRODUCT)) {
                $dataread = Yii::app()->db->createCommand("SELECT $select FROM $dbname WHERE site_id=$site_id " . (($this->showAll) ? '' : 'AND status=' . ActiveRecord::STATUS_ACTIVED . ' ') . " ORDER BY cat_order")->queryAll();
            } else {
                if ($this->type == self::CATEGORY_NEWS) {
                    $select = 'cat_id,cat_parent,cat_name,alias,cat_description,image_path,image_name,cover_path,cover_name';
                } else {
                    $select = 'cat_id,cat_parent,cat_name,alias,cat_description,image_path,image_name';
                }

                $dataread = Yii::app()->db->createCommand("SELECT $select FROM $dbname WHERE site_id=$site_id " . (($this->showAll) ? '' : 'AND status=' . ActiveRecord::STATUS_ACTIVED . ' ') . " ORDER BY cat_order")->queryAll();
            }
            if (Yii::app()->cache->enable && $this->type == self::CATEGORY_PRODUCT && $dataread && !$this->showAll) {
                Yii::app()->cache->set($this->getCacheKey(), $dataread, $this->getExpireCacheTime());
            }
        }
        // ----------------------------------------------------- end cache -------------------------------------------------------
        foreach ($dataread as $menu_item) {
            $data['items'][$menu_item['cat_id']] = $menu_item;
            $data['relations'][$menu_item['cat_parent']][] = $menu_item['cat_id'];
        }
        $this->items = $data['items'];
        $this->relations = $data['relations'];
    }

    /**
     * get category table in db
     */
    public function getCategoryTable()
    {
        switch ($this->type) {
            case self::CATEGORY_NEWS:
                $this->dbname = ClaTable::getTable('newcategory');
                break;
             case self::CATEGORY_JOBS:
                $this->dbname = ClaTable::getTable('jobs_categories');
                break;
            case self::CATEGORY_AIRLINE_TICKET:
                $this->dbname = ClaTable::getTable('airline_ticket_categories');
                break;
            case self::CATEGORY_VIDEO:
                $this->dbname = ClaTable::getTable('videos_categories');
                break;
            case self::CATEGORY_PRODUCT:
                $this->dbname = ClaTable::getTable('productcategory');
                break;
            case self::CATEGORY_RENT:
                $this->dbname = ClaTable::getTable('rent_categories');
                break;
            case self::CATEGORY_THEME:
                $this->dbname = ClaTable::getTable('themecategory');
                break;
            case self::CATEGORY_POST:
                $this->dbname = ClaTable::getTable('postcategory');
                break;
            case self::CATEGORY_COURSE:
                $this->dbname = ClaTable::getTable('edu_course_categories');
                break;
            case self::CATEGORY_ALBUMS:
                $this->dbname = ClaTable::getTable('albums_categories');
                break;
            case self::CATEGORY_REAL_ESTATE:
                $this->dbname = ClaTable::getTable('real_estate_categories');
                break;
            case self::CATEGORY_PROJECT:
                $this->dbname = ClaTable::getTable('bds_categories');
                break;
            case self::CATEGORY_CAR:
                $this->dbname = ClaTable::getTable('car_categories');
                break;
            case self::CATEGORY_TOUR:
                $this->dbname = ClaTable::getTable('tour_categories');
                break;
            case self::CATEGORY_MANUFACTURER:
                $this->dbname = ClaTable::getTable('manufacturer_categories');
                break;
            case self::CATEGORY_EVENT:
                $this->dbname = ClaTable::getTable('eve_event_categories');
                break;
            case self::CATEGORY_PROMOTION:
                $this->dbname = ClaTable::getTable('promotion_categories');
                break;
            case self::CATEGORY_SERVICE:
                $this->dbname = ClaTable::getTable('se_categories');
                break;
            default :
                $this->dbname = ClaTable::getTable('category');
        }
        return $this->dbname;
    }

    /**
     * Get route
     */
    public function getRoute()
    {
        if (!$this->route) {
            switch ($this->type) {
                case self::CATEGORY_NEWS:
                    {
                        $this->route = ($this->application == 'backoffice') ? '/news/newscategory/' : '/news/news/category';
                    }
                    break;
                case self::CATEGORY_JOBS:
                    {
                        $this->route = ($this->application == 'backoffice') ? '/jobs/jobscategory/' : '/jobs/jobs/category';
                    }
                    break;
                case self::CATEGORY_AIRLINE_TICKET:
                    {
                        $this->route = ($this->application == 'backoffice') ? '/airline/airlineTicketCategory/' : '/airline/airline/airlineTicketCategory';
                    }
                    break;
                case self::CATEGORY_VIDEO:
                    $this->route = ($this->application == 'backoffice') ? '/video/videocategory/' : '/media/video/category';
                    break;
                case self::CATEGORY_PRODUCT:
                    $this->route = ($this->application == 'backoffice') ? '/economy/productcategory/' : '/economy/product/category';
                    break;
                case self::CATEGORY_RENT:
                    $this->route = ($this->application == 'backoffice') ? '/economy/rentcategory/' : '/economy/rent/category';
                    break;
                case self::CATEGORY_SERVICE:
                    $this->route = ($this->application == 'backoffice') ? '/service/category/' : '/service/service/category';
                    break;
                case self::CATEGORY_PROMOTION:
                    $this->route = ($this->application == 'backoffice') ? '/economy/promotionCategory' : '/economy/product/promotionCategory';
                    break;
                case self::CATEGORY_POST:
                    $this->route = ($this->application == 'backoffice') ? '/content/postcategory/' : '/content/post/category';
                    break;
                case self::CATEGORY_ALBUMS:
                    $this->route = ($this->application == 'backoffice') ? '/media/albumsCategories/' : '/media/album/category';
                    break;
                case self::CATEGORY_CAR:
                    $this->route = ($this->application == 'backoffice') ? '/car/carcategories' : '/car/car/category';
                    break;
                default :
                    $this->route = '/category/category/';
            }
        }
        return $this->route;
    }

    /**
     * Get list categories item
     */
    public function getListItems()
    {
        return $this->items;
    }

    /**
     * Get list categories relations
     */
    public function getRelations()
    {
        return $this->relations;
    }

// Đệ quy tạo ra một category
    public function createCategory($parent_id)
    {
        $route = $this->getRoute();
        $data = '';
        if (isset($this->relations[$parent_id])) {
            $data = '<ul>';
            foreach ($this->relations[$parent_id] as $item_id) {
                $data .= '<li class="cat_content"><div class="clearfix" style="width:100%; border-bottom:1px solid #F1F1F1;">
                    <a class="floatleft">' . $this->items[$item_id]['cat_name'] . '</a>
                    <div class="floatright" style="width:160px; border-left:1px solid #F1F1F1;" align="center">
                        <a href="' . Yii::app()->createUrl($route . "addcat", array("pa" => $this->items[$item_id]["cat_id"])) . '" title="Thêm danh mục"><img src="' . Yii::app()->baseUrl . "/images/category/ajouter.png" . '"/></a>
                        <a href="' . Yii::app()->createUrl($route . "editcat", array("id" => $this->items[$item_id]["cat_id"])) . '" title="Sửa"><img src="' . Yii::app()->baseUrl . "/images/category/editer.png" . '" /></a>
                        <a href="' . Yii::app()->createUrl($route . 'delcat', array('id' => $this->items[$item_id]["cat_id"])) . '" cateaction="delete" title="Xóa" class="cateaction"><img src="' . Yii::app()->baseUrl . "/images/category/delete.png" . '" /></a>    
                            &nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="' . Yii::app()->createUrl($route . 'movecat', array('id' => $this->items[$item_id]["cat_id"], 'status' => 'movedown')) . '" cateaction="movedown" title="di chuyển xuống" class="cateaction"><img src="' . Yii::app()->baseUrl . '/images/category/bas.png"/></a>
                        <a href="' . Yii::app()->createUrl($route . 'movecat', array('id' => $this->items[$item_id]["cat_id"], 'status' => 'moveup')) . '" title="di chuyển lên" cateaction="moveup" class="cateaction"><img src="' . Yii::app()->baseUrl . '/images/category/haut.png"/></a>
                    </div>
                    </div>';

                // find childitems recursively
                $data .= $this->createCategory($item_id);

                $data .= '</li>';
            }
            $data .= '</ul>';
        }

        return $data;
    }

// Đệ quy tạo ra một menu
    public function createMenu($parent_id, $htmlOptions = array())
    {
        $data = '';
        if (isset($this->relations[$parent_id])) {
            $data = '<ul>';
            foreach ($this->relations[$parent_id] as $item_id) {
                $data .= '<li>'
                    . '<a href="' . Yii::app()->createUrl("/shop", array("cat" => $item_id)) . '">' . $this->items[$item_id]['cat_name'] . '</a>';

                // find childitems recursively
                $data .= $this->createMenu($item_id, $htmlOptions);

                $data .= '</li>';
            }
            $data .= '</ul>';
        }

        return $data;
    }

    public function createMenu2($parent_id, $htmlOptions = array())
    {
        $data = '';
        $route = $this->getRoute();
        if (isset($this->relations[$parent_id])) {
            $data = ($parent_id == self::CATEGORY_ROOT) ? '<ul class="nav">' : '<ul class="sub-menu" style="overflow: hidden; height: auto; padding-top: 0px; display: none; margin-top: 0px; margin-bottom: 0px; padding-bottom: 0px;">';
            foreach ($this->relations[$parent_id] as $item_id) {
                $data .= '<li>'
                    . '<a href="' . Yii::app()->createUrl($route . 'category', array('id' => $this->items[$item_id]["cat_id"], 'alias' => $this->items[$item_id]['alias'])) . '">' . $this->items[$item_id]['cat_name'] . '</a>';

                // find childitems recursively
                $data .= $this->createMenu($item_id, $htmlOptions);

                $data .= '</li>';
            }
            $data .= '</ul>';
        }

        return $data;
    }

    /**
     *
     * create bread cumbs
     * @param type $id
     * @param type $save
     */
    public function createbreadcrumbs($id = 0, &$save = array())
    {
        if ($id != 0) {
            //add element to begin of array;
            array_unshift($save, $this->items[$id]);
            $this->createbreadcrumbs($this->items[$id]["cat_parent"], $save);
        }
        return $save;
    }

    /**
     *
     * Save track (return track from root to select id)
     * @param type $id
     * @param type $savetrack
     */
    public function saveTrack($id, &$savetrack = array())
    {
        if ($id != 0) {
            $savetrack[] = $this->items[$id]["cat_id"];
            $this->saveTrack($this->items[$id]["cat_parent"], $savetrack);
        }
        return $savetrack;
    }

    /**
     * Create option of select
     */
    public function createOption($parent_id = 0, $select = null, $step = 0, $htmlOptions = array())
    {
        $data = '';
        $space = '';
        $space = str_repeat("&nbsp;", $step * 6);
        $step++;
        if (isset($this->relations[$parent_id])) {
            foreach ($this->relations[$parent_id] as $item_id) {
                if ($parent_id == 0) {
                    $data .= '<option value="0">|</option>';
                }
                $data .= '<option value="' . $this->items[$item_id]["cat_id"]
                    . '" ';
                if (count($htmlOptions)) {
                    foreach ($htmlOptions as $attr => $value) {
                        $data .= $attr . '="' . $value . '" ';
                    }
                }
                $data .= (($select == $this->items[$item_id]["cat_id"]) ? 'selected="selected"' : '') . '>'
                    . (($parent_id == 0) ? "|--" : '|' . $space . '|-- ')
                    . $this->items[$item_id]["cat_name"] . '</option>';
                $data .= $this->createOption($item_id, $select, $step, $htmlOptions);
            }
        }

        return $data;
    }

    /**
     * Create option of select
     */
    public function createOptionCheckbox($parent_id = 0, $select = null, $step = 0, $htmlOptions = array())
    {
        $data = '';
        $space = '';
        $space = str_repeat("&nbsp;", $step * 6);
        $step++;
        if (isset($this->relations[$parent_id])) {
            foreach ($this->relations[$parent_id] as $item_id) {
                if ($parent_id == 0) {
                    $data .= '<p style="margin:0px;" value="0">|</p>';
                }
                $data .= '<p style="margin:0px;" ';
                if (count($htmlOptions)) {
                    foreach ($htmlOptions as $attr => $value) {
                        $data .= $attr . '="' . $value . '" ';
                    }
                }
                $data .= (($select == $this->items[$item_id]["cat_id"]) ? 'selected="selected"' : '') . '>'
                    . (($parent_id == 0) ? "|--" : '|' . $space . '|-- ')
                    . '<input style="margin:0px;" value="' . $this->items[$item_id]["cat_id"] . '" type="checkbox" name="ShopCategory[]" /> '
                    . $this->items[$item_id]["cat_name"] . '</p>';
                $data .= $this->createOptionCheckbox($item_id, $select, $step, $htmlOptions);
            }
        }

        return $data;
    }

    /**
     * Create option array
     */
    public function createOptionArray($parent_id = 0, $step = 0, &$arr = array('' => '|'))
    {
        $space = '';
        $space = str_repeat(' - ', $step * 2);
        $step++;
        if (isset($this->relations[$parent_id])) {
            foreach ($this->relations[$parent_id] as $item_id) {
                if ($parent_id == 0) {
                    $arr[''] = isset($arr['']) ? $arr[''] : '|';
                }
                $arr['' . $this->items[$item_id]["cat_id"]] = (($parent_id == 0) ? "" : $space) . $this->items[$item_id]["cat_name"];
                $this->createOptionArray($item_id, $step, $arr);
            }
        }
        return $arr;
    }

    public function createBonsaiHtml($parent_id = 0, $step = 0, $data_name = '', $data_checked, &$html = '')
    {
        if (isset($this->relations[$parent_id])) {
            $html .= '<ol id="' . ($step == 0 ? 'auto-checkboxes' : '') . '" data-name="' . $data_name . '[]">';
            $step++;
            foreach ($this->relations[$parent_id] as $item_id) {
                $html .= '<li ' . (in_array($item_id, $data_checked) ? 'data-checked="1"' : '') . ' class="expanded" data-value="' . $item_id . '">&nbsp;&nbsp;' . $this->items[$item_id]["cat_name"];
                $this->createBonsaiHtml($item_id, $step, $data_name, $data_checked, $html);
                $html .= '</li>';
            }
            $html .= '</ol>';
        }
    }

    /**
     * Create option array
     */
    public function createOptionArrayShop($parent_id = 0, $step = 0, &$arr = array('' => '|'), $shop_categories)
    {
        $space = '';
        $space = str_repeat(' - ', $step * 2);
        $step++;
        if (isset($this->relations[$parent_id])) {
            foreach ($this->relations[$parent_id] as $item_id) {
                if (in_array($item_id, $shop_categories)) {
                    if ($parent_id == 0) {
                        $arr[''] = isset($arr['']) ? $arr[''] : '|';
                    }
                    $arr['' . $this->items[$item_id]["cat_id"]] = (($parent_id == 0) ? "" : $space) . $this->items[$item_id]["cat_name"];
                    $this->createOptionArrayShop($item_id, $step, $arr, $shop_categories);
                }
            }
        }
        return $arr;
    }

    /**
     * Create option array
     *
     */
    public function createOptionArrayWithDepth($parent_id = 0, $depth = 1, $options = array(), &$arr = array(0 => '|'), $level = 0)
    {
        $depth = (int)$depth;
        $space = isset($options['space']) ? $options['space'] : '&nbsp;';
        $jump = isset($options['jump']) ? (int)$options['jump'] : 2;
        $str = '';
        for ($i = 0; $i < $level * $jump; $i++) {
            $str .= $space;
        }
        $level++;
        if ($level > $depth)
            return $arr;
        if (isset($this->relations[$parent_id])) {
            foreach ($this->relations[$parent_id] as $item_id) {
                if ($parent_id == 0) {
                    $arr['0'] = isset($arr[0]) ? $arr[0] : '|';
                }
                $arr['' . $this->items[$item_id]["cat_id"]] = (($parent_id == 0) ? "" : $str) . $this->items[$item_id]["cat_name"];
                $this->createOptionArrayWithDepth($item_id, $depth, $options, $arr, $level);
            }
        }
        return $arr;
    }

    /**
     * Create option array
     */
    public function createArrayDataProvider($parent_id = 0, $step = 0, &$arr = array())
    {
        $space = '';
        if ($step != 0) {
            for ($i = 0; $i < 2; $i++) {
                $space .= ' _ ';
            }
        }
        if ($space != '') {
            $space = '|' . $space;
            for ($i = 0; $i < $step * 5; $i++) {
                $space = '&nbsp;' . $space;
            }
        }
        $step++;
        if (isset($this->relations[$parent_id])) {
            foreach ($this->relations[$parent_id] as $item_id) {
                $cate = $this->items[$item_id];
                $cate['cat_name'] = (($parent_id == 0) ? "" : $space) . $cate["cat_name"];
//                if ($parent_id == 0) {
//                    $arr[0] = isset($arr[0]) ? $arr[0] : '|';
//                }
                $arr[$cate["cat_id"]] = $cate;
                $this->createArrayDataProvider($item_id, $step, $arr);
            }
        }
        return $arr;
    }

    /**
     * Create option array
     */
    public function createArrayCategory($parent_id = 0, &$options = array())
    {
        $return = array();
        if (isset($this->relations[$parent_id])) {
            foreach ($this->relations[$parent_id] as $item_id) {
                if ($this->getRoute() == "/economy/productcategory/") {
                    $c_link = Yii::app()->createUrl('/economy/product/category', array('id' => $item_id, 'alias' => $this->items[$item_id]['alias']));
                } else {
                    $c_link = Yii::app()->createUrl($this->getRoute(), array('id' => $item_id, 'alias' => $this->items[$item_id]['alias']));
                }
                $return[$item_id] = $this->items[$item_id];
                $return[$item_id]['link'] = $c_link;
                $return[$item_id]['active'] = self::checkActive($c_link, $item_id, $this->getCategoryType());
                //
                if ($return[$item_id]['active']) {
                    $savetrack = array();
                    $this->saveTrack($item_id, $savetrack);
                    foreach ($savetrack as $tid) {
                        $options['track'][$tid] = $tid;
                    }
                }

                if ( !isset($options['no_parent'])) {
                    $return[$item_id]["children"] = $this->createArrayCategory($item_id, $options);
                }
                //
//                $return[$item_id]["children"] = $this->createArrayCategory($item_id, $options);
                // active parent
                if (isset($options['track'][$item_id])) {
                    $return[$item_id]['active'] = true;
                }
            }
        }
        return $return;
    }

    /**
     * get all chidren of cat_id
     */
    public function getChildrens($cat_id, &$data = array())
    {
        if (isset($this->relations[$cat_id])) {
            foreach ($this->relations[$cat_id] as $item_id) {
                array_push($data, $item_id);
                $this->getChildrens($item_id, $data);
            }
        }
        return $data;
    }

    /**
     * Lấy các con của cat
     * @param type $cat_id
     */
    public function getChildren($cat_id)
    {
        if (isset($this->relations[$cat_id]))
            return $this->relations[$cat_id];
        return array();
    }

    /**
     * Check has children
     */
    public function hasChildren($cat_id)
    {
        if (isset($this->relations[$cat_id]))
            return true;
        if (!count($this->relations) && Yii::app()->db->createCommand()->select('*')->from($this->getCategoryTable())->where('cat_parent=' . $cat_id)->limit(1)->queryRow())
            return true;
        return false;
    }

    /**
     * get category name
     * @param type $cat_id
     */
    public function getCateName($cat_id)
    {
        return isset($this->items[$cat_id]["cat_name"]) ? $this->items[$cat_id]["cat_name"] : '';
    }

    static function getCategoryType()
    {
        return array(
            self::CATEGORY_NEWS => Yii::t('news', 'news_category'),
            self::CATEGORY_JOBS => Yii::t('jobs', 'jobs_category'),
            self::CATEGORY_PRODUCT => Yii::t('product', 'product_category'),
            self::CATEGORY_RENT => Yii::t('rent', 'rent_category'),
            self::CATEGORY_COURSE => Yii::t('course', 'edu_course_categories'),
            self::CATEGORY_EVENT => Yii::t('event', 'eve_event_categories'),
            self::CATEGORY_SERVICE => Yii::t('service', 'service_category'),
            self::CATEGORY_PROMOTION => Yii::t('product', 'promotion_category'),
            self::CATEGORY_PROJECT => Yii::t('product', 'project_category'),
            self::CATEGORY_ALBUMS => Yii::t('album', 'album_category'),
            self::CATEGORY_VIDEO => Yii::t('album', 'video_category'),
            self::CATEGORY_CAR => Yii::t('car', 'car_category'),
        );
    }

    /**
     * check url is active or not
     * @param type $url
     */
    static function checkActive($url = '', $cat_id = '', $type = '')
    {
        $checkUrl = str_replace('/', '', $url);
        $currentUrl = str_replace('/', '', Yii::app()->request->requestUri);
        $return = ($checkUrl == $currentUrl || strpos($currentUrl, $checkUrl) !== false || strpos($checkUrl, $currentUrl) !== false) ? true : false;
        if (!$return && $type == self::CATEGORY_PRODUCT) {
            $return = preg_match("/pc$cat_id/", $currentUrl);
        }
        return $return;
    }

    /**
     * return category info
     * @param type $category_id
     */
    function getItem($category_id = null)
    {
        if (isset($this->items[$category_id])) {
            $item = $this->items[$category_id];
            if (!isset($item['link'])) {
                $route = $this->getRoute();
                $item['link'] = Yii::app()->createUrl($route, array('id' => $item['cat_id'], 'alias' => $item['alias']));
            }
            return $item;
        }
        return false;
    }

    /**
     * remove item
     * @param type $item_id
     */
    function removeItem($item_id)
    {
        if (isset($this->items[$item_id])) {
            $this->relations[$this->items[$item_id]["cat_parent"]] = ClaArray::deleteWithValue($this->relations[$this->items[$item_id]["cat_parent"]], $item_id);
            unset($this->items[$item_id]);
        }
    }

    /**
     * Kiểm tra xem danh mục có tồn tại hay không
     * @param type $cat_id
     */
    function checkCatExist($cat_id)
    {
        if (isset($this->items[$cat_id]))
            return true;
        return false;
    }

    /**
     * return sub category and its info
     * @param type $cat_id
     */
    function getSubCategory($cat_id)
    {
        $children = $this->getChildren($cat_id);
        $cats = array();
        $route = $this->getRoute();
        foreach ($children as $item_id) {
            $item = $this->getItem($item_id);
            if (!$item)
                continue;
            $cats[$item_id] = $item;
            $cats[$item_id]['link'] = Yii::app()->createUrl($route, array('id' => $item_id, 'alias' => $item['alias']));
        }
        return $cats;
    }

    /**
     * return sub category and its info
     * @param type $cat_id
     */
    function getTrackCategory($cat_id)
    {
        $track = $this->saveTrack($cat_id);
        $track = array_reverse($track);
        $cats = array();
        $route = $this->getRoute();
        foreach ($track as $item_id) {
            $item = $this->getItem($item_id);
            if (!$item)
                continue;
            $cats[$item_id] = $item;
            $cats[$item_id]['link'] = Yii::app()->createUrl($route, array('id' => $item_id, 'alias' => $item['alias']));
        }
        return $cats;
    }

    static function getAllProductCategoryPage($options = array())
    {
        $result = array();
        $site_id = Yii::app()->controller->site_id;
        $limit = isset($options['limit']) ? $options['limit'] : ActiveRecord::DEFAUT_LIMIT;
        $data = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('product_categories'))
            ->where('site_id=' . $site_id)
            ->limit($limit)
            ->queryAll();
        foreach ($data as $page) {
            $result[$page['cat_id']] = $page;
        }
        return $result;
    }

    static function getBannerFromCatId($cat_id)
    {
        $banner = array();
        $reg_cat = 'ppage_' . $cat_id;
        $site_id = Yii::app()->controller->site_id;
        $conditions = "site_id = $site_id AND actived = " . ActiveRecord::STATUS_ACTIVED . " AND MATCH (banner_rules) AGAINST ('" . $reg_cat . "' IN BOOLEAN MODE)";
        if (isset($cat_id) && $cat_id != 0) {
            $banner = Yii::app()->db->createCommand()
                ->select('*')
                ->from(ClaTable::getTable('banners'))
                ->where($conditions)
                ->limit(3)
                ->queryAll();
        }
        return $banner;
    }

    function getCacheKey($language = '')
    {
        if (!$language) {
            $language = ClaSite::getLanguageTranslate();
        }
        return $this->cacheKey . Yii::app()->controller->site_id . $language;
    }

    function getExpireCacheTime()
    {
        return $this->expireCacheTime;
    }

    function deleteCache($language = '')
    {
        return Yii::app()->cache->delete($this->getCacheKey($language));
    }

}
