
<div class="contentBlog">
    <div  class="mainBlog mainWork"">
          <div class="kqWork">
        <?php if (Yii::app()->user->hasFlash('message')): ?><script>alert("<?php echo Yii::app()->user->getFlash('message') ?>");</script><?php endif ?>

        <table class="tableWork" width="700" border="0" cellspacing="0" cellpadding="0">
             <tr class="trBlue trGray">
        <td class="span1">Chức danh</td>
        <td class="span2">Công ty</td>
        <td class="span3" width="70">Ngày hết hạn</td>
        <td class="span4">Ngày đăng</td>
        <td class="span4">Chỉnh sửa</td>
    </tr>
            <?php if (count($models)): ?>
                <?php foreach ($models as $k => $model): ?>
                    <tr <?php if ($k % 2 == 0) : ?>class="trGray" <?php else: ?> class="row-table white" <?php endif ?>>
                        <td><?php echo CHtml::link($model['position'], array('/work/work/view', 'id' => $model['news_id']), array('title' => $model['position'],'class'=>'load_content')); ?></td>
                        <td>
                            <?php echo $model['company_name']; ?>
                        </td>
                        <td class="datetime"><?php
                    echo date("d-m-Y", strtotime($model['expiryday']));
                            ?></td>
                        <td class="datetime"><?php
                    echo date("d-m-Y", strtotime($model['createdate']));
                            ?></td>
                        <td>
                            <span> <?php echo CHtml::link("Sửa", array('/work/work/update', 'id' => $model['news_id']), array('title' => $model['position'],'class'=>'load_content')); ?> </span>| 
                            <?php echo CHtml::link("Xóa", array('/work/work/delete', 'id' => $model['news_id']), array('title' => $model['position'], 'onclick' => 'var r=confirm("Bạn có muốn xóa tin việc làm này không!");
if (r==true)
  {
  return true;
  }
else
  {
  return false;
  }')); ?> 
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?><tr><td style="color:red">Không có bản ghi nào !</td></tr><?php endif ?>
        </table>
            <div class="phantrang">
<?php $this->widget('CLinkPager', array(
				'pages' => $pages,
				'header'=>'',
				'maxButtonCount'=>5,
                                'firstPageLabel' => '&lt;&lt;',
                                'lastPageLabel' => '&gt;&gt;',
				'nextPageLabel'=>'Tiếp &gt;',
				'prevPageLabel'=>'&lt; Trang trước ',
                                'cssFile'=>Yii::app()->baseUrl.'/css/phantrang.css'
			)) ?>
</div>
    </div>
          </div>
</div>
<div id="right-content" class="sideBarBlog">        	
    <!-- CONTENT RIGHT -->
    <?php echo $this->renderPartial("_right", array('work_related' => $work_related)) ?>

</div><!--right-content-->
<div style="clear:both">
