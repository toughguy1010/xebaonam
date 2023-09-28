<?php if($this->beginCache('box_search')) { ?>
<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/javascripts/jquery.masonry.min.js");
?>

<div class="s-top-w fixbg" style="position:relative;">
    <?php
    /*
         * trades group
         */
        $query = "SELECT b.trade_id,b.trade_name,c.group_id as parent,c.group_name,b.count_news as count_news ";
        $query.=" from lov_trades b";
        //$query .=" INNER join lov_trades b on find_in_set(b.trade_id,a.trade_id) ";
        $query .=" INNER JOIN lov_trade_groups c ON c.group_id=b.group_id";
        $query.="  group by b.trade_id ";
        $trade_group = Yii::app()->db->createCommand($query)
                ->queryAll();
         //$trade_group = $this->Gettradesgroup();
//        $region1 = $this->GetregionByLand(1);//mien bac
//        $region2 = $this->GetregionByLand(2);//mien trung
//        $region3 = $this->GetregionByLand(3);//mien nam
        
        //$region = $this->GetregionByLand(3);
        $region  = $this->GetregionByLand();
        $region1 = array();
        $region2 = array();
        $region3 = array();
        foreach($region as $list)
        {
            if($list['land_id'] == 1) array_push($region1,array('region_id'=>$list['region_id'],'default_name'=>$list['default_name']));
            if($list['land_id'] == 2) array_push($region2,array('region_id'=>$list['region_id'],'default_name'=>$list['default_name']));
            if($list['land_id'] == 3) array_push($region3,array('region_id'=>$list['region_id'],'default_name'=>$list['default_name']));     
        }
    
    
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'frm-search',
        'action' => '',
        'method' => 'post',
        'htmlOptions' => array('style' => 'padding-left:10px; width:96%')
            ));
    ?>

    <h1>Tìm việc</h1>
    <div class="w-row first-row">
        <select name="createdate" id="createdate" class="mySelect ui-input fix myInput"   data-placeholder='Tất cả ngày đăng tuyển'>
            <option value="">Tất cả ngày đăng tuyển</option>

            <?php for ($i = 0; $i < 7; $i++): ?>
                <option <?php if ($model->createdate == $i + 1) echo "selected='selected'"; ?> value="<?php echo $i + 1; ?>">Trong <?php echo $i + 1 ?> ngày</a></option>
            <?php endfor ?>
            <?php for ($j = 2; $j <= 4; $j++): ?>
                <option <?php if ($model->createdate == $j * 7) echo 'selected="selected"'; ?> value="<?php echo $j * 7; ?>">Trong vòng <?php echo $j ?> tuần</option>
            <?php endfor; ?>

        </select>
        <?php echo $form->dropDownList($model, 'typeofwork', Yii::app()->params['typeOfWork'], array('prompt' => 'Loại công việc', 'class' => 'mySelect ui-input fix myInput', 'name' => 'type', 'id' => 'type')) ?>
        <?php echo $form->dropDownList($model, 'provinces', Chtml::listData($region, 'region_id', 'default_name'), array('name' => 'provinces', 'prompt' => 'Tất cả địa điểm', 'class' => 'mySelect ui-input fix myInput', 'id' => 'provinces', 'clear' => 1, 'rel' => 'city-box')) ?>

        <?php echo $form->dropDownList($model, 'trade_id', Chtml::listData($trade_group, 'trade_id', 'trade_name'), array('name' => 'trade_id', 'prompt' => 'Chọn ngành nghề', 'class' => 'mySelect ui-input fix myInput', 'id' => 'trade_id', 'clear' => 1, 'rel' => 'trade-box')) ?>  
    </div>
    <div class="w-row second-row">

        <?php echo $form->dropDownList($model, 'experience', Yii::app()->params['experience'], array('prompt' => 'Số năm kinh nghiệm', 'class' => 'mySelect ui-input fix', 'name myInput' => 'exp', 'id' => 'exp')) ?>
    </div>

    <div style="clear:both"></div>
    <input class="search_now" name="" type="button" onclick="search_list();" value="Tìm ngay" />
    <?php if (!Yii::app()->user->isGuest) { ?>
        <a id="save_condition" class="btn add" href="javascript:void(0)" style="
           border: 1px solid #004F99;
           padding: 6.3px 27px; font-size: 12px;
           height: 24px;
line-height: 23px;
           "/>Lưu lại</a>
       <?php } ?>
<input type='hidden' name='type_condition' value='work' />
<input type='hidden' name='session' value='<?= Generate::getSession() ?>' />


<?php $this->endWidget(); ?><!-- end form -->
</div>


<div class="city-box dialog-city" style="display:none">

    <div class="body-box">
        <div class="head">
            <h3 class="all" rel='' id="" href="#">Toàn quốc</h3>
            <a class="close" onclick="$('.dialog-city').hide();"><img title="Đóng" src="<?php echo Yii::app()->baseUrl . '/images/work/i_close2.gif' ?>" width="13" height="13" /></a>
            <br/>
            <div class="">
                <input type="text" id="search_city" value="" placeholder="Tìm kiếm tên tỉnh thành"/>
            </div>

        </div>

        <div class="content-block">
            <div class="land1">
                <h3 class="title_land"> Miền Bắc</h3>

                <?php ?>
                <?php foreach ($region1 as $city): ?>
                    <a class="city-item"  rel="<?php echo $city["region_id"] ?>" href=""><span><?php echo $city['default_name'] ?></span></a>
                <?php endforeach ?>

            </div>
            <div class="land1">
                <h3 class="title_land"> Miền Trung</h3>
                <?php foreach ($region2 as $city): ?>
                    <a class="city-item"  rel="<?php echo $city["region_id"] ?>" href=""><span><?php echo $city['default_name'] ?></span></a>
                <?php endforeach ?>

            </div>
            <div class="land1">
                <h3 class="title_land"> Miền Nam</h3>


                <?php foreach ($region3 as $city): ?>
                    <a class="city-item"  rel="<?php echo $city["region_id"] ?>" href=""><span><?php echo $city['default_name'] ?></span></a>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</div> 

<!-- Tim kiem theo nghanh nghe -->
<div class="city-box trade-box" style="display:none">

    <div class="head">
        <h3 class="all" rel="" id="" href="#">Lựa chọn nghành nghề</h3>
        <a class="close" onclick="$('.trade-box').hide();"><img title="Đóng" src="<?php echo Yii::app()->baseUrl . '/images/work/i_close2.gif' ?>" width="13" height="13" /></a>
        <br>
        <div class="">
            <input type="text" id="search_trade" value="" placeholder="Tìm kiếm nghề nghiệp"/>
        </div>

    </div>

    <div class="trade-row">
       
<?php 
$id="";
$c=0;
$icon=0;
foreach($trade_group as $key=>$trades):?>
	<?php if($trades['parent']!=$id):?>
			<?php $icon++ ;?>
			<?php if($key!='0'):?></ul></div><?php endif?>
			
				<?php if($key!='0'):?></div><?php endif?>
				<div class=" trade-colum">
					
		<?php $c++;?>
                                    <div>	

		
			<h3><?= $trades['group_name']; ?></h3>
                               
		
	<ul>
		<?php endif;?>
		<li><a class="trade-item"  rel="<?= $trades['trade_id']; ?>" href=""><span> <?= $trades['trade_name']; ?></span></a></li>
		<?php  $id=$trades['parent'];?>
<?php endforeach ?>
	</ul>
	
                                        </div>
	</div>

    </div>

</div> 

<?php
$this->widget("bDialog", array(
    'overlay_id' => 'bfhQMessage',
    'dialog_id' => 'bfhQMDialog',
    'body_close' => false,
    'title' => 'Thông báo',
    'footer' => true,
    'footer_close' => true,
    'top' => '145px'));
?>

<div id = "save_condition_success" style = "display: none;" >
    <p>Điều kiện tìm kiếm đã được lưu thành công!</p>
</div>

<div id = "save_condition_failed" style = "display: none;" >
    <p>Lưu điều kiện tìm kiếm đã thất bại!</p>
</div>
<?php $this->endCache(); } ?>