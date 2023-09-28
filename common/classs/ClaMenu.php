<?php

/*
 * @author minhbn <minhcoltech@gmail.com>
 * @date 28-03-2014
 * Class for create and show menu
 *
 */

class ClaMenu {

    //
    const MENU_ROOT = 0;
    const MENU_BEGIN_STEP = 0;

    //
    public $items = array(); // list category
    public $relations = array(); // list menu relations array('parent'=>'list children');
    protected $dbname = '';
    public $type = '';   // Type of category such as: news, video,...
    public $route = '';
    public $application = 'backoffice';
    public $group_id = 0;
    protected $showAll = false; // Hiển thị tất cả các trạng thái
    protected $expireCacheTime = 28800; // Cache 8h
    protected $cacheKey = 'MenuCache';

    /**
     * construct
     */
    function __construct($options = array()) {
        if (isset($options['group_id']))
            $this->group_id = $options['group_id'];
        if (isset($options['showAll']))
            $this->showAll = $options['showAll'];
        if (isset($options['create']) && $options['create'] === true) {
            $this->generateMenu();
        }
    }

    //Khởi tạo data chứa các menu
    function generateMenu() {
        if (!$this->group_id)
            return;
        // --------------------------------------------------- process data -------------------------------------------------
        $data = array('items' => array(), 'relations' => array());
        $dataread = Yii::app()->cache->get($this->getCacheKey());
        if (!$dataread) {
            //
            $dbname = $this->getMenuTable();
            $site_id = Yii::app()->controller->site_id;
            //
//        $dataread = Yii::app()->db->createCommand("SELECT menu_id,menu_title,menu_group,parent_id,alias,menu_linkto,menu_link,menu_basepath,menu_pathparams,menu_target,menu_order,status,icon_path,icon_name,background_path,background_name,description FROM $dbname WHERE site_id=$site_id AND menu_group={$this->group_id} " . (($this->showAll) ? '' : 'AND status=' . ActiveRecord::STATUS_ACTIVED . ' ') . "ORDER BY menu_order")
//                ->queryAll();
            $conditions = 'site_id=:site_id AND menu_group=:menu_group';
            $params = array(
                ':site_id' => $site_id,
                ':menu_group' => $this->group_id
            );
            if (!$this->showAll) {
                $conditions .= ' AND status=:status';
                $params[':status'] = ActiveRecord::STATUS_ACTIVED;
            }
            // add condition store
            if (Yii::app()->getId() == 'public' && isset(Yii::app()->siteinfo['multi_store']) && Yii::app()->siteinfo['multi_store'] == 1) {
                $store_id = (isset($_SESSION['store']) && $_SESSION['store']) ? $_SESSION['store'] : 0;
                if ($store_id == 0) {
                    if (isset(Yii::app()->siteinfo['store_default']) && Yii::app()->siteinfo['store_default']) {
                        $store_id = Yii::app()->siteinfo['store_default'];
                    }
                }
                $conditions .= " AND store_ids LIKE '%" . $store_id . "%'";
            }
            $dataread = Yii::app()->db->createCommand()->select()
                ->from($dbname)
                ->where($conditions, $params)
                ->order('menu_order ASC')
                ->queryAll();
            if ($dataread) {
                Yii::app()->cache->set($this->getCacheKey(), $dataread, $this->getExpireCacheTime());
            }
            // end cache
        }
        if ($dataread) {
            foreach ($dataread as $menu_item) {
                // ignore these menus is hided
                if (!$this->showAll && isset($menu_item['status']) && $menu_item['status'] == Menus::STATUS_DEACTIVED) {
                    continue;
                }
                //
                $data['items'][$menu_item['menu_id']] = $menu_item;
                $menu_pathparams = array();
                //
                if ($menu_item['menu_pathparams']) {
                    $menu_pathparams = json_decode($menu_item['menu_pathparams'], true);
                }
                //
                if (!$menu_pathparams) {
                    $menu_pathparams = array();
                }
                //
                if ($menu_item['menu_pathparams'] && !$menu_pathparams && !$menu_item['menu_basepath'] && $menu_item['menu_linkto'] == Menus::LINKTO_INNER) {
                    $data['items'][$menu_item['menu_id']]['menu_link'] = Yii::app()->homeUrl;
                } elseif (($menu_item['menu_pathparams']) && $menu_item['menu_linkto'] == Menus::LINKTO_INNER) {
                    $data['items'][$menu_item['menu_id']]['menu_link'] = Yii::app()->createUrl($menu_item['menu_basepath'], $menu_pathparams);
                } elseif ($menu_item['menu_linkto'] == Menus::LINKTO_INNER) {
                    $data['items'][$menu_item['menu_id']]['menu_link'] = 'javascript:void(0)';
                } elseif ($menu_item['menu_link']) {
                    $data['items'][$menu_item['menu_id']]['menu_link'] = $menu_item['menu_link'];
                } else {
                    $data['items'][$menu_item['menu_id']]['menu_link'] = 'javascript:void(0)';
                }
                //
                $data['relations'][$menu_item['parent_id']][] = $menu_item['menu_id'];
            }
        }

        // --------------------------------------------------- end process data -------------------------------------------------
        $this->items = $data['items'];
        $this->relations = $data['relations'];
    }

    /**
     * get category table in db
     */
    public function getMenuTable() {
        if ($this->dbname == '') {
            $this->dbname = ClaTable::getTable('menu');
        }
        return $this->dbname;
    }

    /**
     * Set table name
     * @param type $table
     */
    public function setMenuTable($table = '') {
        $this->dbname = $table;
    }

    /**
     * Get list categories item
     */
    public function getListItems() {
        return $this->items;
    }

    /**
     * Get list categories relations
     */
    public function getRelations() {
        return $this->relations;
    }

// Đệ quy tạo ra một menu
    public function createMenu($parent_id, &$options = array()) {
        $return = array();
        if (isset($this->relations[$parent_id])) {
            $currenturl = Yii::app()->request->getRequestUri();
            $fullurl = Yii::app()->request->getHostInfo() . $currenturl;
            foreach ($this->relations[$parent_id] as $item_id) {
                $m_link = $this->items[$item_id]['menu_link'];
                $return[$item_id]['menu_title'] = $this->items[$item_id]['menu_title'];
                $return[$item_id]['icon_path'] = $this->items[$item_id]['icon_path'];
                $return[$item_id]['icon_name'] = $this->items[$item_id]['icon_name'];
                $return[$item_id]['background_path'] = $this->items[$item_id]['background_path'];
                $return[$item_id]['background_name'] = $this->items[$item_id]['background_name'];
                $return[$item_id]['description'] = $this->items[$item_id]['description'];
                $return[$item_id]['store_ids'] = $this->items[$item_id]['store_ids'];
                $return[$item_id]['menu_link'] = $m_link;
                $return[$item_id]['target'] = Menus::getTarget($this->items[$item_id]);
                //
                $return[$item_id]['active'] = false;
                //
                if ($this->items[$item_id]['menu_linkto'] == Menus::LINKTO_OUTER) {
                    $return[$item_id]['active'] = ($m_link == $fullurl || $m_link == $currenturl) ? true : false;
                } else {
                    $return[$item_id]['active'] = Menus::checkActive($m_link, array('currenturl' => $currenturl,'item'=>$this->items[$item_id]));
                }
                //
                if ($return[$item_id]['active']) {
                    $savetrack = array();
                    $this->saveTrack($item_id, $savetrack);
                    foreach ($savetrack as $tid) {
                        $options['track'][$tid] = $tid;
                    }
                }
                //
                $return[$item_id]['items'] = $this->createMenu($item_id, $options);
                // active parent
                if (isset($options['track'][$item_id])) {
                    $return[$item_id]['active'] = true;
                }
            }
        }
        return $return;
    }

    public function createMenu2($parent_id, $htmlOptions = array()) {
        $data = '';
        if (isset($this->relations[$parent_id])) {
            $data = ($parent_id == self::CATEGORY_ROOT) ? '<ul class="nav">' : '<ul class="sub-menu" style="overflow: hidden; height: auto; padding-top: 0px; display: none; margin-top: 0px; margin-bottom: 0px; padding-bottom: 0px;">';
            foreach ($this->relations[$parent_id] as $item_id) {
                $url = ($this->items[$item_id]['menu_link'] != '') ? $this->items[$item_id]['menu_link'] : Yii::app()->createUrl($this->items[$item_id]['menu_basepath'], json_decode($this->items[$item_id]['menu_pathparams'], true));
                $data .= '<li>'
                    . '<a href="' . $url . '">' . $this->items[$item_id]['menu_title'] . '</a>';

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
     * Save track
     * @param type $id
     * @param type $savetrack
     */
    public function saveTrack($id, &$savetrack = array()) {
        if ($id != 0 && isset($this->items[$id]["menu_id"])) {
            $savetrack[] = $this->items[$id]["menu_id"];
            $this->saveTrack($this->items[$id]["parent_id"], $savetrack);
        }
        return $savetrack;
    }

    /**
     * Create option of select
     */
    public function createOption($parent_id = 0, $select = null, $step = 0, $htmlOptions = array()) {
        $data = '';
        $space = '';
        for ($i = 0; $i < $step * 3; $i++) {
            $space.="&nbsp;";
        }
        $step++;
        if (isset($this->relations[$parent_id])) {
            foreach ($this->relations[$parent_id] as $item_id) {
                if ($parent_id == 0) {
                    $data.='<option value="0">|</option>';
                }
                $data .= '<option value="' . $this->items[$item_id]["menu_id"]
                    . '" ';
                if (count($htmlOptions)) {
                    foreach ($htmlOptions as $attr => $value) {
                        $data.= $attr . '="' . $value . '" ';
                    }
                }
                $data.=(($select == $this->items[$item_id]["menu_id"]) ? 'selected="selected"' : '') . '>'
                    . (($parent_id == 0) ? "|--" : '|' . $space . '|-- ')
                    . $this->items[$item_id]["menu_title"] . '</option>';
                $data.= $this->createOption($item_id, $select, $step, $htmlOptions);
            }
        }

        return $data;
    }

    /**
     * Create option array
     */
    public function createOptionArray($parent_id = 0, $step = 0, &$arr = array(0 => '|')) {
        $space = '';
        for ($i = 0; $i < $step * 3; $i++) {
            $space.=' - ';
        }
        $step++;
        if (isset($this->relations[$parent_id])) {
            foreach ($this->relations[$parent_id] as $item_id) {
                if ($parent_id == 0) {
                    $arr['0'] = isset($arr[0]) ? $arr[0] : '|';
                }
                $arr['' . $this->items[$item_id]["menu_id"]] = (($parent_id == 0) ? "" : $space) . $this->items[$item_id]["menu_title"];
                $this->createOptionArray($item_id, $step, $arr);
            }
        }
        return $arr;
    }

    /**
     * Create option array
     */
    public function createArrayDataProvider($parent_id = 0, $step = 0, &$arr = array()) {
        $space = '';
        if ($step != 0) {
            for ($i = 0; $i < 2; $i++) {
                $space.=' _ ';
            }
        }
        if ($space != '') {
            $space = '|' . $space;
            for ($i = 0; $i < $step * 5; $i++) {
                $space = '&nbsp;' . $space;
            }
        }
        $step ++;
        if (isset($this->relations[$parent_id]) && $this->relations[$parent_id]) {
            foreach ($this->relations[$parent_id] as $item_id) {
                $menu = $this->items[$item_id];
                $menu['menu_title'] = (($parent_id == 0) ? "" : $space) . $menu["menu_title"];
                $arr[$menu["menu_id"]] = $menu;
                $this->createArrayDataProvider($item_id, $step, $arr);
            }
        }
        return $arr;
    }

    /**
     * remove item
     * @param type $item_id
     */
    function removeItem($item_id) {
        if (isset($this->items[$item_id])) {
            $this->relations[$this->items[$item_id]["parent_id"]] = ClaArray::deleteWithValue($this->relations[$this->items[$item_id]["parent_id"]], $item_id);
            unset($this->items[$item_id]);
        }
    }

    function getCacheKey($language = '', $store = '') {
        if (!$language) {
            $language = ClaSite::getLanguageTranslate();
        }
        // save cache follow store
        if (!$store) {
            $store = '';
            if (Yii::app()->getId() == 'public' && isset(Yii::app()->siteinfo['multi_store']) && Yii::app()->siteinfo['multi_store'] == 1) {
                $store_id = (isset($_SESSION['store']) && $_SESSION['store']) ? $_SESSION['store'] : 0;
                if ($store_id == 0) {
                    if (isset(Yii::app()->siteinfo['store_default']) && Yii::app()->siteinfo['store_default']) {
                        $store_id = Yii::app()->siteinfo['store_default'];
                    }
                }
                $store = $store_id;
            }
        }
        $key = $this->cacheKey . Yii::app()->controller->site_id . $store . $language . $this->group_id;
        return $key;
    }

    function getExpireCacheTime() {
        return $this->expireCacheTime;
    }

    function deleteCache($language = '', $store = '') {
        return Yii::app()->cache->delete($this->getCacheKey($language, $store));
    }

}
