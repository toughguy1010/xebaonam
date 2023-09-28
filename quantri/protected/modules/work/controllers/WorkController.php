<?php

class WorkController extends Controller {

    public $limit_record = 15;
    public $work_related = 8;
    public $layout = 'work';
    public $currency_array = array("1" => "(VND/tháng)", '2' => '(USD/tháng)');

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view', 'search'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'myjob', 'delete', 'GetAInfo', 'sAjax', 'companyname'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * nguyenthang
     * return lưu lại thông tin tìm kiếm 
     */
    public function beforeAction($action) {
        $cs = Yii::app()->clientScript;
        //$cs->registerCssFile(Yii::app()->baseUrl . '/css/work/work_style.css');
        //$cs->registerCssFile(Yii::app()->baseUrl . '/css/work/work_gridview.css');
$cs->registerCssFile(Yii::app()->baseUrl . '/css/work.css');
        //$cs->registerCssFile(Yii::app()->baseUrl . '/css/work/style.css');
        //$cs->registerScriptFile(Yii::app()->baseUrl . '/javascripts/jquery.masonry.min.js');
//        $cs->registerCssFile(Yii::app()->baseUrl . '/css/work/blog.css');
//        $cs->registerCssFile(Yii::app()->baseUrl . '/css/work/feed.css');
//        $cs->registerCssFile(Yii::app()->baseUrl . '/css/work/index.css');
//        $cs->registerCssFile(Yii::app()->baseUrl . '/css/work/ketban.css');

        if ($action->id == 'view') {
            $check = RecruitmentNews::model()->findByPk($_GET['id']);
            if ($check != null && is_numeric($_GET['id'])) {
                $item_id = $_GET['id'] . 'count';
                if (!Yii::app()->session->isStarted) {
                    Yii::app()->session->open();
                }
                if (!isset(Yii::app()->session[$item_id])) {  //  nếu chưa khởi tạo session
                    Yii::app()->session[$item_id] = 1;  // khởi tại session
                    $obj_recruitNews = RecruitmentNews::model()->findByPk((int) $item_id);
                    $obj_recruitNews->view = $obj_recruitNews->view + 1;
                    $obj_recruitNews->save(false);
                }
            }
        }
        if ($action->id == 'index' || $action->id == 'view' || $action->id == 'search') {
            $cs->registerScriptFile(Yii::app()->baseUrl . '/javascripts/work/jquery.styleSelect.js', CClientScript::POS_HEAD);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/javascripts/jquery.masonry.min.js', CClientScript::POS_HEAD);
            $cs->registerScriptFile(Yii::app()->baseUrl . '/javascripts/work/script.js', CClientScript::POS_HEAD);

            if ($action->id == "search" && !Yii::app()->user->isGuest) {   // lưu lại tác vụ vừa tìm kiếm hay không 
                if (!isset(Yii::app()->request->cookies['search_item'])) {
                    $cookie = new CHttpCookie('search_item', 1);
                    $cookie->expire = time() + (30 * 24 * 60 * 60); // 30 days
                    Yii::app()->request->cookies['search_item'] = $cookie;
                }
            }
        }
        if ($action->id == 'view') {
            $cs->registerScriptFile(Yii::app()->baseUrl . '/javascripts/jquery.masonry.min.js', CClientScript::POS_HEAD);
        }

        $cs->registerScriptFile(Yii::app()->baseUrl . '/javascripts/work/work.js', CClientScript::POS_HEAD);
        $cs->registerScriptFile(Yii::app()->baseUrl . '/javascripts/tiny_mce/tiny_mce.js');

        return true;
    }

    /**
     * thangnguyen
     * @ hien thi muc luong cua tin dang
     */
    public function getSalary($data) {
        if ($data->payrate == '0') {
            $content = $data->salary_min . ' - ' . $data->salary_max . $this->currency_array[$data->currency];
            return $content;
        } else if ($data->payrate) {
            return Yii::app()->params['payrate'][$data->payrate];
        }
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {

        $related = $this->getWorkRelated();

        $model = $this->loadModel($id);   // chi tiết tin 
        $company_obj = Companies::model()->findByPk($model->company_id);
        $item_users = array();
        $news_id = '';
        if ($model->user_id) {

            $item_users = $this->sameUser($model->user_id, $model->news_id);
            if (count($item_users)) {
                foreach ($item_users as $k => $item_user) {
                    $news_id.=$item_user["news_id"] . ",";
                }
            }
        }
        $news_id.=$model->news_id;
        $data = $this->sameGroup($model->trade_id, $news_id);
        $sameGroup = $data["data"];
        $count = $data["count"];
        $pages = $data["page"];
        /*
         * trades group
         */


        /*
         * cac tin viec lam lien quan theo nguoi tao
         */
//        /$work_related = RecruitmentNews::model()->find('user_id = :user_id',array(':user_id'=>$model->user_id));/
        $work_related_byuser = Yii::app()->db->createCommand()
                ->select('news_id,position')
                ->from('lov_recruitment_news')
                ->where('user_id = :user_id AND company_id = :company_id', array(':user_id' => $model->user_id, ':company_id' => $model->company_id))
                ->order('news_id DESC')
                ->limit(5)
                ->queryAll();

        $this->render('view', array(
            'model' => $model,
            'work_related_byuser' => $work_related_byuser,
            'item_users' => $item_users,
            'sameGroup' => $sameGroup,
            'pages' => $pages,
            'count' => $count,
            'work_related' => $related,
            'company_obj' => $company_obj
        ));
    }

    /**
     * thangnguyen
     * return cong viec cung nguoi dang
     */
    public function sameUser($user_id, $id) {

        $data = RecruitmentNews::model()->findAll('user_id =:user_id and news_id != :news_id and  expiryday >=CURDATE() order by createdate DESC', array(':user_id' => $user_id, ':news_id' => $id));
        return $data;
    }

    /*
     * thang
     * return việc làm khác cùng nghanh nghe
     */

    public function sameGroup($trade_id, $id = '') {

        $trade_array = explode(",", $trade_id);
        $condition = "1=1";
        $params = array();

        foreach ($trade_array as $k => $trade) {
            if ($k == '0') {
                $condition.=" and ( FIND_IN_SET(" . $trade . ",new.trade_id)";
            } else {
                $condition .=" or FIND_IN_SET(" . $trade . ",new.trade_id)";
            }
        }
        $condition.=" or 1>2 )";

        if ($id != '') {
            $condition .=" and new.news_id not IN (" . $id . ")";
        }
        //die($condition);
        $count = $this->getTotal($condition, $params);
        $pages = new CPagination($count);
        $pages->pageSize = $this->limit_record;
        $offset = isset($_REQUEST['page']) ? ((int) $_REQUEST['page'] - 1) * $this->limit_record : '0';
        $item["data"] = $this->getList($condition, $params, $offset);
        $item["count"] = $count;
        $item["page"] = $pages;
        return $item;
    }

    public function getList($condition, $params, $offset = 0) {

        $result = Yii::app()->db->createCommand()
                ->select('new.position,new.createdate,new.news_id,new.provinces,new.company_id,new.company_name')
                ->from('lov_recruitment_news new')
                ->where($condition, $params)
                ->order('createdate DESC')
                ->limit($this->limit_record)
                ->offset($offset)
                ->queryAll();

        return $result;
    }

    // return numerical not . or ,
    function replace($string) {
        return str_replace(array(',', '.'), '', $string);
    }

    // work page default
    public function actionIndex() {
        // Trade news list 
        $model = new RecruitmentNews;


        // Hot trades groups

        $condition = "1=1";
        $params = array();

        $offset = isset($_REQUEST['page']) ? ((int) $_REQUEST['page'] - 1) * $this->limit_record : '0';
        $models = $this->getList($condition, $params, $offset);

        // có thể bạn quan tâm group (interested working)
        //$related = $this->getWorkRelated();

        // page render

        $count = $this->getTotal($condition, $params);

        $pages = new CPagination($count);
        $pages->pageSize = $this->limit_record;
        $pages->route = '/work/work/index';

        //echo var_dump($region2);
        $this->render('index', array(
            'model' => $model,
            'models' => $models,
            'pages' => $pages, // widget linkpager 
            'work_related' => $related, // có thể bạn quan tâm
            'count' => $count,
        ));
    }

    /*
     * @phong
     * 
     */
    /*
     * get Trades group
     */

    public function Gettradesgroup() {
        $trade_group = Yii::app()->db->createCommand()
                ->select('group_id,group_name,')
                ->from('lov_trade_groups')
                ->order('sort DESC')
                ->queryAll();
        return $trade_group;
    }

    /*
     * get trades
     */

    public function Gettrades($id) {
        $trades = Yii::app()->db->createCommand()
                ->select('trade_id,trade_name,count_news')
                ->from('lov_trades')
                ->where('group_id = ' . $id)
                ->queryAll();
        return $trades;
    }

    /*
     * get region by land
     */

    public function GetregionByLand() {

        $region = Yii::app()->db->createCommand(array(
                    'select' => array('region_id', 'default_name', 'land_id'),
                    'from' => 'lov_country_region',
                    'where' => 'country_id=:country_id',
                    'params' => array(':country_id' => 'VN'),
                    'order' => 'sort',
                ))->queryAll();

        return $region;
    }

    /*
     * get region by work news region
     */

    public function Getregionbynews($string) {
        $new_string = preg_replace("/,$/", '', $string);
        $region = Yii::app()->db->createCommand(array(
                    'select' => array('region_id', 'default_name', 'land_id'),
                    'from' => 'lov_country_region',
                    'where' => 'region_id IN (' . $new_string . ')',
//                    /'params'=>array(':region' => $new_string),
                    'order' => 'sort',
                ))->queryAll();
        return $region;
    }

    public function actionsearch() {

        $model = new RecruitmentNews;
        $obj_recruitment = new RecruitmentNews();
        // condition true
        $condition = "1=1";
        $params = array();
        $searchbyuser = 0;

        if (isset($_GET['provinces']) && $_GET['provinces'] != '') {
            $condition.=" and FIND_IN_SET(:region_id,provinces)";

            $params[':region_id'] = $_GET['provinces'];
            $model->provinces = $_GET['provinces'];
        }
        if (isset($_GET['industry']) && $_GET['industry'] != '') {
            $condition.=" and FIND_IN_SET(:trade_id,new.trade_id)";
            $params[':trade_id'] = $_GET['industry'];
            $model->trade_id = $_GET['industry'];
        }
        if (isset($_GET['day']) && $_GET['day'] != '') {
            $d = $_GET['day'];
            $condition.=" and createdate >= :createdate";
            $params[':createdate'] = date("Y-m-d", strtotime("- $d days"));
            $model->createdate = $_GET['day'];
        }
        if (isset($_GET['type']) && $_GET['type'] != '') {
            $condition.=" and new.typeofwork =:typeofwork";
            $params[':typeofwork'] = $_GET['type'];
            $model->typeofwork = $_GET['type'];
        }
        if (isset($_GET['exp']) && $_GET['exp'] != '') {
            $condition.=" and new.experience =:experience";
            $params[':experience'] = $_GET['exp'];
            $model->experience = $_GET['exp'];
        }
        if (isset($_GET['createdby']) && $_GET['createdby'] != '') {

            $condition.=" and user_id=2";
            $params[':user_id'] = $_GET['createdby'];
            $model->user_id = $_GET['createdby'];
            $searchbyuser = $_GET['createdby'];
            ;
        }
        else
            $condition .="  and expiryday>=CURDATE() ";

        // page render
        $criteria = new CDbCriteria();
        $count = $this->getTotal($condition, $params);
        $pages = new CPagination($count);
        $pages->pageSize = $this->limit_record;
        $pages->route = '/work/work/search';
        $offset = isset($_REQUEST['page']) ? ((int) $_REQUEST['page'] - 1) * $this->limit_record : '0';

        $obj_recruitment = $this->getList($condition, $params, $offset);

        // có thể bạn quan tâm group (interested working)
        $related = $this->getWorkRelated();

        $this->render('search', array(
            'model' => $model,
            'searchbyuser' => $searchbyuser,
            'obj_recruitment' => $obj_recruitment,
            'pages' => $pages,
            'count' => $count, // widget linkpager 
            'work_related' => $related, // có thể bạn quan tâm
        ));
    }

    /*
     * thangnguyencn
     * thứ tự theo ngành nghề người đăng nhập, theo tiêu chí họ tìm kiếm
     * return tin tức liên quan
     */

    function getWorkRelated() {
        // có thể bạn quan tâm group (interested working)
        $work_related = "select a.* from lov_recruitment_news a ";
        $work_related .=" where 1=1 ";
        $work_related .=" and  expiryday >=CURDATE() ";
        if (Yii::app()->user->id) { // user authentication
            $user_id = Yii::app()->user->id;

            $query = "select b.trade_id  from lov_user_company b ";
            $query .=" where b.user_id=$user_id";
            $trade_ids = Yii::app()->db->createCommand($query)->queryAll();

            $c = 0;
            foreach ($trade_ids as $trade) {
                if ($trade["trade_id"]) {   // nếu # null
                    $c++;
                    if ($c == '1')
                        $work_related.=" ORDER BY trade_id=" . $trade["trade_id"] . " DESC ";
                    else
                        $work_related.=", trade_id=" . $trade["trade_id"] . " DESC ";
                }
            }
            if ($c > 0)
                $work_related.=",view DESC,createdate DESC limit 8";
            else
                $work_related.="ORDER BY view DESC,createdate DESC limit 8";
        }
        else {
            $work_related .=" order by view DESC,createdate DESC limit 8";
        }

        $related = Yii::app()->db->createCommand($work_related)
                ->queryAll();
        return $related;
    }

    /*
     * thangnguyencn
     * return total of record
     */

    function getTotal($conditions, $params = array()) {
        $conditions .=" and expiryday >=CURDATE() ";
        $result = Yii::app()->db->createCommand()
                ->select('count(*) as count')
                ->from('lov_recruitment_news new')
                ->where($conditions, $params)
                ->queryAll();

        return $result[0]['count'];
    }

    /**
     * return : các tỉnh thành của VietNam 
     */
    public function getRegion($region_id = '') {
        if ($region_id != '') {
            $region_id = trim($region_id, ",");
            $provinces = "";
            $region = CountryRegion::model()->findAll("country_id=:country_id and region_id IN(" . $region_id . ")", array(':country_id' => 'VN'));
            if ($count = count($region)) {
                foreach ($region as $k => $region) {
                    $provinces.=$region['default_name'];
                    if ($k < $count - 1)
                        $provinces.=",";
                }
            }
            return $provinces;
        }
        else {

            $region = CountryRegion::model()->findAll('country_id=:country_id', array(':country_id' => 'VN'));
            return $region;
        }
    }

   

    /**
     * nguyenthang
     * @ get trade
     */
    public function getTrade() {
        $query = "select trade_id,trade_name from lov_trades";
        $data = Yii::app()->db->createCommand($query)->queryAll();
        return $data;
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
//    public function actionCheckCompany(){
//        $user_id = Yii::app()->user->id;
//        $obj_uCompany = Yii::app()->db->createCommand()
//                ->select('uc.id,uc.desc,user_id,uc.company_id,uc.company_name,region.default_name')
//                ->from('lov_user_company uc')
//                ->join('lov_companies company', 'company.company_id=uc.company_id')
//                ->leftJoin('lov_country_region region', 'region.region_id=uc.region_id')
//                ->where('user_id=:user_id OR company.user_create=:user_create', array(':user_id' => $user_id, 'user_create' => $user_id))
//                ->queryAll();
//        return  $obj_uCompany;
//    }
    public function actionCreate() {


        $user_id = Yii::app()->user->id;
        $obj_uCompany = Yii::app()->db->createCommand()
                ->select('uc.id,uc.desc,user_id,uc.company_id,uc.company_name,region.default_name')
                ->from('lov_user_company uc')
                ->join('lov_companies company', 'company.company_id=uc.company_id')
                ->leftJoin('lov_country_region region', 'region.region_id=uc.region_id')
                ->where('user_id=:user_id OR company.user_create=:user_create', array(':user_id' => $user_id, 'user_create' => $user_id))
                ->queryAll();

        if ($obj_uCompany != null) {// check data exist or not
            $model = new RecruitmentNews();
            $this->performAjaxValidation($model);
            // Region List
            $region = $this->getRegion();
            $region_array = array();
            foreach ($region as $regions) {
                $region_array[$regions['region_id']] = $regions['default_name'];
            }
            // trade categories
            $trade_group = Trade::model()->findAll();
            $trade_array = array();
            foreach ($trade_group as $trade) {
                $trade_array[$trade['trade_id']] = $trade['trade_name'];
            }


            // lấy danh sách công ty từ bảng lov_user_company
            //$obj_uCompany	=UserCompany::model()->findAll('user_id=:user_id',array(':user_id'=>$user_id));	
            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if (isset($_POST['RecruitmentNews'])) {



                $model->unsetAttributes();
                $model->attributes = $_POST['RecruitmentNews'];
                /*
                 * html encode
                 */
                $model->company_name = CHtml::encode($_POST['RecruitmentNews']['company_name']);
                $model->company_address = CHtml::encode($_POST['RecruitmentNews']['company_address']);
                //$model->company_info = htmlentities($_POST['RecruitmentNews']['company_info'], ENT_QUOTES, "UTF-8");
                //$model->position = htmlentities($_POST['RecruitmentNews']['position'], ENT_QUOTES, "UTF-8");
                $model->position = CHtml::encode($_POST['RecruitmentNews']['position']);
                // $model->includes = htmlentities($_POST['RecruitmentNews']['includes'], ENT_QUOTES, "UTF-8");
                // $model->description = htmlentities($_POST['RecruitmentNews']['description'], ENT_QUOTES, "UTF-8");
                $model->username = CHtml::encode($_POST['RecruitmentNews']['username']);
                $model->email = CHtml::encode($_POST['RecruitmentNews']['email']);
                $model->address = CHtml::encode($_POST['RecruitmentNews']['address']);
                $model->website = CHtml::encode($_POST['RecruitmentNews']['website']);
                /*
                 * 
                 */
                $model->salary_min = (int) $this->replace($_POST['RecruitmentNews']['salary_min']);
                $model->salary_max = (int) $this->replace($_POST['RecruitmentNews']['salary_max']);
                $model->createdate = date("Y-m-d h:i:s");

//                $model->options = $_POST['RecruitmentNews']["options"][0];
//                if ($model->options == 2) {
//                    $model->scenario = "company_other";
//                    $model->company_id = 'NULL';
//                }
                //  Userid who post recruiment
                if ($model->validate()) {

                    if ($model->company_id) {
                        $model->company_name = Yii::app()->db->createCommand()
                                ->select("company_name")
                                ->from("lov_companies")
                                ->where("company_id=:com_id", array(":com_id" => $model->company_id))
                                ->queryScalar();
                    }

                    if (empty($model->expiryday)) {
                        $model->expiryday = date("Y-m-d", (time() + 30 * 24 * 3600));
                    } else {
                        $model->expiryday = date("Y-m-d", strtotime($model->expiryday));
                    }
                    /* kiem tra quyen admin cua nguoi dung cua cong ty do */

                    //  $check = Companies::model()->findAll(array('condition'=>'company_id = '.$model->company_id.' AND listusers LIKE "%i:'.$user_id.';a:1:{i:1;i:1;}%" OR user_create = '.$user_id.' AND company_id = '.$model->company_id));

                    /* ket thuc kiem tra */
                    $model->provinces = implode(',', $_POST['RecruitmentNews']['provinces']);
                    $model->trade_id = implode(',', $_POST['RecruitmentNews']['trade_id']);
                    //	$model->payrate="payrate=".$model->attributes['payrate'];
                    //$model->payrate.="&currency=".$model->currency;
                    if (Yii::app()->user->id) {
                        $model->user_id = Yii::app()->user->id;
                    }
                    $model->alias = HtmlFormat::parseToAlias($model->position);
                    // if ($check != null) {//kiem tra admin role
                    if ($model->save(false)) {
                        Yii::app()->user->setFlash('success', 'Đăng tin tuyển dụng thành công!');
                        $this->redirect(array('work/myjob'));
                    }
//                    } else {
//                        Yii::app()->user->setFlash('error', 'Bạn chưa phải là admin của công ty ' . $model->company_name . '. Hãy chọn công ty khác hay liên hệ với admin của công ty đó');
//                        $this->redirect(array('create'));
//                    }
                }
                // format number
                $model->salary_min = number_format($model->salary_min, 0, ',', '.');
                $model->salary_max = number_format($model->salary_max, 0, ',', '.');
            }



            $this->render('create', array(
                'model' => $model,
                'region' => $region_array,
                'trade' => $trade_array,
                'obj_uCompany' => $obj_uCompany, // the user's company into profile
                'currency_array' => $this->currency_array, // vnd,usd
            ));
        } else {
            Yii::app()->user->setFlash('warring', 'Bạn chưa có quyền đăng tin tuyển dụng!');
            $this->redirect(array('index'));
            //echo $this->show_alert('Bạn chưa có quyền tạo tin tuyển dụng! Hãy đăng ký công ty hay là admin của công!', '.../jobs.html');
        }
//       
    }

    /*
     * update
     */

    public function actionUpdate($id) {

        $model = $this->loadModel($id);
        $model->trade_id = explode(',', $model->trade_id);
        $model->provinces = explode(',', $model->provinces);
        $model->expiryday = $this->cut_time($model->expiryday);

        $company = Companies::model()->findByPk($model->company_id);
        $model->company_address = $company->company_address;
        $model->company_info = $company->company_info;

        $user_id = Yii::app()->user->id;
        $obj_uCompany = Yii::app()->db->createCommand()
                ->select('uc.id,uc.desc,user_id,uc.company_id,uc.company_name,region.default_name')
                ->from('lov_user_company uc')
                ->join('lov_companies company', 'company.company_id=uc.company_id')
                ->leftJoin('lov_country_region region', 'region.region_id=uc.region_id')
                ->where('user_id=:user_id OR company.user_create=:user_create', array(':user_id' => $user_id, 'user_create' => $user_id))
                ->queryAll();



        // Region List
        $region = $this->getRegion();
        $region_array = array();
        foreach ($region as $regions) {
            $region_array[$regions['region_id']] = $regions['default_name'];
        }
        // trade categories
        $trade_group = Trade::model()->findAll();
        $trade_array = array();
        foreach ($trade_group as $trade) {
            $trade_array[$trade['trade_id']] = $trade['trade_name'];
        }


        if (isset($_POST['RecruitmentNews'])) {



            // $model->unsetAttributes();
            $model->attributes = $_POST['RecruitmentNews'];


            $model->salary_min = (int) $this->replace($_POST['RecruitmentNews']['salary_min']);
            $model->salary_max = (int) $this->replace($_POST['RecruitmentNews']['salary_max']);
            //$model->createdate = date("Y-m-d h:i:s");
            /*
             * html encode
             */
            $model->company_name = CHtml::encode($_POST['RecruitmentNews']['company_name']);
            $model->company_address = CHtml::encode($_POST['RecruitmentNews']['company_address']);
            //$model->company_info = htmlentities($_POST['RecruitmentNews']['company_info'], ENT_QUOTES, "UTF-8");
            //$model->position = htmlentities($_POST['RecruitmentNews']['position'], ENT_QUOTES, "UTF-8");
            $model->position = CHtml::encode($_POST['RecruitmentNews']['position']);
            // $model->includes = htmlentities($_POST['RecruitmentNews']['includes'], ENT_QUOTES, "UTF-8");
            // $model->description = htmlentities($_POST['RecruitmentNews']['description'], ENT_QUOTES, "UTF-8");
            $model->username = CHtml::encode($_POST['RecruitmentNews']['username']);
            $model->email = CHtml::encode($_POST['RecruitmentNews']['email']);
            $model->address = CHtml::encode($_POST['RecruitmentNews']['address']);
            $model->website = CHtml::encode($_POST['RecruitmentNews']['website']);
            /*
             * 
             */
            $model->options = $_POST['RecruitmentNews']["options"][0];

            if ($model->validate()) {

                if ($model->company_id) {
                    $model->company_name = $company->company_name;
                }

                if (empty($model->expiryday)) {
                    $model->expiryday = date("Y-m-d", (time() + 30 * 24 * 3600));
                } else {
                    $model->expiryday = date("Y-m-d", strtotime($model->expiryday));
                }

                $model->provinces = implode(',', $_POST['RecruitmentNews']['provinces']);
                $model->trade_id = implode(',', $_POST['RecruitmentNews']['trade_id']);
                //	$model->payrate="payrate=".$model->attributes['payrate'];
                //$model->payrate.="&currency=".$model->currency;
                if (Yii::app()->user->id) {
                    $model->user_id = Yii::app()->user->id;
                }
                $model->alias = HtmlFormat::parseToAlias($model->position);
                // if ($check != null) {//kiem tra admin role
                if ($model->save()) {
                    Yii::app()->user->setFlash('success', 'Sửa tin tuyển dụng thành công!');
                    $this->redirect(array('work/myjob'));
                }
//                    } else {
//                        Yii::app()->user->setFlash('error', 'Bạn chưa phải là admin của công ty ' . $model->company_name . '. Hãy chọn công ty khác hay liên hệ với admin của công ty đó');
//                        $this->redirect(array('create'));
//                    }
            }
            // format number
            $model->salary_min = number_format($model->salary_min, 0, ',', '.');
            $model->salary_max = number_format($model->salary_max, 0, ',', '.');
        }



        $this->render('update', array(
            'model' => $model,
            'region' => $region_array,
            'trade' => $trade_array,
            'obj_uCompany' => $obj_uCompany, // the user's company into profile
            'currency_array' => $this->currency_array, // vnd,usd
        ));
    }

    function cut_time($date) {
        $d = getdate(strtotime($date));

        $time = $d['mday'] . '-' . $d['mon'] . '-' . $d['year'];

        return $time;
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     */
    public function actionDelete($id) {
        $user = Yii::app()->user->id;
        $db = Yii::app()->db;
        $user_id = Yii::app()->db->createCommand()
                ->select("user_id")
                ->from("lov_recruitment_news")
                ->where("news_id=:id", array(":id" => $id))
                ->queryScalar();



        if ($user_id && $user_id == $user) {
            //
            /*
             * delete like comment in work
             */
            $comment = Workcomments::model()->findAll(array('condition' => 'obj_id = ' . $id . ' AND obj_type = "work"'));
            foreach ($comment as $list) {
                Likes::model()->deleteAll('type_id = ' . $list->fc_id . ' AND type = "comment"');
            }
            /*
             * delete like work news
             */
            Likes::model()->deleteAll('type_id = ' . $id . ' AND type = "work"');
            //delete comment

            Workcomments::model()->deleteAll('obj_id = ' . $id . ' AND obj_type = "work"');

            $this->loadModel1($id)->delete();
            Yii::app()->user->setFlash("message", "Tin tuyển dụng đã được xóa  !");
            $this->redirect(array('myjob'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function loadModel1($id) {
        if (is_numeric($id)) {
            $model = RecruitmentNews::model()->findByPk($id);
            if ($model === null)
                throw new CHttpException(404, 'Trang yêu cầu không tồn tại.');
            return $model;
        }
        else
            throw new CHttpException(404, 'Trang yêu cầu không tồn tại.');
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        if (is_numeric($id) == true) {
            $model = RecruitmentNews::model()->findByPk($id);
            if ($model === null)
                throw new CHttpException(404, 'The requested page does not exist.');
            return $model;
        }
        else
            throw new CHttpException(400, 'ID không hợp lệ!');
    }

    public function actionMyJob() {
        $this->layout = "//layouts/main";
        if (Yii::app()->user->id) {

            // có thể bạn quan tâm group (interested working)
            $related = $this->getWorkRelated();
            $user_id = Yii::app()->user->id;
            if (isset($_POST['chks'])) {

                $command = Yii::app()->db->createCommand();

                foreach ($_POST['chks'] as $news_id) {
                    if (!MySaveJob::model()->exists('user_id=:user_id and news_id=:news_id', array(':user_id' => $user_id, ':news_id' => $news_id))) {

                        $command->insert('lov_my_save_job', array('user_id' => $user_id, 'news_id' => $news_id, 'created_date' => time()));
                    }
                }
            }

//            $command = Yii::app()->db->createCommand()
//                    ->select('a.*')
//                    ->from('lov_recruitment_news a')
//                    ->Join('lov_users b', 'a.user_id=b.user_id')
//                    ->where('a.user_id=:user_id', array(':user_id' => $user_id))
//                    ->order('createdate DESC')
//                    ->queryAll();

            $criteria = new CDbCriteria;
            /*
             * 
             */

            $criteria->select = 't.*';
            $criteria->join = 'INNER JOIN  lov_users ON  lov_users.user_id = t.user_id ';
            $criteria->condition = ' t.user_id = :value';
            $criteria->params = array(":value" => $user_id);
            $criteria->order = 't.createdate DESC';
            $count = RecruitmentNews::model()->count($criteria);
            $pages = new CPagination($count);
            // elements per page
            $pages->pageSize = 10;
            //$pages->pageVar = 'PPlace';
            $pages->applyLimit($criteria);
            $model = RecruitmentNews::model()->findAll($criteria);



            $this->render('myjob', array('models' => $model, 'work_related' => $related, 'pages' => $pages));
        }
    }

    /**
     * thangnguyen
     * get ajax content user_compnay
     */
    public function actionGetAInfo() {
        if (Yii::app()->request->isAjaxRequest && isset($_POST['RecruitmentNews']["company_id"])) {
            $value = $_POST['RecruitmentNews']["company_id"];

            $obj_uCompany = Yii::app()->db->createCommand()
                    ->select('company_address,company_info')
                    ->from('lov_companies')
                    //  ->leftJoin('lov_country_region region', 'region.region_id=uc.region_id')
                    ->where('company_id=:id', array(':id' => $value))
                    ->queryRow();
            //$obj_uCompany = Companies::model()->findByPk(10371);
//           // print_r($obj_uCompany);
            echo json_encode($obj_uCompany);
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    function replaceUri($search, $replace, $remove = 0) {
        $subject = Yii::app()->request->requestUri;
        if ($remove == 0) {
            return preg_replace('/' . $search . '=\d{0,}/', $search . '=' . $replace, $subject, 1);
        }
        return preg_replace('/&' . $search . '=\d{0,}/', "", $subject, 1);
    }

    /**
     * thangnguyen
     * @ update company_naem vào bảng công việc
     */
//    public function actionCompanyname() {
//        set_time_limit(0);
//        $db = Yii::app()->db;
//        $query = "update  lov_recruitment_news a set company_name=(select company_name from lov_companies b where b.company_id=a.company_id)";
////       / $companyname = 
////        Yii::app()->db->createCommand()->update('lov_recruitment_news', array(
////                            'company_name' => $model->company_name,
////                            'company_address' => $model->company_address,
////                            'company_info' => $model->company_info,
////                            'avatar_name' => $model->company_logo,
////                                ), 'company_id=:id', array(':id' => $id)
////                        );
//        if ($db->createCommand($query)->execute() !== false)
//            echo "Success";
//        else
//            echo "Command execute fail";
//        exit;
//    }

    /**
     * thangnguyen
     * @ store search condition
     */
    public function actionSajax() {
        if (Yii::app()->request->isAjaxRequest) {
            $role = isset($_POST["role"]) ? $_POST["role"] : '';
            $industry = isset($_POST['industry']) ? $_POST['industry'] : '';
            $provinces = isset($_POST['provinces']) ? $_POST['provinces'] : '';
            $db = Yii::app()->db;

            $user_id = Yii::app()->user->id;
            if ($role == "store") {
                if ($industry || $provinces) {
                    $params = "provinces=" . $provinces . "\n";
                    $params.="industry=" . $industry;
                    $query = "select id from lov_user_interest where user_id=$user_id and obj_type='work'";
                    $data = $db->createCommand($query)->queryScalar();
                    if ($data) {
                        $db->createCommand()->update(
                                "lov_user_interest", array("params" => $params), "id=$data");
                    } else {

                        $db->createCommand()->insert(
                                "lov_user_interest", array("params" => $params, "user_id" => $user_id, "obj_type" => "work"));
                    }

                    Yii::app()->session["store"] = 1;
                }
            } else if ($role == 'instore') {
                $query = "delete from lov_user_interest where obj_type='work' and user_id=$user_id";
                $db->createCommand($query)->execute();
                unset(Yii::app()->session["store"]);
            }
        } else {
            throw new HttpException(403, "Not found");
        }
    }

    /*
     * auto load adress when choose a company
     */

    public function actionAjaxloadadresscompany($id) {
        $id = $_POST['id'];
        $model = Companies::model()->findByPk($id);
        if ($model != null) {
            echo $model->company_address;
        }
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'RecruitmentNews-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}