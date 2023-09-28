<?php
/* @var $this MenuController */
/* @var $model Menus */
/* @var $form CActiveForm */
?>

<div class="row">
    <div class="col-xs-12 no-padding">

        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'menus-form',
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
        ));
        ?>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'menu_title', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'menu_title', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'menu_title'); ?>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'parent_id', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownList($model, 'parent_id', $options, array('class' => 'span12 col-sm-12', 'disable' => 'disable')); ?>
                <?php echo $form->error($model, 'parent_id'); ?>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'menu_linkto', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php
                echo $form->radioButtonList($model, 'menu_linkto', MenusAdmin::getLinkToArr(), array(
                    'separator' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',
                    'labelOptions' => array('style' => 'display:inline'),
                    'class' => 'linkto',
                        )
                );
                ?>
                <?php echo $form->error($model, 'menu_linkto'); ?>
            </div>
        </div>

        <div class="control-group form-group" style="<?php echo ($model->menu_linkto == MenusAdmin::LINKTO_INNER) ? 'display: block' : 'display: none'; ?>">
            <?php echo $form->labelEx($model, 'menu_link', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownList($model, 'menu_values', MenusAdmin::getInnerLinks(), array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'menu_values'); ?>
            </div>
        </div>

        <div class="control-group form-group" style="<?php echo ($model->menu_linkto == MenusAdmin::LINKTO_OUTER) ? 'display: block' : 'display: none'; ?>">
            <?php echo $form->labelEx($model, 'menu_link', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'menu_link', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'menu_link'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'menu_order', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->textField($model, 'menu_order', array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'menu_order'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'status', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownList($model, 'status', ActiveRecord::statusArray(), array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'status'); ?>
            </div>
        </div>

        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'menu_target', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->dropDownlist($model, 'menu_target', MenusAdmin::getTagetArr(), array('class' => 'span12 col-sm-12')); ?>
                <?php echo $form->error($model, 'menu_target'); ?>
            </div>
        </div>
        <div class="control-group form-group">
            <?php echo $form->labelEx($model, 'iconclass', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
            <div class="controls col-sm-10">
                <?php echo $form->hiddenField($model, 'iconclass', array('class' => 'span12 col-sm-12')); ?>
                <div class="btn-group menu-icon" style="width:100%">
                    <a class="btn btn-icon">
                        <?php
                        echo ($model->iconclass) ? '<i class="' . $model->iconclass . '"></i>' : 'Icons';
                        ?>
                    </a>

                    <button data-toggle="dropdown" class="btn dropdown-toggle">
                        <span class="icon-caret-down icon-only"></span>
                    </button>

                    <ul class="dropdown-menu">
                        <li>
                            <div class="col-xs-12 fontawesome-icon-list">
                                <div class="row">
                                    <div class="icon-item col-md-2"><a href="../icon/adjust"><i class="icon-adjust"></i></a></div>
                                    <div class="icon-item col-md-2"><a href="../icon/shopping-cart"><i class="icon-shopping-cart"></i></a></div>
                                    <div class="icon-item col-md-2"><a href="../icon/anchor"><i class="icon-anchor"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/archive"><i class="icon-archive"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/area-chart"><i class="icon-area-chart"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/arrows"><i class="icon-arrows"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/arrows-h"><i class="icon-arrows-h"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/arrows-v"><i class="icon-arrows-v"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/asterisk"><i class="icon-asterisk"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/at"><i class="icon-at"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/car"><i class="icon-automobile"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/ban"><i class="icon-ban"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/university"><i class="icon-bank"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/bar-chart"><i class="icon-bar-chart"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/bar-chart"><i class="icon-bar-chart-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/barcode"><i class="icon-barcode"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/bars"><i class="icon-bars"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/beer"><i class="icon-beer"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/bell"><i class="icon-bell"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/bell-o"><i class="icon-bell-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/bell-slash"><i class="icon-bell-slash"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/bell-slash-o"><i class="icon-bell-slash-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/bicycle"><i class="icon-bicycle"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/binoculars"><i class="icon-binoculars"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/birthday-cake"><i class="icon-birthday-cake"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/bolt"><i class="icon-bolt"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/bomb"><i class="icon-bomb"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/book"><i class="icon-book"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/bookmark"><i class="icon-bookmark"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/bookmark-o"><i class="icon-bookmark-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/briefcase"><i class="icon-briefcase"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/bug"><i class="icon-bug"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/building"><i class="icon-building"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/building-o"><i class="icon-building-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/bullhorn"><i class="icon-bullhorn"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/bullseye"><i class="icon-bullseye"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/bus"><i class="icon-bus"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/taxi"><i class="icon-cab"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/calculator"><i class="icon-calculator"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/calendar"><i class="icon-calendar"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/calendar-o"><i class="icon-calendar-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/camera"><i class="icon-camera"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/camera-retro"><i class="icon-camera-retro"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/car"><i class="icon-car"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/caret-square-o-down"><i class="icon-caret-square-o-down"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/caret-square-o-left"><i class="icon-caret-square-o-left"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/caret-square-o-right"><i class="icon-caret-square-o-right"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/caret-square-o-up"><i class="icon-caret-square-o-up"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/cc"><i class="icon-cc"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/certificate"><i class="icon-certificate"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/check"><i class="icon-check"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/check-circle"><i class="icon-check-circle"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/check-circle-o"><i class="icon-check-circle-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/check-square"><i class="icon-check-square"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/check-square-o"><i class="icon-check-square-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/child"><i class="icon-child"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/circle"><i class="icon-circle"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/circle-o"><i class="icon-circle-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/circle-o-notch"><i class="icon-circle-o-notch"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/circle-thin"><i class="icon-circle-thin"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/clock-o"><i class="icon-clock-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/times"><i class="icon-close"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/cloud"><i class="icon-cloud"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/cloud-download"><i class="icon-cloud-download"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/cloud-upload"><i class="icon-cloud-upload"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/code"><i class="icon-code"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/code-fork"><i class="icon-code-fork"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/coffee"><i class="icon-coffee"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/cog"><i class="icon-cog"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/cogs"><i class="icon-cogs"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/comment"><i class="icon-comment"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/comment-o"><i class="icon-comment-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/comments"><i class="icon-comments"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/comments-o"><i class="icon-comments-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/compass"><i class="icon-compass"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/copyright"><i class="icon-copyright"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/credit-card"><i class="icon-credit-card"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/crop"><i class="icon-crop"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/crosshairs"><i class="icon-crosshairs"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/cube"><i class="icon-cube"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/cubes"><i class="icon-cubes"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/cutlery"><i class="icon-cutlery"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/tachometer"><i class="icon-dashboard"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/database"><i class="icon-database"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/desktop"><i class="icon-desktop"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/dot-circle-o"><i class="icon-dot-circle-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/download"><i class="icon-download"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/pencil-square-o"><i class="icon-edit"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/ellipsis-h"><i class="icon-ellipsis-h"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/ellipsis-v"><i class="icon-ellipsis-v"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/envelope"><i class="icon-envelope"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/envelope-o"><i class="icon-envelope-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/envelope-square"><i class="icon-envelope-square"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/eraser"><i class="icon-eraser"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/exchange"><i class="icon-exchange"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/exclamation"><i class="icon-exclamation"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/exclamation-circle"><i class="icon-exclamation-circle"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/exclamation-triangle"><i class="icon-exclamation-triangle"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/external-link"><i class="icon-external-link"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/external-link-square"><i class="icon-external-link-square"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/eye"><i class="icon-eye"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/eye-slash"><i class="icon-eye-slash"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/eyedropper"><i class="icon-eyedropper"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/fax"><i class="icon-fax"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/female"><i class="icon-female"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/fighter-jet"><i class="icon-fighter-jet"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/file-archive-o"><i class="icon-file-archive-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/file-audio-o"><i class="icon-file-audio-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/file-code-o"><i class="icon-file-code-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/file-excel-o"><i class="icon-file-excel-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/file-image-o"><i class="icon-file-image-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/file-video-o"><i class="icon-file-movie-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/file-pdf-o"><i class="icon-file-pdf-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/file-image-o"><i class="icon-file-photo-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/file-image-o"><i class="icon-file-picture-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/file-powerpoint-o"><i class="icon-file-powerpoint-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/file-audio-o"><i class="icon-file-sound-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/file-video-o"><i class="icon-file-video-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/file-word-o"><i class="icon-file-word-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/file-archive-o"><i class="icon-file-zip-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/film"><i class="icon-film"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/filter"><i class="icon-filter"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/fire"><i class="icon-fire"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/fire-extinguisher"><i class="icon-fire-extinguisher"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/flag"><i class="icon-flag"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/flag-checkered"><i class="icon-flag-checkered"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/flag-o"><i class="icon-flag-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/bolt"><i class="icon-flash"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/flask"><i class="icon-flask"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/folder"><i class="icon-folder"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/folder-o"><i class="icon-folder-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/folder-open"><i class="icon-folder-open"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/folder-open-o"><i class="icon-folder-open-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/frown-o"><i class="icon-frown-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/futbol-o"><i class="icon-futbol-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/gamepad"><i class="icon-gamepad"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/gavel"><i class="icon-gavel"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/cog"><i class="icon-gear"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/cogs"><i class="icon-gears"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/gift"><i class="icon-gift"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/glass"><i class="icon-glass"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/globe"><i class="icon-globe"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/graduation-cap"><i class="icon-graduation-cap"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/users"><i class="icon-group"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/hdd-o"><i class="icon-hdd-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/headphones"><i class="icon-headphones"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/heart"><i class="icon-heart"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/heart-o"><i class="icon-heart-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/history"><i class="icon-history"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/home"><i class="icon-home"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/picture-o"><i class="icon-image"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/inbox"><i class="icon-inbox"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/info"><i class="icon-info"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/info-circle"><i class="icon-info-circle"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/university"><i class="icon-institution"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/key"><i class="icon-key"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/keyboard-o"><i class="icon-keyboard-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/language"><i class="icon-language"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/laptop"><i class="icon-laptop"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/leaf"><i class="icon-leaf"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/gavel"><i class="icon-legal"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/lemon-o"><i class="icon-lemon-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/level-down"><i class="icon-level-down"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/level-up"><i class="icon-level-up"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/life-ring"><i class="icon-life-bouy"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/lightbulb-o"><i class="icon-lightbulb-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/line-chart"><i class="icon-line-chart"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/location-arrow"><i class="icon-location-arrow"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/lock"><i class="icon-lock"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/magic"><i class="icon-magic"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/magnet"><i class="icon-magnet"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/share"><i class="icon-mail-forward"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/reply"><i class="icon-mail-reply"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/reply-all"><i class="icon-mail-reply-all"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/male"><i class="icon-male"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/map-marker"><i class="icon-map-marker"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/meh-o"><i class="icon-meh-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/microphone"><i class="icon-microphone"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/microphone-slash"><i class="icon-microphone-slash"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/minus"><i class="icon-minus"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/minus-circle"><i class="icon-minus-circle"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/minus-square"><i class="icon-minus-square"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/minus-square-o"><i class="icon-minus-square-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/mobile"><i class="icon-mobile"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/money"><i class="icon-money"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/moon-o"><i class="icon-moon-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/graduation-cap"><i class="icon-mortar-board"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/music"><i class="icon-music"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/bars"><i class="icon-navicon"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/newspaper-o"><i class="icon-newspaper-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/paint-brush"><i class="icon-paint-brush"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/paper-plane"><i class="icon-paper-plane"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/paper-plane-o"><i class="icon-paper-plane-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/paw"><i class="icon-paw"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/pencil"><i class="icon-pencil"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/pencil-square"><i class="icon-pencil-square"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/pencil-square-o"><i class="icon-pencil-square-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/phone"><i class="icon-phone"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/phone-square"><i class="icon-phone-square"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/picture-o"><i class="icon-photo"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/picture-o"><i class="icon-picture-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/pie-chart"><i class="icon-pie-chart"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/plane"><i class="icon-plane"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/plug"><i class="icon-plug"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/plus"><i class="icon-plus"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/plus-circle"><i class="icon-plus-circle"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/plus-square"><i class="icon-plus-square"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/plus-square-o"><i class="icon-plus-square-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/power-off"><i class="icon-power-off"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/print"><i class="icon-print"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/puzzle-piece"><i class="icon-puzzle-piece"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/qrcode"><i class="icon-qrcode"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/question"><i class="icon-question"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/question-circle"><i class="icon-question-circle"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/quote-left"><i class="icon-quote-left"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/quote-right"><i class="icon-quote-right"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/random"><i class="icon-random"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/recycle"><i class="icon-recycle"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/refresh"><i class="icon-refresh"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/times"><i class="icon-remove"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/bars"><i class="icon-reorder"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/reply"><i class="icon-reply"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/reply-all"><i class="icon-reply-all"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/retweet"><i class="icon-retweet"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/road"><i class="icon-road"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/rocket"><i class="icon-rocket"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/rss"><i class="icon-rss"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/rss-square"><i class="icon-rss-square"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/search"><i class="icon-search"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/search-minus"><i class="icon-search-minus"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/search-plus"><i class="icon-search-plus"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/paper-plane"><i class="icon-send"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/paper-plane-o"><i class="icon-send-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/share"><i class="icon-share"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/share-alt"><i class="icon-share-alt"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/share-alt-square"><i class="icon-share-alt-square"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/share-square"><i class="icon-share-square"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/share-square-o"><i class="icon-share-square-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/shield"><i class="icon-shield"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/shopping-cart"><i class="icon-shopping-cart"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/sign-in"><i class="icon-sign-in"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/sign-out"><i class="icon-sign-out"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/signal"><i class="icon-signal"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/sitemap"><i class="icon-sitemap"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/sliders"><i class="icon-sliders"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/smile-o"><i class="icon-smile-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/futbol-o"><i class="icon-soccer-ball-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/sort"><i class="icon-sort"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/sort-alpha-asc"><i class="icon-sort-alpha-asc"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/sort-alpha-desc"><i class="icon-sort-alpha-desc"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/sort-amount-asc"><i class="icon-sort-amount-asc"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/sort-amount-desc"><i class="icon-sort-amount-desc"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/sort-asc"><i class="icon-sort-asc"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/sort-desc"><i class="icon-sort-desc"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/sort-desc"><i class="icon-sort-down"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/sort-numeric-asc"><i class="icon-sort-numeric-asc"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/sort-numeric-desc"><i class="icon-sort-numeric-desc"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/sort-asc"><i class="icon-sort-up"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/space-shuttle"><i class="icon-space-shuttle"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/spinner"><i class="icon-spinner"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/spoon"><i class="icon-spoon"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/square"><i class="icon-square"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/square-o"><i class="icon-square-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/star"><i class="icon-star"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/star-half"><i class="icon-star-half"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/star-half-o"><i class="icon-star-half-empty"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/star-o"><i class="icon-star-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/suitcase"><i class="icon-suitcase"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/sun-o"><i class="icon-sun-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/life-ring"><i class="icon-support"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/tablet"><i class="icon-tablet"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/tachometer"><i class="icon-tachometer"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/tag"><i class="icon-tag"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/tags"><i class="icon-tags"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/tasks"><i class="icon-tasks"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/taxi"><i class="icon-taxi"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/terminal"><i class="icon-terminal"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/thumb-tack"><i class="icon-thumb-tack"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/thumbs-down"><i class="icon-thumbs-down"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/thumbs-o-down"><i class="icon-thumbs-o-down"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/thumbs-o-up"><i class="icon-thumbs-o-up"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/thumbs-up"><i class="icon-thumbs-up"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/ticket"><i class="icon-ticket"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/times"><i class="icon-times"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/times-circle"><i class="icon-times-circle"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/times-circle-o"><i class="icon-times-circle-o"></i> </a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/tint"><i class="icon-tint"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/caret-square-o-down"><i class="icon-toggle-down"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/caret-square-o-left"><i class="icon-toggle-left"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/toggle-off"><i class="icon-toggle-off"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/toggle-on"><i class="icon-toggle-on"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/caret-square-o-right"><i class="icon-toggle-right"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/caret-square-o-up"><i class="icon-toggle-up"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/trash"><i class="icon-trash"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/trash-o"><i class="icon-trash-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/tree"><i class="icon-tree"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/trophy"><i class="icon-trophy"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/truck"><i class="icon-truck"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/tty"><i class="icon-tty"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/umbrella"><i class="icon-umbrella"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/university"><i class="icon-university"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/unlock"><i class="icon-unlock"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/unlock-alt"><i class="icon-unlock-alt"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/sort"><i class="icon-unsorted"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/upload"><i class="icon-upload"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/user"><i class="icon-user"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/users"><i class="icon-users"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/video-camera"><i class="icon-video-camera"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/volume-down"><i class="icon-volume-down"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/volume-off"><i class="icon-volume-off"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/volume-up"><i class="icon-volume-up"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/exclamation-triangle"><i class="icon-warning"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/wheelchair"><i class="icon-wheelchair"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/wifi"><i class="icon-wifi"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/wrench"><i class="icon-wrench"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/file"><i class="icon-file"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/file-archive-o"><i class="icon-file-archive-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/file-audio-o"><i class="icon-file-audio-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/file-code-o"><i class="icon-file-code-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/file-excel-o"><i class="icon-file-excel-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/file-image-o"><i class="icon-file-image-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/file-video-o"><i class="icon-file-movie-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/file-o"><i class="icon-file-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/file-pdf-o"><i class="icon-file-pdf-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/file-image-o"><i class="icon-file-photo-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/file-image-o"><i class="icon-file-picture-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/file-powerpoint-o"><i class="icon-file-powerpoint-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/file-audio-o"><i class="icon-file-sound-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/file-text"><i class="icon-file-text"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/file-text-o"><i class="icon-file-text-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/file-video-o"><i class="icon-file-video-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/file-word-o"><i class="icon-file-word-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/file-archive-o"><i class="icon-file-zip-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/circle-o-notch"><i class="icon-circle-o-notch"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/cog"><i class="icon-cog"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/cog"><i class="icon-gear"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/refresh"><i class="icon-refresh"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/spinner"><i class="icon-spinner"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/check-square"><i class="icon-check-square"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/check-square-o"><i class="icon-check-square-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/circle"><i class="icon-circle"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/circle-o"><i class="icon-circle-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/dot-circle-o"><i class="icon-dot-circle-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/minus-square"><i class="icon-minus-square"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/minus-square-o"><i class="icon-minus-square-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/square"><i class="icon-square"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/square-o"><i class="icon-square-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/cc-amex"><i class="icon-cc-amex"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/cc-discover"><i class="icon-cc-discover"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/cc-mastercard"><i class="icon-cc-mastercard"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/cc-paypal"><i class="icon-cc-paypal"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/cc-stripe"><i class="icon-cc-stripe"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/cc-visa"><i class="icon-cc-visa"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/credit-card"><i class="icon-credit-card"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/google-wallet"><i class="icon-google-wallet"></i></div>

                                    <div class="icon-item col-md-2"><a href="../icon/paypal"><i class="icon-paypal"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/area-chart"><i class="icon-area-chart"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/bar-chart"><i class="icon-bar-chart"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/bar-chart"><i class="icon-bar-chart-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/line-chart"><i class="icon-line-chart"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/pie-chart"><i class="icon-pie-chart"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/btc"><i class="icon-bitcoin"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/btc"><i class="icon-btc"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/jpy"><i class="icon-cny"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/usd"><i class="icon-dollar"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/eur"><i class="icon-eur"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/eur"><i class="icon-euro"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/gbp"><i class="icon-gbp"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/ils"><i class="icon-ils"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/inr"><i class="icon-inr"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/jpy"><i class="icon-jpy"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/krw"><i class="icon-krw"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/money"><i class="icon-money"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/jpy"><i class="icon-rmb"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/rub"><i class="icon-rouble"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/rub"><i class="icon-rub"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/rub"><i class="icon-ruble"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/inr"><i class="icon-rupee"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/ils"><i class="icon-shekel"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/ils"><i class="icon-sheqel"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/try"><i class="icon-try"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/try"><i class="icon-turkish-lira"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/usd"><i class="icon-usd"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/krw"><i class="icon-won"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/jpy"><i class="icon-yen"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/align-center"><i class="icon-align-center"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/align-justify"><i class="icon-align-justify"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/align-left"><i class="icon-align-left"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/align-right"><i class="icon-align-right"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/bold"><i class="icon-bold"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/link"><i class="icon-chain"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/chain-broken"><i class="icon-chain-broken"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/clipboard"><i class="icon-clipboard"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/columns"><i class="icon-columns"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/files-o"><i class="icon-copy"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/scissors"><i class="icon-cut"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/outdent"><i class="icon-dedent"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/eraser"><i class="icon-eraser"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/file"><i class="icon-file"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/file-o"><i class="icon-file-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/file-text"><i class="icon-file-text"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/file-text-o"><i class="icon-file-text-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/files-o"><i class="icon-files-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/floppy-o"><i class="icon-floppy-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/font"><i class="icon-font"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/header"><i class="icon-header"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/indent"><i class="icon-indent"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/italic"><i class="icon-italic"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/link"><i class="icon-link"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/list"><i class="icon-list"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/list-alt"><i class="icon-list-alt"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/list-ol"><i class="icon-list-ol"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/list-ul"><i class="icon-list-ul"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/outdent"><i class="icon-outdent"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/paperclip"><i class="icon-paperclip"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/paragraph"><i class="icon-paragraph"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/clipboard"><i class="icon-paste"></i> </a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/repeat"><i class="icon-repeat"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/undo"><i class="icon-rotate-left"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/repeat"><i class="icon-rotate-right"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/floppy-o"><i class="icon-save"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/scissors"><i class="icon-scissors"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/strikethrough"><i class="icon-strikethrough"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/subscript"><i class="icon-subscript"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/superscript"><i class="icon-superscript"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/table"><i class="icon-table"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/text-height"><i class="icon-text-height"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/text-width"><i class="icon-text-width"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/th"><i class="icon-th"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/th-large"><i class="icon-th-large"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/th-list"><i class="icon-th-list"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/underline"><i class="icon-underline"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/undo"><i class="icon-undo"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/chain-broken"><i class="icon-unlink"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/arrows-alt"><i class="icon-arrows-alt"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/backward"><i class="icon-backward"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/compress"><i class="icon-compress"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/eject"><i class="icon-eject"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/expand"><i class="icon-expand"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/fast-backward"><i class="icon-fast-backward"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/fast-forward"><i class="icon-fast-forward"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/forward"><i class="icon-forward"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/pause"><i class="icon-pause"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/play"><i class="icon-play"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/play-circle"><i class="icon-play-circle"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/play-circle-o"><i class="icon-play-circle-o"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/step-backward"><i class="icon-step-backward"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/step-forward"><i class="icon-step-forward"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/stop"><i class="icon-stop"></i></a></div>

                                    <div class="icon-item col-md-2"><a href="../icon/youtube-play"><i class="icon-youtube-play"></i></a></div>

                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <?php echo $form->error($model, 'iconclass'); ?>
            </div>
        </div>

        <div class="control-group form-group buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('menu', 'menu_create') : Yii::t('menu', 'menu_update'), array('class' => 'btn btn-info')); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div><!-- form -->
<script>
    jQuery(document).ready(function() {
        jQuery('.icon-item a').on('click', function() {
            var cla = jQuery(this).find('i').attr('class');
            if (cla) {
                jQuery('#MenusAdmin_iconclass').val(cla);
                jQuery(this).closest('.btn-group').find('.btn-icon').html('<i class="' + cla + '"></i>');
            }
            //
            jQuery(this).closest('.btn-group').find('.dropdown-toggle').trigger('click');
            return false;
        });
    });
    //
    jQuery('input.linkto').change(function() {
        var val = jQuery(this).val();
        if (val ==<?php echo Menus::LINKTO_OUTER ?>) {
            jQuery('#MenusAdmin_menu_link').closest('.control-group').show();
            jQuery('#MenusAdmin_menu_values').closest('.control-group').hide();
        } else {
            jQuery('#MenusAdmin_menu_link').closest('.control-group').hide();
            jQuery('#MenusAdmin_menu_values').closest('.control-group').show();
        }
    });
</script>

