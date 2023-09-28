<?php

/**
 * @author hungtm 
 * @date 06/01/2016
 */
class SiteConfigShipfeeController extends BackController {

    public function actionIndex() {
        //breadcrumbs
        $this->breadcrumbs = array(
            Yii::t('site', 'manage_config_shipfee') => Yii::app()->createUrl('setting/siteConfigShipfee'),
        );
        $site_id = Yii::app()->controller->site_id;
        $model = new SiteConfigShipfee();
        if (isset($_POST['SiteConfigShipfeeWeight']) && $_POST['SiteConfigShipfeeWeight']) {
            Yii::app()->db->createCommand('DELETE FROM site_config_shipfee_weight WHERE site_id = ' . $site_id)->execute();
            $post = $_POST['SiteConfigShipfeeWeight'];
            $value = '';
            foreach ($post as $item) {
                if ($value != '') {
                    $value .= ',';
                }
                $value .= "('" . $item['from'] . "', '" . $item['to'] . "', '" . $item['price'] . "', '" . $site_id . "')";
            }
            $sql = 'INSERT INTO site_config_shipfee_weight(`from`, `to`, `price`, `site_id`) VALUES' . $value . ' ON DUPLICATE KEY UPDATE price = VALUES(price)';
            Yii::app()->db->createCommand($sql)->execute();
        }
        if (isset($_POST['SiteConfigShipfee']) && $_POST['SiteConfigShipfee']) {
            $post = $_POST['SiteConfigShipfee'];
            $province_ids = $post['province_id'];
            $district_arr = $post['district_id'];
            $price_arr = $post['price'];
            Yii::app()->db->createCommand('DELETE FROM site_config_shipfee WHERE site_id = ' . $site_id)->execute();
            $value = '';
            foreach ($province_ids as $key => $province_id) {
                if ($province_id == 'all') {
                    $province_name = 'all';
                } else {
                    $province = LibProvinces::getProvinceDetail($province_id);
                    $province_name = $province['name'];
                }
                $district_ids = $district_arr[$key];
                $price = (isset($price_arr[$key]) && (int) $price_arr[$key] > 0) ? $price_arr[$key] : '0';
                foreach ($district_ids as $district_id) {
                    if ($district_id == 'all') {
                        $district_name = 'all';
                    } else {
                        $district = LibDistricts::getDistrictDetailFollowProvince($province_id, $district_id);
                        $district_name = $district['name'];
                    }
                    if ($value != '') {
                        $value .= ',';
                    }
                    $value .= "('" . $province_id . "', '" . $province_name . "', '" . $district_id . "', '" . $district_name . "', " . $price . ", '" . $site_id . "')";
                }
            }
            $sql = 'INSERT INTO site_config_shipfee(province_id, province_name, district_id, district_name, price, site_id) VALUES' . $value . ' ON DUPLICATE KEY UPDATE price = VALUES(price)';
            Yii::app()->db->createCommand($sql)->execute();
            Yii::app()->user->setFlash('success', 'Cập nhật thành công');
            $this->redirect(array('index'));
        }
        // get address options
        $listprovince = LibProvinces::getListProvinceAndall();
        if (!$model->province_id) {
            $first = array_keys($listprovince);
            $firstpro = isset($first[0]) ? $first[0] : null;
            $model->province_id = $firstpro;
        }
        $listdistrict = false;

        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictAndall($model->province_id);
        }

        if (!$model->district_id) {
            $first = array_keys($listdistrict);
            $firstdis = isset($first[0]) ? $first[0] : null;
            $model->district_id = $firstdis;
        }

        $allconfig = SiteConfigShipfee::getAllConfigShipfee();
        $data = array();
        // process data for display pretty
        if (count($allconfig)) {
            foreach ($allconfig as $item_config) {
                $data[$item_config['province_id']][$item_config['price']]['province_name'] = $item_config['province_name'];
                $data[$item_config['province_id']][$item_config['price']]['district'][] = $item_config;
            }
        }
        
        $data_weight = SiteConfigShipfeeWeight::getAllConfigShipfeeWeight();
        

        $this->render('add', array(
            'model' => $model,
            'listprovince' => $listprovince,
            'listdistrict' => $listdistrict,
            'data' => $data,
            'data_weight' => $data_weight
        ));
    }

    public function actionHtmlItemconfig() {
        $count_tag = Yii::app()->request->getParam('count_tag');
        // get address options
        $listprovince = LibProvinces::getListProvinceAndall();
        $first = array_keys($listprovince);
        $firstpro = isset($first[0]) ? $first[0] : null;
        $province_id = $firstpro;
        $listdistrict = false;
        if (!$listdistrict) {
            $listdistrict = LibDistricts::getListDistrictAndall($province_id);
        }

        $html = $this->renderPartial('html_item_config', array(
            'listprovince' => $listprovince,
            'listdistrict' => $listdistrict,
            'count_tag' => $count_tag
                ), true);

        $this->jsonResponse(200, array(
            'html' => $html,
        ));
    }

    public function actionHtmlItemconfigWeight() {
        $count_tag = Yii::app()->request->getParam('count_tag');
        // get address options
        $html = $this->renderPartial('html_item_config_weight', array(
            'count_tag' => $count_tag
                ), true);

        $this->jsonResponse(200, array(
            'html' => $html,
        ));
    }

    /**
     * get district of province
     */
    function actionGetdistrict() {
        $province_id = Yii::app()->request->getParam('pid');
        if ($province_id) {
            $listdistrict = LibDistricts::getListDistrictFollowProvince($province_id);
            $this->jsonResponse('200', array(
                'html' => $this->renderPartial('ldistrict', array('listdistrict' => $listdistrict), true),
            ));
        } else {
            $listdistrict = array();
            $this->jsonResponse('200', array(
                'html' => $this->renderPartial('ldistrict', array('listdistrict' => $listdistrict), true),
            ));
        }
    }

    public function actionDelete($id) {
        $model = $this->loadModel($id);
        $model->delete();
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
    }

    public function loadModel($id) {
        $model = SitePayment::model()->findByPk($id);
        if ($model === NULL) {
            $this->sendResponse(404);
        }
        if ($model->site_id != Yii::app()->controller->site_id) {
            $this->sendResponse(404);
        }
        return $model;
    }

}
