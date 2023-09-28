<?php $arrayKey = ['0 - 9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'] ?>
<div class="brand-explore-page">
    <div class="container">
        <div class="title-trip-explore">
            <h2>BRAND EXPLORER</h2>
            <p>Khám phá các thương hiệu đồ du lịch – dã ngoại nổi tiếng thế giới</p>
        </div>
        <div class="table-abc">
            <ul>
                <?php foreach ($arrayKey as $key => $value) {
                    ?>
                    <li>
                        <a role="button" data-toggle="collapse" data-parent="#accordion"
                           href="#collapse<?php echo '100' . $key ?>" aria-expanded="true"
                           aria-controls="collapse<?php echo '100' . $key ?>"
                           class="collapsed"><?php echo $value ?>
                        </a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
        <div class="brand-explore-ctn">
            <div class="faq-accordion">
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <?php foreach ($arrayKey as $key => $value) {
                        if (isset($data[$value])) {
                            ?>
                            <div class="panel panel-default actives">
                                <div class="panel-heading" role="tab" id="heading<?php echo '100' . $key ?>">
                                    <h4 class="panel-title">

                                        <a role="button" data-toggle="collapse" data-parent="#accordion"
                                           href="#collapse<?php echo '100' . $key ?>" aria-expanded="true"
                                           aria-controls="collapse<?php echo '100' . $key ?>"
                                           class="collapsed">
                                            <img
                                                    src="<?php echo Yii::app()->theme->baseUrl ?>/images/arrow-down.png"><?php echo $value ?>
                                            <p>Lên đầu trang</p>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse<?php echo '100' . $key ?>" class="panel-collapse collapse "
                                     role="tabpanel"
                                     aria-labelledby="heading<?php echo '100' . $key ?>" <?php echo 'aria-expanded="true" style="height:0px"' ?>>
                                    <div class="panel-body">
                                        <div class="wishlist-table table-responsive">
                                            <div class="item-collapase accordion-body">
                                                <ul>

                                                    <?php
                                                    if (isset($data[$value]) && count($data[$value])) {
                                                        foreach ($data[$value] as $brand) {
//                                                            echo ' <li><a href="' . Yii::app()->createUrl('economy/product/attributeSearch') . '?fi_mnf=' . $brand['id'] . '">' . $brand['name'] . '<span>(' . (isset($number[$brand['id']]) ? $number[$brand['id']] : '0') . ')</span></a></li>';

                                                            echo ' <li><a href="' . Yii::app()->createUrl('economy/product/manufacturerDetail', array('id' => $brand['id'], 'alias' => $brand['alias'])) . '">' . $brand['name'] . '<span>(' . (isset($number[$brand['id']]) ? $number[$brand['id']] : '0') . ')</span></a></li>';;

                                                        }
                                                    }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(".accordion-body").on("shown", function () {
        var selected = $(this);
        var collapseh = $(".collapse .in").height();
        $.scrollTo(selected, 500, {
            offset: -(collapseh)
        });
    });
</script>