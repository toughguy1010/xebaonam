<div class="box-bookly-staff innerContent1">
    <script type="text/javascript">
        function mainTab2(obj) {
            for (i = 0; i <= 14; i++) {
                $(".shootContent" + i).hide();
                $("#shoot" + i).removeClass("active");
            }
            $(".shootContent" + obj).show();
            $("#shoot" + obj).addClass("active");
        }
        ;
    </script>
    <div class="nav-tab-staff">
        <ul class="__MB_NEWS_TAB">
            <li class="active" onclick="mainTab2(1)" id="shoot1">
                <a href="javascript:;"> <i class=" icon-info-sign"></i> Details</a>
            </li>
            <li onclick="mainTab2(2)" id="shoot2" class=""><a href="javascript:;"><i class="icon-check"></i>Services</a></li>
            <li onclick="mainTab2(3)" id="shoot3" class=""><a href="javascript:;"><i class="icon-calendar"></i>Schedule</a></li>
            <li onclick="mainTab2(4)" id="shoot4" class=""><a href="javascript:;"><i class=" icon-briefcase"></i>Days off</a></li>
        </ul>
    </div>
    <div class="cont-info-staff shootContent1" style="display: block;">
        <div class="wishlist-table table-responsive">
            <?php
            $this->renderPartial('_form', array('model' => $model,'providerInfo' => $providerInfo,));
            ?>
        </div>
    </div>
    <div class="cont-info-staff shootContent2 noDisplay" style="display: none;">
        <div class="services-staff">
            <div class="wishlist-table table-responsive">
                <?php
                $this->renderPartial('partial/_services', array('model' => $model));
                ?>
            </div>
        </div>
    </div>
    <div class="cont-info-staff shootContent3 noDisplay" style="display: none;">
        <div class="celandar-staff">
            <div class="wishlist-table table-responsive">
                <?php
                $this->renderPartial('partial/_schedule', array('model' => $model,'businessHours' => $businessHours,));
                ?>
            </div>
        </div>
    </div>
    <div class="cont-info-staff shootContent4 noDisplay" id="holidays" style="display: none;">
        <?php
        $this->renderPartial('partial/_holidays', array('model' => $model));
        ?>
    </div>
</div>