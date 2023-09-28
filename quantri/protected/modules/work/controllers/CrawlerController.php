<?php

class crawlerController extends Controller {
    /*    public function filters() {
      return array(
      'accessControl',
      );
      }

      public function accessRules() {
      return array(
      array('allow',
      'actions' => array('index'),
      'users' => array('@'),
      ),
      array('deny',
      'users' => array('*'),
      ),
      );
      } */

//    public function actionUpdatecompany(){
//    /*
//     * update company name for Recruiment table
//     */
//     $work = RecruitmentNews::model()->findAll(array('order'=>'news_id DESC'));
//     foreach($work as $list){
//         if($list->company_name == null){
//            $company = Companies::model()->findByPk($list->company_id);
//            $list->company_name = $company->company_name;
//            $list->save();
//         }
//     }
//        
//    }
    /**
     * thang
     * lấy các ngành nghề,công việc trong nhóm ngành nghề 
     */
    
    public function getTrade($group_pattern, $group_id) {
        $trade = '/<ul>(.*?)<\/ul>/usi';
        preg_match($trade, $group_pattern, $trade_array);
        $content = '/<a href="(.*?)".*?>(.*?)<\/a>/usi';
        preg_match_all($content, $trade_array[1], $trade);


        foreach ($trade[2] as $k => $item) {
            // kiểm tra xem có ngành nghề hiện tại chưa
            $exists = Trade::model()->find('trade_name=:trade_name', array(':trade_name' => $item));
            if (!$exists) {
                $obj_trade_new = new Trade;
                $obj_trade_new->trade_code = $trade[1][$k];
                $obj_trade_new->trade_name = $item;
                $obj_trade_new->group_id = $group_id;
                $obj_trade_new->save(false);
                $tradeid = $obj_trade_new->trade_id;
            } else {
                $tradeid = $exists->trade_id;
            }

            // lấy chi tiết tin đăng

            $contentdetail = file_get_contents($trade[1][$k]);
            $link_detail = '/<a[^>]*target="_blank" href="(.*?)" title=".*?">(.*?)<\/a>/usi';

            preg_match_all($link_detail, $contentdetail, $link_array);



            // lấy ngày đăng
            $date_pattern = '/<span class="posted">(.*?)<\/span>/usi';
            preg_match_all($date_pattern, $contentdetail, $date_array);

            // láy nơi làm việc
            $location_pattern = '/<span class="location">.*?<strong>(.*?)<\/strong><\/span>/usi';
            preg_match_all($location_pattern, $contentdetail, $location_arr);   // => $location_arr[1][]


            foreach ($link_array[1] as $e => $detail) {

                $contentdetail = file_get_contents($detail);
                $data = $this->getData($contentdetail);


                $data['createdate'] = str_replace('/', '-', preg_replace('/<strong>(.*?)<\/strong>/i', '', $date_array[1][$e]));
                $data['location'] = $this->getLocation($location_arr[1][$e]);
                $data["title"] = $link_array[2][$e];

                if (empty($data["expire"])) {
                    $data["expire"] = strtotime($data['createdate']) + 30 * 24 * 3600;
                }
                $connection = Yii::app()->db;
                $x = $connection->createCommand()->select('position')->from('lov_recruitment_news')->where('position=:position', array(':position' => $data['title']))->queryRow();

                if ($x === false) {
                    $connection->createCommand()->insert('lov_recruitment_news', array(
                        'position' => $data['title'],
                        'provinces' => $data['location'], // tỉnh thành làm việc
                        'office' => $data['position'], // cấp bậc (nhân viên, trưởng phòng...)
                        //'require' => $data['require'],
                        'description' => $data['description'],
                        'company_name' => $data['company']['title'],
                        'website' => $data['company']['link'],
                        'company_address' => $data['company']['address'],
                        'trade_id' => $tradeid,
                        'createdate' => strtotime($data['createdate']),
                        'alias' => str_replace(" ", "-", HtmlFormat::stripUnicode(strtolower($data['title']))),
                        'expiryday' => $data["expire"],
                    ));
                }
            }
        }
    }

    public function getGroupBuild($data) {   // nhóm ngành xây dựng
        $sub_data = $data;
        $pos = 0;
        $name_group = "/<h3>(.*?)<\/h3>/i";

        for ($t = 0; $t < 5; $t++) {

            preg_match($name_group, $sub_data, $result1);
            $pos = strpos($sub_data, "<h3>");
            $sub_data = substr($sub_data, $pos + 1);

            $chk = TradeGroups::model()->find('group_name=:group_name', array(':group_name' => $result1[1]));
            if (!$chk) {
                $TradeGroupsNew = new TradeGroups;
                $TradeGroupsNew->group_name = $result1[1];
                $TradeGroupsNew->save(false);
                $group_id = $TradeGroupsNew->group_id;
            } else {
                $group_id = $chk->group_id;
            }
            $this->getTrade($sub_data, $group_id);
        }

        //die();
    }

    /**
     * truyền thông
     * return ngành truyền thônng
     */
    public function getMedia() {
        
    }

    public function actionIndex() {

        set_time_limit(0);
        //header( 'Content-type: text/html; charset=utf-8' );
        $content = @file_get_contents("http://www.vietnamworks.com/tim-viec-lam"); // lấy nhóm ngành nghề và ngành


        $site_content = '/<div class="jobitem">(.*?)<\/div>/usi';
        preg_match_all($site_content, $content, $inside);

        for ($i = 0; $i < 2; $i++) {
            $this->getGroupBuild($inside[0][$i]);
        }
    }

    private function getData($contentdetail) {

        $data = array();
        // $data['title']=$this->getTitleVNW($contentdetail);
        $data['company'] = $this->getCompanyInfo($contentdetail);
        $data['description'] = $this->getDescription($contentdetail);
       // $data['require'] = $this->getRequire($contentdetail);
        $data['position'] = $this->getPosition($contentdetail);
        $data['expire'] = $this->getExpire($contentdetail);   // ngày hết hạn nộp hồ sơ
        return $data;
    }

    private function getTitleVNW($contentdetail) {
        $title = '';
        preg_match('/<h1 class="job-title">(.*)<\/h1>/usi', $contentdetail, $matches);

        return strip_tags($matches[0]);
        if (isset($matches[1])) {
            $title = trim($matches[1]);
        }
        echo $title;
        die();
        return $title;
    }

    private function getCompanyInfo($contentdetail) {
        $company = array();
        $company['title'] = $this->getCompanyTitle($contentdetail);
        $company['link'] = $this->getCompanyLink($contentdetail);
        $company['address'] = $this->getCompanyAddress($contentdetail);
        return $company;
    }

    private function getCompanyTitle($contentdetail) {
        $companytitle = '';
        preg_match('/<h3 class="company-name">(.*)<\/h3>/USi', $contentdetail, $matches);
        $companytitle = $matches[1];
        return $companytitle;
    }

    private function getCompanyLink($contentdetail) {
        $companylink = '';
        preg_match_all('/<h3 class="company-name">.*<\/h3>\s*.*<a.*href="(.*)"/USi', $contentdetail, $matches);
        if (isset($matches[1][0])) {
            $companylink = $matches[1][0];
        }
        return $companylink;
    }

    private function getCompanyAddress($contentdetail) {
        $address = '';
        preg_match_all('/<span class="company-address">(.*)<\/span>/USi', $contentdetail, $matchesarray);
        $address = $matchesarray[1][0];
        return $address;
    }

    private function getCompanyDescription($contentdetail) {
        $description = '';
        //preg_match('/<span class="company-address">.*\s+.*<p>(.*)(\s*\w*)*<\/p>/USi',$contentdetail,$matches); 
        return $description;
    }

    private function getDescription($contentdetail) {
        $des = '';
        $start1 = strpos($contentdetail, '<h2>Mô tả Công việc</h2>');
        $start1+=strlen('<h2>Mô tả Công việc</h2>');
        $end1 = strpos($contentdetail, '<h2>Yêu Cầu Công Việc</h2>');
        if ($start1 && $end1) {
            $des_area = substr($contentdetail, $start1, $end1 - $start1);
            $start2 = strpos($des_area, '<div class="content-box">');
            $start2+=strlen('<div class="content-box">');
            $end2 = strpos($des_area, '</div>');
            if ($start2 && $end2) {
                $des = substr($des_area, $start2, $end2 - $start2);
            } else {
                return $des;
            }
        } else {
            return $des;
        }
        return $des;
    }

    private function getRequire($contentdetail) {
        $require = '';
        $start1 = strpos($contentdetail, '<h2>Yêu Cầu Công Việc</h2>');
        $start1+=strlen('<h2>Yêu Cầu Công Việc</h2>');
        $end1 = strpos($contentdetail, '<div class="content-extra">');
        if ($start1 && $end1) {
            $require_area = substr($contentdetail, $start1, $end1 - $start1);
            if ($require_area) {
                $start2 = strpos($require_area, '<div class="content-box">');
                $start2+=strlen('<div class="content-box">');
                $end2 = strpos($require_area, '</div>');
                if ($start2 && $end2) {
                    $require = substr($require_area, $start2, $end2 - $start2);
                } else {
                    return $require;
                }
            }
        } else {
            return $require;
        }
        return $require;
    }

    private function getLocation($content_location) {
        $locations = explode(",", $content_location);
        foreach ($locations as $k => $location) {
            $location = trim(HtmlFormat::stripUnicode(strtolower($location)));
            if ($k == '0')
                $query = "select region_id from lov_country_region where country_id='VN' and (default_name like '%" . $location . "%' ";
            else
                $query .=" or default_name like '%" . $location . "%'";
        }
        $query .=" or 1>2)";

        $region_id = Yii::app()->db->createCommand($query)->queryAll();
        $pro_id = '';
        if (count($region_id)) {
            foreach ($region_id as $r => $regions) {
                $pro_id.=$regions['region_id'];
                if ($r < count($region_id) - 1)
                    $pro_id.=",";
            }
        }

        return $pro_id;
    }

    private function getPosition($contentdetail) {
        $position = '';
        $start1 = strpos($contentdetail, '<dt>Cấp Bậc</dt>');
        $start1+=strlen('<dt>Cấp Bậc</dt>');
        $end1 = strpos($contentdetail, '<dt>Ngành Nghề</dt>');
        if ($start1 && $end1) {
            $position_area = substr($contentdetail, $start1, $end1 - $start1);
            if ($position_area) {
                $position_area = trim($position_area);
                preg_match_all('/<a.*>(.*)<\/a>/USi', $position_area, $matchesarray);
                if (isset($matchesarray[1][0])) {
                    $position = $matchesarray[1][0];
                }
            }
        }


        return $position;
    }

    /**
     * ngay het han 
     */
    private function getExpire($contentdetail) {
        $expire = '';
        //$expire		  =time()+30*24*60*60;  // nếu không có thì= ngày hiện tại +24 ngày	
        $content_extra = '/<div class="content-extra">(.*)<\/div>/Usi';
        preg_match($content_extra, $contentdetail, $expire_result);
        preg_match('/<dd>(.*)<\/dd>/Usi', $expire_result[1], $end_date);
        if (strtotime($end_date[1])) {
            $expire = strtotime($end_date[1]);
        }
        return $expire;
    }

    /**
     * get office
     */
    private function getOffice($contentdetail) {
        $office = "";
    }

}