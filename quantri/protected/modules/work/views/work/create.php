<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/javascripts/tiny_mce/tiny_mce.js') ?>
<div class="create-item-w">
<div class="left_sidebar">
<h3 class="left-head" >ĐĂNG TUYỂN DỤNG</h3>
	<ul>
		<li>
		<h4>
			<span>1.</span>
			Thông tin đăng tuyển
		</h4>
		<span class="tip-content">
		Thông tin chi tiết về đăng tuyển sẽ giúp quý khách hàng thu hút nhiều ứng viên và tìm được nhiều hồ sơ nhất.
		</span>
		</li>
		<li>
		<h4>
			<span>2.</span>
			Xét đăng tuyển
		</h4>
		<span class="tip-content">
		Thông tin tuyển dụng của quý khách hàng sẽ được kiểm duyệt và hiển thị trong thời gian muộn nhất 1 ngày (với hơn 10 lần đăng tin tuyển dụng sẽ không bị kiểm duyệt)
		</span>
		</li>
	</ul>
</div>
<div class="block-right-post">
<?php $this->renderPartial('_form', array('model'=>$model,'obj_uCompany'=>$obj_uCompany,'region'=>$region,'trade'=>$trade,'currency_array'=>$currency_array)); ?>
</div>
<span class="clear"></span>
</div>
	