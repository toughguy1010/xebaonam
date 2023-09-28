<?php

class UserProfileController extends PublicController {

    public $profileinfo = array();

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = 'userprofile';

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionIndex() {
        $this->render('view', array(
            'model' => $this->loadModel(Yii::app()->user->id),
        ));
    }
    public function actionProfileEventIndex() {
        $this->render('profile_event_index', array(
            'model' => $this->loadModel(Yii::app()->user->id),
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate() {
        $this->layoutForAction = '//layout/profile_update';
        //
        $id = Yii::app()->user->id;
        $model = $this->loadModel($id);
        $model->scenario = 'update';
        $listprivince = LibProvinces::getListProvinceArr();
        if (!$model->province_id) {
            $firstpro = reset(array_keys($listprivince));
            $model->province_id = $firstpro;
        }
        $listdistrict = false;
        if (isset($_POST['Users'])) {
            $attrs = $_POST['Users'];
            unset($attrs['email']);
            unset($attrs['password']);
            $model->attributes = $attrs;
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->avatar_path = $avatar['baseUrl'];
                    $model->avatar_name = $avatar['name'];
                }
            }
            //
            if ($model->save())
                $this->redirect(Yii::app()->createUrl('profile/profile/view', array('id' => $model->user_id)));
        }
        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($model->province_id);
        }
        //
        $this->render('update', array(
            'model' => $model,
            'listprivince' => $listprivince,
            'listdistrict' => $listdistrict,
        ));
    }

    /**
     * change password
     */
    public function actionChangepassword() {
        $this->layoutForAction = '//layout/profile_changepassword';
        $user = Users::model()->findByPk(Yii::app()->user->id);
        if (!$user)
            $this->sendResponse(404);
        $model = new Users;
        if (isset($_POST['Users'])) {
            //
            $model = $user;
            //
            $attrs = $_POST['Users'];
            if ($user->password) {
                if (ClaGenerate::encrypPassword($attrs['oldPassword']) != $model->password)
                    $model->addError('oldPassword', Yii::t('user', 'user_oldPassword_invalid'));
            }
            if ($attrs['password'] != $attrs['passwordConfirm'])
                $model->addError('passwordConfirm', Yii::t('errors', 'password_dontmatch'));
            if (!$model->hasErrors()) {
                $model->password = ClaGenerate::encrypPassword($attrs['password']);
                if ($model->save()) { // create new user
                    Yii::app()->user->setFlash('success', Yii::t('user', 'user_changepass_success'));
                }
            }
        }
        $model = new Users();
        $this->render('changepass', array(
            'model' => $model,
            'user' => $user,
        ));
    }

    /**
     * Lists all models.
     */
    public function actionOrder() {
        $this->layoutForAction = '//layout/profile_order';
        //
        $model = new Orders();
        //
        $model->unsetAttributes();  // clear any default values
        $model->user_id = Yii::app()->user->id;
        if (isset($_GET['Orders']))
            $model->attributes = $_GET['Orders'];

        $this->render('order', array(
            'model' => $model,
        ));
    }

    /**
     * List all
     */
    public function actionBonusPoint() {
        $this->layoutForAction = '//layout/bonus_point';
        //
        $model = new Orders('searchBonusPoint');
        //

        $model->unsetAttributes();  // clear any default values
        $model->user_id = Yii::app()->user->id;
        $model->order_status = 6;
        if (isset($_GET['status'])) {
            $model->order_status = $_GET['status'];
        }
        $bonus_point_used = 0;
        if (isset($_GET['bonus_point_used'])) {
            $bonus_point_used = $_GET['bonus_point_used'];
            unset($model->order_status);
        }

        $this->render('order_bonus_point', array(
            'model' => $model,
            'bonus_point_used' => $bonus_point_used,
        ));
    }

    /**
     * List all
     */
    public function actionBonusPointHistory() {
        $this->layoutForAction = '//layout/bonus_point_history';
        //
        $model = new BonusPoint();
        //
        $model->unsetAttributes();  // clear any default values
        $model->user_id = Yii::app()->user->id;

        $this->render('bonus_point_history', array(
            'model' => $model,
        ));
    }

    /**
     * Donate
     */
    public function actionDonateHistory() {
        $this->layoutForAction = '//layout/donate_history';
        //
        $model = new BonusPoint();
        //
        $model->unsetAttributes();  // clear any default values
        $model->user_id = Yii::app()->user->id;

        $this->render('donate_history', array(
            'model' => $model,
        ));
    }

    public function actionRealestateIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('realestate', 'list_realestate') => Yii::app()->createUrl('/profile/profile/realestateIndex'),
        );
        //
        $model = new RealEstate();
        //
        $this->render("realestate_index", array(
            'model' => $model,
        ));
    }

    public function actionRealestateProjectIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('realestate', 'list_manager') => Yii::app()->createUrl('/profile/profile/realestateProjectIndex'),
        );
        $user = Users::getCurrentUser();
        //
        $model = new RealEstateProject();
        //
        $this->render("realestate_project_index", array(
            'model' => $model,
            'user' => $user,
        ));
    }

    public function actionRealestateNewsIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('realestate', 'list_realestate') => Yii::app()->createUrl('/content/realestate/'),
        );
        //
        $model = new RealEstateNews();
        //
        $this->render("realestate_news_index", array(
            'model' => $model,
        ));
    }

    public function actionRealestateUpdate($realestate_id) {
        $model = RealEstate::model()->findByPk($realestate_id);
        $this->breadcrumbs = array(
            Yii::t('realestate', 'list_realestate') => Yii::app()->createUrl('/content/realestate/'),
            Yii::t('news', 'news_edit') => Yii::app()->createUrl('/content/news/update', array('id' => $id)),
        );

        $option_project = RealEstateProject::getOptionProject();
        $user_id = Yii::app()->user->id;
        $listprovince = LibProvinces::getListProvinceArr();
        if (!$model->province_id) {
            $first = array_keys($listprovince);
            $firstpro = isset($first[0]) ? $first[0] : null;
            $model->province_id = $firstpro;
        }
        $listdistrict = false;

        //
        if (isset($_POST['RealEstate'])) {
            $model->attributes = $_POST['RealEstate'];
            $province = LibProvinces::getProvinceDetail($model->province_id);
            if (isset($province) && $province['name']) {
                $model->province_name = $province['name'];
            }
            $district = LibDistricts::getDistrictDetailFollowProvince($model->province_id, $model->district_id);
            if (isset($district) && $district['name']) {
                $model->district_name = $district['name'];
            }
            $model->processPrice();
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->image_path = $avatar['baseUrl'];
                    $model->image_name = $avatar['name'];
                }
            }

            $model->user_id = $user_id;
            if (!$model->getErrors()) {
                if ($model->save()) {
                    $this->redirect(array('realestateIndex'));
                }
            }
        }

        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($model->province_id);
        }

        $this->render('realestate_update', array(
            'model' => $model,
            'listprovince' => $listprovince,
            'listdistrict' => $listdistrict,
            'option_project' => $option_project,
            'user_id' => $user_id,
            'realestate_id' => $realestate_id
        ));
    }

    public function actionRealestateCreate() {
        $model = new RealEstate;
        $model->unsetAttributes();
        $model->type = 1;

        $option_project = RealEstateProject::getOptionProject();
        $user_id = Yii::app()->user->id;
        $listprovince = LibProvinces::getListProvinceArr();
        if (!$model->province_id) {
            $first = array_keys($listprovince);
            $firstpro = isset($first[0]) ? $first[0] : null;
            $model->province_id = $firstpro;
        }
        $listdistrict = false;

        //
        if (isset($_POST['RealEstate'])) {
            $model->attributes = $_POST['RealEstate'];
            $province = LibProvinces::getProvinceDetail($model->province_id);
            if (isset($province) && $province['name']) {
                $model->province_name = $province['name'];
            }
            $district = LibDistricts::getDistrictDetailFollowProvince($model->province_id, $model->district_id);
            if (isset($district) && $district['name']) {
                $model->district_name = $district['name'];
            }
            $model->processPrice();
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->image_path = $avatar['baseUrl'];
                    $model->image_name = $avatar['name'];
                }
            }

            $model->user_id = $user_id;
            $model->status = 2;
            if (!$model->getErrors()) {
                if ($model->save()) {
                    $this->redirect(array('realestateIndex'));
                }
            }
        }

        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($model->province_id);
        }

        $this->render('realestate_create', array(
            'model' => $model,
            'listprovince' => $listprovince,
            'listdistrict' => $listdistrict,
            'option_project' => $option_project,
            'user_id' => $user_id,
            'realestate_id' => ''
        ));
    }

    public function actionRealestateProjectCreate() {
        $this->breadcrumbs = array(
            Yii::t('realestate', 'list_realestate') => Yii::app()->createUrl('/profile/profile/realestateProjectIndex'),
            $model->name => Yii::app()->createUrl('/profile/profile/realestateProjectUpdate', array('rp_id' => $rp_id)),
        );
        $model = new RealEstateProject;
        $model->unsetAttributes();
        $user_id = Yii::app()->user->id;
        $listprovince = LibProvinces::getListProvinceArr();
        if (!$model->province_id) {
            $first = array_keys($listprovince);
            $firstpro = isset($first[0]) ? $first[0] : null;
            $model->province_id = $firstpro;
        }

        $listdistrict = false;

        if (isset($_POST['RealEstateProject'])) {
            $model->attributes = $_POST['RealEstateProject'];
            $province = LibProvinces::getProvinceDetail($model->province_id);
            if (isset($province) && $province['name']) {
                $model->province_name = $province['name'];
            }
            $district = LibDistricts::getDistrictDetailFollowProvince($model->province_id, $model->district_id);
            if (isset($district) && $district['name']) {
                $model->district_name = $district['name'];
            }
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->image_path = $avatar['baseUrl'];
                    $model->image_name = $avatar['name'];
                }
            }

            $model->user_id = $user_id;
            if (!$model->getErrors()) {
                if ($model->save()) {
                    $this->redirect(array('realestateProjectIndex'));
                }
            }
        }
        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($model->province_id);
        }
        $this->render('realestate_project_create', array(
            'model' => $model,
            'listprovince' => $listprovince,
            'listdistrict' => $listdistrict,
            'user_id' => $user_id,
            'rp_id' => '',
        ));
    }

    public function actionRealestateProjectUpdate($rp_id) {
        $this->breadcrumbs = array(
            Yii::t('realestate', 'list_realestate') => Yii::app()->createUrl('/profile/profile/realestateProjectIndex'),
            $model->name => Yii::app()->createUrl('/profile/profile/realestateProjectUpdate', array('rp_id' => $rp_id)),
        );
        $model = RealEstateProject::model()->findByPk($rp_id);
        $user_id = Yii::app()->user->id;
        $listprovince = LibProvinces::getListProvinceArr();
        if (!$model->province_id) {
            $first = array_keys($listprovince);
            $firstpro = isset($first[0]) ? $first[0] : null;
            $model->province_id = $firstpro;
        }

        $listdistrict = false;

        if (isset($_POST['RealEstateProject'])) {
            $model->attributes = $_POST['RealEstateProject'];
            $province = LibProvinces::getProvinceDetail($model->province_id);
            if (isset($province) && $province['name']) {
                $model->province_name = $province['name'];
            }
            $district = LibDistricts::getDistrictDetailFollowProvince($model->province_id, $model->district_id);
            if (isset($district) && $district['name']) {
                $model->district_name = $district['name'];
            }
            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->image_path = $avatar['baseUrl'];
                    $model->image_name = $avatar['name'];
                }
            }

            $model->user_id = $user_id;
            if (!$model->getErrors()) {
                if ($model->save()) {
                    $this->redirect(array('realestateProjectIndex'));
                }
            }
        }
        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($model->province_id);
        }
        $this->render('realestate_project_update', array(
            'model' => $model,
            'listprovince' => $listprovince,
            'listdistrict' => $listdistrict,
            'user_id' => $user_id,
            'rp_id' => $rp_id,
        ));
    }

    public function actionRealestateNewsUpdate($realestatenews_id) {
        $model = RealEstateNews::model()->findByPk($realestatenews_id);
        $this->breadcrumbs = array(
            Yii::t('realestate', 'list_realestate') => Yii::app()->createUrl('/content/realestate/'),
            Yii::t('news', 'news_edit') => Yii::app()->createUrl('/content/news/update', array('id' => $id)),
        );

        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_REAL_ESTATE;
        $category->generateCategory();

        $user_id = Yii::app()->user->id;

        $listprovince = LibProvinces::getListProvinceArr();
        if (!$model->province_id) {
            $first = array_keys($listprovince);
            $firstpro = isset($first[0]) ? $first[0] : null;
            $model->province_id = $firstpro;
        }
        $listdistrict = false;

        if (isset($_POST['RealEstateNews'])) {
            $model->attributes = $_POST['RealEstateNews'];
            $province = LibProvinces::getProvinceDetail($model->province_id);
            if (isset($province) && $province['name']) {
                $model->province_name = $province['name'];
            }
            $district = LibDistricts::getDistrictDetailFollowProvince($model->province_id, $model->district_id);
            if (isset($district) && $district['name']) {
                $model->district_name = $district['name'];
            }
            $model->user_id = $user_id;
            $model->processPrice();

            if ($model->avatar) {
                $avatar = Yii::app()->session[$model->avatar];
                if (!$avatar) {
                    $model->avatar = '';
                } else {
                    $model->image_path = $avatar['baseUrl'];
                    $model->image_name = $avatar['name'];
                }
            }
            //
            if (!$model->getErrors()) {
                if ($model->save()) {
                    unset(Yii::app()->session[$model->avatar]);
                    $this->redirect(array('realestateNewsIndex'));
                }
            }
        }

        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictArrFollowProvince($model->province_id);
        }

        $this->render('realestate_news_update', array(
            'model' => $model,
            'category' => $category,
            'listprovince' => $listprovince,
            'listdistrict' => $listdistrict,
            'user_id' => $user_id,
            'realestatenews_id' => $realestatenews_id
        ));
    }

    public function actionRealestateDelete($realestate_id) {
        $model = RealEstate::model()->findByPk($realestate_id);
        if ($model->user_id != Yii::app()->user->id) {
            $this->jsonResponse(403);
        }
        if (!$model) {
            $this->jsonResponse(204);
        }
        if ($model->site_id != $this->site_id) {
            $this->jsonResponse(403);
        }
        //
        //
        if ($model->delete()) {
            $this->jsonResponse(200);
            return;
        }
        $this->jsonResponse(400);
    }

    public function actionRealestateProjectDelete($rp_id) {
        $model = RealEstateProject::model()->findByPk($rp_id);
        if ($model->user_id != Yii::app()->user->id) {
            $this->jsonResponse(403);
        }
        if (!$model) {
            $this->jsonResponse(204);
        }
        if ($model->site_id != $this->site_id) {
            $this->jsonResponse(403);
        }
        //
        if ($model->delete()) {
            $this->jsonResponse(200);
            return;
        }
        $this->jsonResponse(400);
    }

    public function actionRealestateNewsDelete($realestatenews_id) {
        $model = RealEstateNews::model()->findByPk($realestatenews_id);
        if ($model->user_id != Yii::app()->user->id) {
            $this->jsonResponse(403);
        }
        if (!$model) {
            $this->jsonResponse(204);
        }
        if ($model->site_id != $this->site_id) {
            $this->jsonResponse(403);
        }
        //
        //
        if ($model->delete()) {
            $this->jsonResponse(200);
            return;
        }
        $this->jsonResponse(400);
    }

    /**
     * cancelorder
     */
    function actionCancelorder() {
        $id = Yii::app()->request->getParam('oid');
        $key = Yii::app()->request->getParam('key');
        if ($id && $key) {
            $order = Orders::model()->findByPk($id);
            if (!$order)
                $this->sendResponse(404);
            if ($order->key != $key || $order->user_id != Yii::app()->user->id || $order->order_status != Orders::ORDER_WAITFORPROCESS)
                $this->sendResponse(404);
            //
//            $order->order_status = Orders::ORDER_DESTROY;
//            $order->save();
            $order->delete();
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('order'));
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Users the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Users::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    public function beforeAction($action) {
        if (Yii::app()->user->isGuest) {
            $this->redirect(Yii::app()->homeUrl);
        }
        $user_id = Yii::app()->request->getParam('id');
        if (!$user_id) {
            $user_id = Yii::app()->user->id;
        }
        $this->profileinfo = ClaUser::getUserInfo($user_id);
        //
        if (!isset($this->profileinfo['site_id']) || $this->profileinfo['site_id'] != $this->site_id) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        //
        return parent::beforeAction($action);
    }

    public function actionUserIntroduce() {
        $site_id = Yii::app()->controller->site_id;
        $data = Yii::app()->db->createCommand()->select('user_id, name, user_introduce_id')
                ->from(ClaTable::getTable('users'))
                ->where('site_id=:site_id', array(':site_id' => $site_id))
                ->queryAll();
        $user = Users::getCurrentUser();
        $result = array();

        if ($user->user_introduce_id != 0) {
            $user_introduce = Users::model()->findByPk($user->user_introduce_id);
            $result[] = array(
                'id' => $user_introduce->user_id,
                'parent' => '#',
                'text' => $user_introduce->name,
                'state' => array('opened' => true)
            );
            $result[] = array(
                'id' => $user->user_id,
                'parent' => $user_introduce->user_id,
                'text' => $user->name,
                'state' => array('opened' => true)
            );
        } else {
            $result[] = array(
                'id' => $user->user_id,
                'parent' => '#',
                'text' => $user->name,
                'state' => array('opened' => true)
            );
        }
        $this->process_data($data, $user->user_id, $result);
        $html = json_encode($result);
        $this->render('user_introduce', array(
            'html' => $html,
        ));
    }

    public function process_data($data, $parent_id, &$result) {
        if (count($data) > 0) {
            foreach ($data as $key => $val) {
                if ($parent_id == $val['user_introduce_id']) {
                    $temp['id'] = $val['user_id'];
                    $temp['parent'] = $val['user_introduce_id'];
                    $temp['text'] = $val['name'];
                    $temp['state'] = array('opened' => true);
                    $result[] = $temp;
                    $_parent_id = $val['user_id'];
                    unset($data[$key]);
                    $this->process_data($data, $_parent_id, $result);
                }
            }
        }
    }

    /**
     * thống kê lượt khách hàng liên hệ qua form tùy chỉnh
     */
    public function actionStatistic() {
        $id = Yii::app()->request->getParam('id');
        if ($id) {
            $form = $this->loadModel($id);
        } else {
            $form = Forms::model()->findByAttributes(array('site_id' => $this->site_id));
            if ($form) {
                $id = $form->form_id;
            }
        }
        //
        if ($form->site_id != $this->site_id) {
            if (Yii::app()->request->isAjaxRequest) {
                $this->jsonResponse(400);
            } else {
                $this->sendResponse(400);
            }
        }
        //
        $this->breadcrumbs = array(
            $form->form_name => Yii::app()->createUrl('custom/customform/statistic', array('id' => $id)),
        );
        //
        $pagesize_widget = $this->widget('common.extensions.PageSize.PageSize', array(
            'mGridId' => 'customform-grid', //Gridview id
            'mPageSize' => Yii::app()->request->getParam(Yii::app()->params['pageSizeName']),
            'mDefPageSize' => Yii::app()->params['defaultPageSize'],
                ), true);
        //
        $page = Yii::app()->request->getParam('page');
        $limit = Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']);
        //
        $totalItem = FormSessions::countFieldDataInForm($id);

        $listfields = FormFields::getFieldsInForm($id);
        $listinputfields = FormFields::getInputFieldsInForm($listfields);
        $fieldData = array();
        $gridColumns = array();
        if ($listinputfields) {
            $cinputfield = ($listfields) ? count($listinputfields) : 0;
            //
            $fieldData = FormSessions::getFieldDataInForm(array(
                        'form_id' => $id,
                        'fields' => $listfields,
                        'page' => $page,
                        'limit' => $limit,
                        'user_id' => Yii::app()->user->id,
            ));
            //
            //
            $gridColumns = array(
                'number' => array(
                    'header' => '',
                    'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + $row + 1',
                    'htmlOptions' => array('width' => 10,),
                ),
            );
            //
            foreach ($listinputfields as $lf) {
                $gridColumns[$lf['field_id']] = array(
                    'header' => $lf['field_label'],
                    'value' => function($data) use ($lf) {
                        return isset($data[$lf['field_id']]) ? HtmlFormat::subCharacter($data[$lf['field_id']]['field_data'], ' ', 15) : '';
                    }
                );
            }
        }
        //
        //
        $dataprovider = new ArrayDataProvider($fieldData, array(
            'id' => 'cf' . $id,
            'keyField' => 'form_id',
            'keys' => array('form_id'),
            'totalItemCount' => $totalItem,
            'pagination' => array(
                'pageSize' => $limit,
                'pageVar' => 'page',
            ),
        ));
        //
        $this->render('statistic', array(
            'form' => $form,
            'dataProvider' => $dataprovider,
            'gridColumns' => $gridColumns,
            'pagesize_widget' => $pagesize_widget,
        ));
    }

    /**
     * upload file
     */
    public function actionUploadfile() {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if ($file['size'] > 1024 * 1000 * 2) {
                $this->jsonResponse('400', array(
                    'message' => Yii::t('errors', 'filesize_toolarge', array('{size}' => '2Mb')),
                ));
                Yii::app()->end();
            }
            $up = new UploadLib($file);
            $up->setPath(array($this->site_id, 'users', 'ava'));
            $up->uploadImage();
            $return = array();
            $response = $up->getResponse(true);
            $return = array('status' => $up->getStatus(), 'data' => $response, 'host' => ClaHost::getImageHost(), 'size' => '');
            if ($up->getStatus() == '200') {
                $keycode = ClaGenerate::getUniqueCode();
                $return['data']['realurl'] = ClaHost::getImageHost() . $response['baseUrl'] . 's100_100/' . $response['name'];
                $return['data']['avatar'] = $keycode;
                Yii::app()->session[$keycode] = $response;
            }
            echo json_encode($return);
            Yii::app()->end();
        }
        //
    }

}
