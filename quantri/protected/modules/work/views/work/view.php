<div class="contentBlog">
    <div id="left-content" class="mainBlog mainWork">
        
        
        <div class="uiBlog">
            <h1 class="title"><?php echo $model->position ?></h1>
            <p class="dt">
                    	Lượt xem: <span><?= $model->view;?></span>&nbsp;&nbsp;|&nbsp;&nbsp;
                       
                        <?php if ($model->user_id): ?>
                                <?php
                                $check = date("d", strtotime($model->createdate));
                                if ($check == date("d")) {
                                    $date = "Hôm nay";
                                } else {
                                    $date = "Ngày " . date("d-m", strtotime($model->createdate));
                                }
                                ?>
                                Gửi lúc : <?php echo date("h:i", strtotime($model->createdate)); ?> ,  <?php echo $date; ?>
<?php else: ?>
                                Gửi ngày : <?php echo date("d-m-Y", strtotime($model->createdate)); ?> <?php //echo $date; ?> 
    <?php endif; ?>
                                <span>
                                
                	
              <!--<a href="#" class="btn add">
                    	<i class="tims"></i>
                        Thích
                    </a>
                    <a href="#" class="btn add">
                    	<i class="like"></i>
                        Bình luận
                    </a>
                    <a href="#" class="btn add">
                    	<i class="share"></i>
                        Chia sẻ
                    </a>-->
                     <?php
                    Yii::import("application.modules.share.extensions.share_widget.*");
                    $this->widget("sharewidget", array(
                        "obj_id" => $model->news_id,
                        "type" => "work",
                        "class"=>"btn add",
                        "textinit" => "Chia sẻ",
                          "icon"=>"<i class='share_work'></i>",
                    ));
                    ?>
                
                                    </span>
            </p>
            <div class="contentDT">
                    	<div class="detail">
                        	<b><?= $company_obj->company_name;?> </b>
                            <p>
                            	<?= $company_obj->company_address;?>
                                <?= HtmlFormat::string_cut($company_obj->company_info,300)."...";?> <a target="blank" href="<?= Yii::app()->createUrl('company/company/detail',array('id'=>$model->company_id)); ?>">Xem thêm</a>
                            
                            </p>
                            <hr>
                            <b>Mô tả Công việc</b>
                            <p>
                            <?= $model->description; ?>
                            </p>
                            <hr>
                            <b>Yêu Cầu Công Việc</b>
                            <p>
                            	<?= $model->require_other;?>

                            </p>
                            
                        </div><!--detail-->
                    	<ul class="boxpst">
                        	<li>
                            	<b>Hạn Chót Nộp Hồ Sơ</b>
                                <p><?=  date('d-m-Y',strtotime($model->expiryday));?></p>
                            </li>
                            <li>
                                <b>Nơi Làm Việc</b>
                                <?php 
                                $array_provinces = explode(",", preg_replace("/,$/", '', $model->provinces));
                                $provinces = '';
                                for($i=0;$i<count($array_provinces);$i++)
                                {
                                    $province_cache = Yii::app()->cache->get("provinces_" . $array_provinces[$i]);
                                     $provinces .= '<p>
          <a class="load_content" href=' . Yii::app()->createUrl("/work/work/search", array("provinces" => $province_cache[0]['region_id'])) . '>' . $province_cache[0]['default_name'] . '
          </a>
         </p>';;
                                }
                                echo $provinces;
                                ?>
                            	
                                
                                
                            </li>
                            <li>
                            	<b>Cấp bậc</b>
                                <br/>
                                <span style="color:#0070CC;"><?= Yii::app()->params['office'][$model->office]?></span>
                                
                            </li>
                            <li>
                                  <b>Ngành nghề</b>
                                <?php $obj_trades = Trade::model()->findAll('trade_id IN (' . $model->trade_id . ')'); ?>
                                <?php foreach ($obj_trades as $obj_trade): ?>
                                    <p><a <a class="load_content" href="<?php echo $this->createUrl('/work/work/search', array('industry' => $obj_trade["trade_id"])) ?>"><?php echo $obj_trade["trade_name"] ?></a></p>
    <?php endforeach ?>
                            	
                            </li>
                        </ul><!--boxpst-->
       	    	  </div>
            <!-- contact -->
   <?php
   if($model->user_id != null): 
       $user_model = User::model()->findByPk($model->user_id);
       ?>
   <div class="ndt">
                  	<b>Người đăng tin <a href="<?= Yii::app()->createUrl("profile/profile/view", array("id"=>$model->user_id));?>" style="color:#0070cc"><?= $user_model->displayname;?></a></b>
                  
                        <a href="<?php echo Yii::app()->createUrl("profile/profile/view", array("id"=>$model->user_id)); ?>" class="ava load_content">
            	<img src="<?php if($user_model->avatar_path != "" && $user_model->avatar_name != "") echo $user_model->avatar_path . '/50_50/' . $user_model->avatar_name;?>" width="50" height="50" /></a>
            </a>
                    <div class="right">
                    	<div class="status">
                        	<i></i>
                            <?php 
                    $data = Yii::app()->db->createCommand("SELECT content FROM lov_feeds WHERE (to_type = 'status' or to_type = 'profile') and privilege = 'public' and user_id = ". $model->user_id . " ORDER BY createdate desc LIMIT 0,1")->queryRow();
                ?>
            	<?php 
                
                $content = strip_tags($data['content']);
                
                if(isset($content) && $content != '' ){
            	       if(strlen($content) >70){
            	           echo mb_substr($content, 0, 67) . '...';
            	       }else{
            	           echo $content;
            	       }
            	          
            	    
            	}else echo $user_model->displayname." chưa cập nhật trạng thái."; 
                
                ?>
                        </div>
                        <div class="bode one">
                        	<p>
                            	<span>Ngày tham gia</span> : <?= date('d-m-Y',strtotime($user_model->create_date))?>
                            </p>
                            <p>
                            	<span>Địa chỉ </span> : <?= $user_model->address; ?>
                        
                            </p>
                            <p>
                            	<span>Mobile </span> : <?= $user_model->phone;?>
                            </p>
                        </div>
                        <div class="bode">
                        	<p>
                            	<span>Skype</span> : <?= $user_model->skype; ?>
                            </p>
                            <p>
                            	<span>Yahoo </span> : <?= $user_model->yahoo_id; ?>
                            </p>
                            <p>
                            	<span>Website </span> : <a href="#"><?= $user_model->website; ?></a>
                            </p>
                        </div>
                    </div>
                    <div class="clear"></div>

   </div> 
            
            <div class="ctdk">
                	<div class="borTitbot">
                    	<b>Các tin tuyển dụng khác của <a href="<?php echo Yii::app()->createUrl("profile/profile/view", array("id"=>$searchbyuser)); ?>"><?= $user_model->displayname;?></a></b>
                        <a class="more"  href="<?= Yii::app()->baseUrl.'work/work/search.html?createdby='.$model->user_id;?>">
                        	Xem thêm
                            <i></i>
                        </a>
                    </div>
                    <ul class="otherListBlog">
                        <?php
                       
                        foreach($work_related_byuser as $list): ?>
                    	<li>
                        	<a href="<?= Yii::app()->createUrl('work/work/view',array('id'=>$list['news_id']));?>"><?= $list['position'];?></a>
                        </li>
                        <?php endforeach;?>
                    </ul>
                </div><!-- end contact --> 
   <?php else:
   
       $company_model = Companies::model()->findByPk($model->company_id);
    
       ?>
   <div class="ndt">
                  	<b>Công ty <a href="<?= Yii::app()->createUrl("company/company/detail", array("id"=>$company_model->company_id));?>" style="color:#0070cc"><?= $company_model->company_name;?></a></b>
                  
                        
                    <div class="right">
                    	
                        <div class="bode one">
                        	<p>
                            	<span>Địa chỉ</span> : <?= $company_model->company_address;?>
                            </p>
                            <p>
                            	<span>Phone </span> : <?= $company_model->company_phone; ?>
                        
                            </p>
                            <p>
                            	<span>Website </span> : <?= $company_model->company_website;?>
                            </p>
                        </div>
                        
                    </div>
                    <div class="clear"></div>

   </div>              <!-- end contact --> 
   <?php endif;?>
         
             
            
            
        </div><!-- end s-top-w-->
        <!-- commment -->
        


      
        
        
<?php if ($count > 0): ?>
    <div class="kqWork">      
    <?php $this->renderPartial("_list", array("models" => $sameGroup, 'count' => $count, 'pages' => $pages, 'title' => 'Các tin khác',)); ?>
    </div>
           
        <?php endif; ?>
            
    </div><!-- end left-content -->

    <div id="right-content" class="sideBarBlog">        	
        <!-- CONTENT RIGHT -->
<?php echo $this->renderPartial("_right", array('work_related' => $work_related, 'search' => true,'region'=>$region,
            'region1'=>$region1,
            'region2'=>$region2,
            'region3'=>$region3,
            'trade_group'=>$trade_group,)) ?>
    </div><!--right-content-->
    <div style="clear:both"></div>
</div><!-- end wrap -->
