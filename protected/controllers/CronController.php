<?php

/**
 * Description of HomeController
 *
 * @author bachminh
 */
class CronController extends PublicController {

    public function actionIndex() {
        // $siteinfo = ClaSite::getSiteInfo();
        echo "<pre>";
        $message = "Tin nhan gui kiem thu tu nanoweb";
        $data = JobsSms::getDataSms();
        $text_save = '';
        $list_s = [];
        if($data) foreach ($data as $id => $item) {
            $phone = $item['info']['phone'];
            $jobs = $item['jobs'];
            $message = 'Số ĐT '.$phone.' có '.count($jobs).' tin tuyển dụng mới phù hợp với mong muốn của bạn.\n';
            if(JobsSms::sendSms($phone, $message)) {
                $text_save .= $message;
                $list_s[] = $id;
            }
            
        }
        if($list_s) {
            Candidate::model()->updateAll(['time_send_sms' => time()],"id IN (".implode(',', $list_s).")");
        } else  {
            if($data) {
                $text_save = "Gửi lỗi ".count($data).' bản ghi\n';
            } else {
                $text_save = 'Không có bản ghi.\n';
            }
        }
        //luu log
        $text_save .='--- Gửi: '.date('d-m-Y H:i', time()).'\n';
        $file = 'logSendJobs.log';
        $data = '';
        // $myfile = fopen($file, "w+") or die("Unable to open file!");
        // fwrite($myfile, 'ST:');
        // fclose($myfile);
        $fp = @fopen($file, "r");
        // Kiểm tra file mở thành công không
        if (!$fp) {
            echo 'Mở file không thành công';
        } else {
            while(!feof($fp))
            {
                $data .= fgets($fp);
            }
        }
        $myfile = fopen($file, "w") or die("Unable to open file!");
        $data .= $text_save;
        fwrite($myfile, $data);
        fclose($myfile);
        echo $text_save;
        return true;
    }
    
}
