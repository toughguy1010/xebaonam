<?php

/**
 */
class ServiceHelper extends BaseHelper {

    protected $services = array();
    protected $providers = array();
    protected $dayoffs = array();
    protected $providerServices = array();
    protected $providerSchedules = array();
    protected $providerScheduleBreaks = array();
    protected $appoinments = array();

    function getBookingInfo($services = '', $providers = '', $date = 0, $start_time = 0, $options = array()) {
        if (is_string($services)) {
            $services = explode(ClaService::separate_params_character, $services);
        }
        if (is_string($providers)) {
            $providers = explode(ClaService::separate_params_character, $providers);
        }
        // list service id theo thứ tự
        $serviceIDs = $this->processServiceIDData($services);
        // list provider id theo thứ tự tương ứng với service
        $providerIDs = $this->processProviderIDData($providers);
        //
        $results = array();
        if (count($serviceIDs) != count($providerIDs)) {
            return $results;
        }
        //
        if (is_numeric($date)) {
            $dateTimeStamp = $date;
            $date = date('Y-m-d', $dateTimeStamp);
        } else {
            $dateTimeStamp = strtotime($date);
            $date = date('Y-m-d', $dateTimeStamp);
        }
        if (!$date || !$dateTimeStamp) {
            return $results;
        }
        //
        $dayIndex = (int) key(ClaDateTime::getDaysOfWeekFromDate($date));
        $site_id = isset($options['site_id']) ? (int) $options['site_id'] : Yii::app()->controller->id;
        $check = true;
        foreach ($serviceIDs as $serviceIndex => $service_id) {
            $provider_id = isset($providerIDs[$serviceIndex]) ? $providerIDs[$serviceIndex] : 0;
            if (!$provider_id) {
                $check = false;
                break;
            }
            $service = $this->getServiceInfo($service_id);
            $provider = $this->getProviderInfo($provider_id);
            if (!$service || !$provider) {
                $check = false;
                break;
            }
            $providerService = $this->getProviderService($provider_id, $service_id, $site_id);
            if (!$providerService) {
                $check = false;
                break;
            }
            $providerSchedule = $this->getProviderSchedule($provider['id'], $dayIndex, $site_id);
            if (!$providerSchedule || $providerSchedule && (!$providerSchedule['start_time'] && !$providerSchedule['end_time'])) {
                $check = false;
                break;
            }
            if (!$providerService['price']) {
                $providerService['price'] = $service['price'];
            }
            if (!$providerService['duration']) {
                $providerService['duration'] = $service['duration'];
            }

            $results[$serviceIndex]['provider'] = $provider;
            $results[$serviceIndex]['providerService'] = $providerService;
            $results[$serviceIndex]['providerSchedule'] = $providerSchedule;
            $results[$serviceIndex]['service'] = $service;
            $results[$serviceIndex]['date'] = $dateTimeStamp;
            $results[$serviceIndex]['duration'] = $providerService['duration'];
            $results[$serviceIndex]['start_time'] = $start_time;
            $start_time+=$service['padding_left'] + $service['padding_right'] + $providerService['duration'];
        }
        return $results;
    }

    /**
     * 
     * @param type $listServices
     * @param type $listProviders
     * @param type $date
     * @param type $options
     */
    function filter($listServices = array(), $listProviders = array(), $date = '', $options = array()) {
        $results = array();
        if (!$listServices) {
            return $results;
        }
        $dateTimeStamp = strtotime($date);
        if (!$date || !$dateTimeStamp) {
            $date = date('d-m-Y');
            $dateTimeStamp = strtotime($date);
        }
        //
        $dateDelay = ClaService::getDateDelay();
        if ($dateDelay) {
            $cdate = date('d-m-Y');
            $ddiff = ClaDateTime::subtractDate($cdate, $date);
            if ($ddiff < $dateDelay) {
                 return $results;
            }
        }
        //
        $searchDate = date('Y-m-d', $dateTimeStamp);
        $searchDay = (int) date('d', $dateTimeStamp);
        $currentTime = time();
        $currentDay = (int) date('d', $currentTime);
        //
        $dayIndex = (int) key(ClaDateTime::getDaysOfWeekFromDate($date));
        if ($currentTime >= $dateTimeStamp && $searchDay != $currentDay) {
            return $results;
        }
        $site_id = isset($options['site_id']) ? (int) $options['site_id'] : Yii::app()->controller->id;
        // list service id theo thứ tự
        $serviceIDs = $this->processServiceIDData($listServices);
        $countService = count($serviceIDs);
        // list provider id theo thứ tự tương ứng với service
        $providerIDs = $this->processProviderIDData($listProviders);
        //
        $providers = $this->getProviceIDsFollowServices($providerIDs, $serviceIDs);
        // các cặp hoán vị provider theo sự sắp xếp của service
        $providerPermutions = $this->permutation($providers);
        //
        $data = array();
        $currentStamp = 0;
        if ($searchDay == $currentDay) {
            $currentStamp = (int) date('H') * 3600 + (int) date('i') * 60 + (int) date('s');
        }
        //
        foreach ($providerPermutions as $providerCouple) {
            $info = array();
            $key = '';
            $check = true;
            $startTime = 0;
            $paddingLeft = 0;
            $endTime = 0;
            $timeDuration = 0;
            $breakTimes = array();
            $coupleProviderIDs = array();
            //
            foreach ($providerCouple as $serviceIndex => $provider) {
                $key.=$provider['id'] . '_';
                $dayOffs = $this->getDayoff($provider['id']);
                if (SeDaysoff::isDayOff($date, array('dayOffs' => $dayOffs))) {
                    $check = false;
                    break;
                }
                $providerService = $this->getProviderService($provider['id'], $serviceIDs[$serviceIndex], $site_id);
                if (!$providerService) {
                    $check = false;
                    break;
                }
                $providerSchedule = $this->getProviderSchedule($provider['id'], $dayIndex, $site_id);
                if (!$providerSchedule || $providerSchedule && (!$providerSchedule['start_time'] && !$providerSchedule['end_time'])) {
                    $check = false;
                    break;
                }
                $service = $this->getServiceInfo($serviceIDs[$serviceIndex]);
                if (!$providerService['price']) {
                    $providerService['price'] = $service['price'];
                }
                if (!$providerService['duration']) {
                    $providerService['duration'] = $service['duration'];
                }
                //
                $coupleProviderIDs[$serviceIndex] = $provider['id'];
                //
                $startTime = max($startTime, $providerSchedule['start_time']);
                $endTime = (!$endTime) ? $providerSchedule['end_time'] : min($endTime, $providerSchedule['end_time']);
                $paddingLeft = (int) $service['padding_left'];
                $timeDuration+=(int) $service['padding_left'] + (int) $service['padding_right'] + (int) $providerService['duration'];
                //break
                $scheduleBreaks = $this->getProviderScheduleBreak($providerSchedule['id']);
                //
                $appointments = $this->getAppointment($provider['id'], $searchDate);
                //
                $providerBreakTimes = array_merge($appointments, $scheduleBreaks);
                $breakTimes = array_merge($breakTimes, $providerBreakTimes);
                //
                $providerCouple[$serviceIndex]['dayOffs'] = $dayOffs;
                $providerCouple[$serviceIndex]['provider'] = $provider;
                $providerCouple[$serviceIndex]['providerService'] = $providerService;
                $providerCouple[$serviceIndex]['providerSchedule'] = $providerSchedule;
                $providerCouple[$serviceIndex]['service'] = $service;
                $providerCouple[$serviceIndex]['scheduleBreaks'] = $scheduleBreaks;
                $providerCouple[$serviceIndex]['appointments'] = $appointments;
                $providerCouple[$serviceIndex]['breakTimes'] = $breakTimes;
            }
            if ($check) {
                $timeStep = $startTime + $paddingLeft;
                $timeEnd = $endTime;
                $times = array();
                while ($timeStep + $timeDuration <= $timeEnd && $timeStep) {
                    if ($currentStamp && $timeStep < $currentStamp) {
                        $timeStep+=$timeDuration;
                        continue;
                    }
                    if (!ClaDateTime::checkIntersectTime($timeStep, $timeStep + $timeDuration, $breakTimes)) {
                        $times[] = array(
                            'start_time' => $timeStep,
                            'end_time' => $timeStep + $timeDuration,
                        );
                    }
                    $timeStep+=$timeDuration;
                }
            }
            //
            if ($check && $times) {
                $data[$key]['info'] = $providerCouple;
                $data[$key]['times'] = $times;
                $data[$key]['services'] = implode(ClaService::separate_params_character, $serviceIDs);
                $data[$key]['providers'] = implode(ClaService::separate_params_character, $coupleProviderIDs);
                $data[$key]['date'] = $date;
                $data[$key]['key'] = ClaGenerate::encrypt(json_encode(array('services' => $data[$key]['services'], 'providers' => $data[$key]['providers'])));
            }
        }
        $results['data'] = $data;
        $results['type'] = $countService;
        //
        return $results;
    }

    /**
     * 
     */
    function suggestDate($listServices = array(), $listProviders = array(), $date = '', $options = array()) {
        $results = array();
        if (!$listServices) {
            return $results;
        }
        //
        $dateTimeStamp = strtotime($date);
        if (!$date || !$dateTimeStamp) {
            $date = date('d-m-Y');
            $dateTimeStamp = strtotime($date);
        }
        //
        $dateDelay = ClaService::getDateDelay();
        if ($dateDelay) {
            $cdate = date('d-m-Y');
            $ddiff = ClaDateTime::subtractDate($cdate, $date);
            if ($ddiff < $dateDelay) {
                $date = date('m/d/Y', strtotime($date . ' +' . ($dateDelay - $ddiff) . ' day'));
                $dateTimeStamp = strtotime($date);
            }
        }
        //
        $searchDate = date('Y-m-d', $dateTimeStamp);
        $searchDay = (int) date('d', $dateTimeStamp);
        $currentTime = time();
        $currentDay = (int) date('d', $currentTime);
        //
        $site_id = isset($options['site_id']) ? (int) $options['site_id'] : Yii::app()->controller->id;
        // list service id theo thứ tự
        $serviceIDs = $this->processServiceIDData($listServices);
        // list provider id theo thứ tự tương ứng với service
        $providerIDs = $this->processProviderIDData($listProviders);
        //
        $providers = $this->getProviceIDsFollowServices($providerIDs, $serviceIDs);
        // các cặp hoán vị provider theo sự sắp xếp của service
        $providerPermutions = $this->permutation($providers);
        //
        $data = array();
        $currentStamp = 0;
        if ($searchDay == $currentDay) {
            $currentStamp = (int) date('H') * 3600 + (int) date('i') * 60 + (int) date('s');
        }
        $suggestDate = '';
        $count = 1;
        //
        while (true) {
            $count++;
            if ($count >= 15) {
                break;
            }
            $date = date('m/d/Y', strtotime($date . ' +1 day'));
            $currentStamp = 0;
            //
            $dayIndex = (int) key(ClaDateTime::getDaysOfWeekFromDate($date));
            if ($currentTime >= $dateTimeStamp && $searchDay != $currentDay) {
                return $results;
            }
            //
            foreach ($providerPermutions as $providerCouple) {
                $info = array();
                $key = '';
                $check = true;
                $startTime = 0;
                $endTime = 0;
                $timeDuration = 0;
                $breakTimes = array();
                $coupleProviderIDs = array();
                //
                foreach ($providerCouple as $serviceIndex => $provider) {
                    $key.=$provider['id'] . '_';
                    $dayOffs = $this->getDayoff($provider['id']);
                    if (SeDaysoff::isDayOff($date, array('dayOffs' => $dayOffs))) {
                        $check = false;
                        break;
                    }
                    $providerService = $this->getProviderService($provider['id'], $serviceIDs[$serviceIndex], $site_id);
                    if (!$providerService) {
                        $check = false;
                        break;
                    }
                    $providerSchedule = $this->getProviderSchedule($provider['id'], $dayIndex, $site_id);
                    if (!$providerSchedule || $providerSchedule && (!$providerSchedule['start_time'] && !$providerSchedule['end_time'])) {
                        $check = false;
                        break;
                    }
                    $service = $this->getServiceInfo($serviceIDs[$serviceIndex]);
                    if (!$providerService['price']) {
                        $providerService['price'] = $service['price'];
                    }
                    if (!$providerService['duration']) {
                        $providerService['duration'] = $service['duration'];
                    }
                    //
                    $coupleProviderIDs[$serviceIndex] = $provider['id'];
                    //
                    $startTime = max($startTime, $providerSchedule['start_time']);
                    $endTime = (!$endTime) ? $providerSchedule['end_time'] : min($endTime, $providerSchedule['end_time']);
                    $timeDuration+=$service['padding_left'] + $service['padding_right'] + $providerService['duration'];
                    //break
                    $scheduleBreaks = $this->getProviderScheduleBreak($providerSchedule['id']);
                    //
                    $appointments = $this->getAppointment($provider['id'], $searchDate);
                    //
                    $providerBreakTimes = array_merge($appointments, $scheduleBreaks);
                    $breakTimes = array_merge($breakTimes, $providerBreakTimes);
                    //
                    $providerCouple[$serviceIndex]['dayOffs'] = $dayOffs;
                    $providerCouple[$serviceIndex]['provider'] = $provider;
                    $providerCouple[$serviceIndex]['providerService'] = $providerService;
                    $providerCouple[$serviceIndex]['providerSchedule'] = $providerSchedule;
                    $providerCouple[$serviceIndex]['service'] = $service;
                    $providerCouple[$serviceIndex]['scheduleBreaks'] = $scheduleBreaks;
                    $providerCouple[$serviceIndex]['appointments'] = $appointments;
                    $providerCouple[$serviceIndex]['breakTimes'] = $breakTimes;
                }
                if ($check) {
                    $timeStep = $startTime;
                    $timeEnd = $endTime;
                    $times = array();
                    while ($timeStep + $timeDuration <= $timeEnd && $timeStep) {
                        if ($currentStamp && $timeStep < $currentStamp) {
                            $timeStep+=$timeDuration;
                            continue;
                        }
                        if (!ClaDateTime::checkIntersectTime($timeStep, $timeStep + $timeDuration, $breakTimes)) {
                            $suggestDate = $date;
                            break;
                        }
                        $timeStep+=$timeDuration;
                    }
                }
                //
                if ($suggestDate) {
                    break;
                }
            }
            if ($suggestDate) {
                break;
            }
        }
        //
        return $suggestDate;
    }

    /**
     * Hoán vị giữa các provider được sắp xếp theo thứ tự các services
     * @param type $listProviders
     * @return array
     */
    function permutation($listProviders = array()) {
        $permutations = array();
        $iter = 0;
        while (true) {
            $num = $iter++;
            $pick = array();
            foreach ($listProviders as $service_index => $providers) {
                $proIdKey = array_keys($providers);
                $count = count($proIdKey);
                if (!$count) {
                    break;
                }
                $r = $num % $count;
                $num = ($num - $r) / $count;
                $pick[$service_index] = $providers[$proIdKey[$r]];
            }
            if ($num > 0) {
                break;
            }
            $permutations[] = $pick;
        }

        return $permutations;
    }

    /**
     * 
     * @param type $listService
     * @return array service_index=>$service_id
     */
    function processServiceIDData($listService = array()) {
        $countListService = count($listService);
        $data = array();
        $start = 0;
        $end = ($countListService >= ClaService::max_filter_service_length) ? ClaService::max_filter_service_length : $countListService;
        foreach ($listService as $service_id) {
            if ($start >= $end) {
                break;
            }
            $data[$start] = $service_id;
            $start++;
        }
        return $data;
    }

    /**
     * 
     * @param type $listProvider
     * @return array service_index=>provider_id
     */
    function processProviderIDData($listProvider = array()) {
        $countListProvider = count($listProvider);
        $data = array();
        $start = 0;
        $end = ($countListProvider >= ClaService::max_filter_service_length) ? ClaService::max_filter_service_length : $countListProvider;
        foreach ($listProvider as $provider_id) {
            if ($start >= $end) {
                break;
            }
            $data[$start] = $provider_id;
            $start++;
        }
        return $data;
    }

    /**
     * 
     * @param type $providerIDs
     * @param type $serviceIDs
     * return array service_index=>array(list provider provide this service)
     */
    function getProviceIDsFollowServices($providerIDs = array(), $serviceIDs = array()) {
        $data = array();
        foreach ($serviceIDs as $index => $service_id) {
            if (isset($providerIDs[$index]) && $providerIDs[$index]) {
                $data[$index] = array($providerIDs[$index] => $this->getProviderInfo($providerIDs[$index]));
            } else {
                $data[$index] = SeProviders::getProviders(array('service_id' => $service_id));
            }
        }
        return $data;
    }

    /**
     * get service info
     * 
     * @param type $service_id
     * @return array
     */
    function getServiceInfo($service_id = 0) {
        $info = array();
        $service_id = (int) $service_id;
        if (!$service_id) {
            return $info;
        }
        $services = $this->getServices();
        if (isset($services[$service_id])) {
            $info = $services[$service_id];
        } else {
            $se = SeServices::model()->findByPk($service_id);
            if ($se) {
                $info = $se->attributes;
            }
            $services[$service_id] = $info;
            $this->setServices($services);
        }
        return $info;
    }

    /**
     * get provider info
     * 
     * @param type $provider_id
     * @return array
     */
    function getProviderInfo($provider_id = 0) {
        $info = array();
        $provider_id = (int) $provider_id;
        if (!$provider_id) {
            return $info;
        }
        $providers = $this->getProviders();
        if (isset($providers[$provider_id])) {
            $info = $providers[$provider_id];
        } else {
            $pro = SeProviders::model()->findByPk($provider_id);
            if ($pro) {
                $info = $pro->attributes;
            }
            $providers[$provider_id] = $info;
            $this->setProviders($providers);
        }
        return $info;
    }

    /**
     * 
     * @param type $provider_id
     */
    function getDayoff($provider_id = 0) {
        $info = array();
        $provider_id = (int) $provider_id;
        if (!$provider_id) {
            return $info;
        }
        $dayoffs = $this->getDayoffs();
        if (isset($dayoffs[$provider_id])) {
            $info = $dayoffs[$provider_id];
        } else {
            $days = SeDaysoff::getDaysOff(array(
                        'provider_id' => $provider_id,
            ));
            if ($days) {
                $info = $days;
            }
            $dayoffs[$provider_id] = $info;
            $this->setDayoffs($dayoffs);
        }
        return $info;
    }

    /**
     * 
     * @param type $provider_id
     * @param type $service_id
     * @param type $site_id
     * @return array
     */
    function getProviderService($provider_id = 0, $service_id = 0, $site_id = 0) {
        $info = array();
        $provider_id = (int) $provider_id;
        $service_id = (int) $service_id;
        $site_id = ((int) $site_id) ? (int) $site_id : Yii::app()->controller->site_id;
        if (!$provider_id || !$service_id) {
            return $info;
        }
        $key = $provider_id . '_' . $service_id . '_' . $site_id;
        $providerServices = $this->getProviderServices();
        if (isset($providerServices[$key])) {
            $info = $providerServices[$key];
        } else {
            $providerService = SeProviderServices::model()->findByAttributes(array(
                'site_id' => $site_id,
                'provider_id' => (int) $provider_id,
                'service_id' => (int) $service_id,
            ));
            if ($providerService) {
                $info = $providerService->attributes;
            }
            $providerServices[$key] = $info;
            $this->setProviderServices($providerServices);
        }
        return $info;
    }

    /**
     * 
     * @param type $provider_id
     * @param type $day_index
     * @param type $site_id
     * @return array
     */
    function getProviderSchedule($provider_id = 0, $day_index = 0, $site_id = 0) {
        $info = array();
        $provider_id = (int) $provider_id;
        $day_index = (int) $day_index;
        $site_id = ((int) $site_id) ? (int) $site_id : Yii::app()->controller->site_id;
        if (!$provider_id) {
            return $info;
        }
        $key = $provider_id . '_' . $day_index . '_' . $site_id;
        $providerSchedules = $this->getProviderSchedules();
        if (isset($providerSchedules[$key])) {
            $info = $providerSchedules[$key];
        } else {
            $schedule = SeProviderSchedules::model()->findByAttributes(array(
                'site_id' => $site_id,
                'provider_id' => $provider_id,
                'day_index' => $day_index,
            ));
            if ($schedule) {
                $info = $schedule->attributes;
            }
            $providerSchedules[$key] = $info;
            $this->setProviderSchedules($providerSchedules);
        }
        return $info;
    }

    /**
     * 
     * @param type $provider_schedule_id
     */
    function getProviderScheduleBreak($provider_schedule_id = 0) {
        $info = array();
        $provider_schedule_id = (int) $provider_schedule_id;
        if (!$provider_schedule_id) {
            return $info;
        }
        $providerScheduleBreaks = $this->getProviderScheduleBreaks();
        if (isset($providerScheduleBreaks[$provider_schedule_id])) {
            $info = $providerScheduleBreaks[$provider_schedule_id];
        } else {
            $scheduleBreaks = SeProviderScheduleBreaks::getProviderScheduleBreaks(array(
                        'provider_schedule_id' => $provider_schedule_id,
            ));
            if ($scheduleBreaks) {
                $info = $scheduleBreaks;
            }
            $providerScheduleBreaks[$provider_schedule_id] = $info;
            $this->setProviderScheduleBreaks($providerScheduleBreaks);
        }
        return $info;
    }

    function getAppointment($provider_id = 0, $date = '') {
        $info = array();
        $provider_id = (int) $provider_id;
        $date = ($date) ? $date : date('Y-m-d');
        if (!$provider_id) {
            return $info;
        }
        $key = $provider_id . '_' . $date;
        $appointments = $this->getAppoinments();
        if (isset($appointments[$key])) {
            $info = $appointments[$key];
        } else {
            $apps = SeAppointments::getAppointments(array(
                        'provider_id' => $provider_id,
                        'date' => $date,
            ));
            if ($apps) {
                $info = $apps;
            }
            $appointments[$key] = $info;
            $this->setAppoinments($appointments);
        }
        return $info;
    }

    function getServices() {
        return $this->services;
    }

    function getProviders() {
        return $this->providers;
    }

    function setServices($services) {
        $this->services = $services;
    }

    function setProviders($providers) {
        $this->providers = $providers;
    }

    function getDayoffs() {
        return $this->dayoffs;
    }

    function setDayoffs($dayoffs) {
        $this->dayoffs = $dayoffs;
    }

    function getProviderServices() {
        return $this->providerServices;
    }

    function setProviderServices($providerServices) {
        $this->providerServices = $providerServices;
    }

    function getProviderSchedules() {
        return $this->providerSchedules;
    }

    function getProviderScheduleBreaks() {
        return $this->providerScheduleBreaks;
    }

    function getAppoinments() {
        return $this->appoinments;
    }

    function setProviderSchedules($providerSchedules) {
        $this->providerSchedules = $providerSchedules;
    }

    function setProviderScheduleBreaks($providerScheduleBreaks) {
        $this->providerScheduleBreaks = $providerScheduleBreaks;
    }

    function setAppoinments($appoinments) {
        $this->appoinments = $appoinments;
    }

}
