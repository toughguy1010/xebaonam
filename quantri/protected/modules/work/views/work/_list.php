
<?php if (isset($title)): ?>
    <h1><?php echo $title ?></h1>
<?php else: 
    if($searchbyuser == 0):
    ?>
    <h1 class="ttnn">Tìm được <span><?= $count ?></span> kết quả</h1>
    <?php else:?>
    <h1 class="ttnn">Các tin đã đăng của <a style="color: #0070CC;" href="<?php echo Yii::app()->createUrl("profile/profile/view", array("id"=>$searchbyuser)); ?>"><?= User::model()->findByPk($searchbyuser)->displayname;?></a></h1>
    <?php endif;?>
<?php endif; ?>
<table class="tableWork" width="700" border="0" cellspacing="0" cellpadding="0">
    <tr class="trBlue trGray">
        <td class="span1">Chức danh</td>
        <td class="span2">Công ty</td>
        <td class="span3">Địa điểm</td>
        <td class="span4">Ngày đăng</td>
    </tr>

    <?php if (count($models)): ?>
        <?php foreach ($models as $k => $model): ?>
            <tr <?php if ($k % 2 == 0) : ?>class="trGray" <?php else: ?> class="" <?php endif ?>>
                <td><?php echo CHtml::link($model['position'], array('/work/work/view', 'id' => $model['news_id']), array('title' => $model['position'], 'class' => 'load_content')); ?></td>
                <td>
                    <?php
                    echo $model['company_name'];
                    ?>
                    <?php ?>
                </td>
                <td>
                 <?php 
                 
                 echo RecruitmentNews::model()->Getprovinces($model['provinces']); ?>

                </td>
                <td class="datetime"><?php
                    echo date("d-m-Y", strtotime($model['createdate']));
                    ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?><tr><td style="color:red">Không có bản ghi nào !</td></tr><?php endif ?>
</table>

<div  id="phantrang">
    <?php
    $this->widget('CLinkPager', array(
        'pages' => $pages,
        'header' => '',
        'maxButtonCount' => 5,
        'firstPageLabel' => '<<',
        'lastPageLabel' => '>>',
        'nextPageLabel' => '>',
        'prevPageLabel' => '<',
        'cssFile' => Yii::app()->baseUrl . '/css/phantrang.css',
            //'internalPageCssClass'=>'load_content'
    ))
    ?>
</div>
