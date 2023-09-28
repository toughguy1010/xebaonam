<?php
class TopRecruiter extends CWidget{
	
	public function init(){
		parent::init();
	}
	
	
	public function getData(){

	$query="select company_id,company_name,company_logo from lov_companies ";
	$query.=" where company_logo is not null";
	$query.=" order by interest_total DESC limit 6 ";
	$data=Yii::app()->db->createCommand($query)->queryAll();
		return $data;
	}
	
	public function run(){
	
		$recruit=$this->getData();
		$this->render('recruiter',array("recruiter"=>$recruit));
	}
}

