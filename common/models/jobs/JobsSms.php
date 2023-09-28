<?php

/**
 * author: cong
 *
 * Class tạo sms gửi công việc phù hợp đến ứng viên
 *
 */
class JobsSms {

    public static function getDataSms() {
        $jobs = Jobs::getJobNeedWorkerInsite(['full' => false]);
        if($jobs) {
            $candidates = Candidate::getCadidateNeedSms();
            if($candidates) {
                $jos_fix = [];
                foreach ($jobs as $key => $value) {
                    $jos_fix[$value['country_id']][] = $value;
                }
                $data_send = [];
                foreach ($candidates as $candidate) {
                    if(isset($jos_fix[$candidate['country_id']])) {
                        $job_cd = $jos_fix[$candidate['country_id']];
                        foreach ($job_cd as $job) {
                            $list_work = explode(',', $job['trade_id']);
                            if(in_array($candidate['work_type_id'], $list_work)) {
                                $data_send[$candidate['id']]['jobs'][] = $job;
                            }
                        }
                        if(isset($data_send[$candidate['id']]) && $data_send[$candidate['id']]) {
                            $data_send[$candidate['id']]['info'] = $candidate;
                        }
                    }
                    if(count($data_send) >= 50) {
                        break;
                    }
                }
                return $data_send;
            }
        }
        return [];
    } 

    public static function sendSms($phone, $mesage) {
        return true;
    } 

}
