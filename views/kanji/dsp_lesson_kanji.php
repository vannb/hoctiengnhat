<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<style>
    .single_term{overflow: hidden;cursor: pointer}
    .single_term{margin: 15px}
    .word{font-size: x-large}
    .term_wrap{
        -webkit-transition: width 0.3s ease-in-out;
        -moz-transition: width 0.3s ease-in-out;
        -o-transition: width 0.3s ease-in-out;
    }
    .grid .word, .grid .term_action{line-height: 40px;}
    .grid .word, .grid .term_action{width: 100%}
    .grid .word{text-align: center}
    .grid .single_term{
        padding-top: 15px;
        -webkit-box-shadow: 3px 3px 10px 0px rgba(50, 50, 50, 0.5);
        -moz-box-shadow:    3px 3px 10px 0px rgba(50, 50, 50, 0.5);
        box-shadow:         3px 3px 10px 0px rgba(50, 50, 50, 0.5);
    }
    .list#all_terms{padding-top: 15px}
    .list .word {text-align: center}
    .list .word, .list .term_action{line-height: 50px;}
    .list .term_action{background-color: #eee}
    .list .term_wrap{width: 100%;position: relative}
    .list .single_term{border: #e2e2e2 1px solid;margin: -0.5px}
    .popover, .popover img{width: 100%}
    .block {display: inline-block};



    @-webkit-keyframes spinnerRotate
    {
        from{-webkit-transform:rotate(0deg);}
        to{-webkit-transform:rotate(360deg);}
    }
    @-moz-keyframes spinnerRotate
    {
        from{-moz-transform:rotate(0deg);}
        to{-moz-transform:rotate(360deg);}
    }
    @-ms-keyframes spinnerRotate
    {
        from{-ms-transform:rotate(0deg);}
        to{-ms-transform:rotate(360deg);}
    }
</style>
<div class="clearfix"></div>
<div class="box">
    <div class="box-title">
        <h3><?php echo translate('Tổng cộng: ') . count($this->arr_kanji) . ' từ' ?></h3>
        <div class="btn-group pull-right">
            <!-- <a href="javascript:;" class="btn btn-large" onclick="grid_view()" rel="tooltip" title="<?php echo translate('Lưới') ?>"><i class="icon-th"></i></a> -->
            <a href="javascript:;" class="btn btn-large" onclick="list_view()" rel="tooltip" title="<?php echo translate('Danh sách') ?>"><i class="icon-th-list"></i></a>
        </div>
    </div>
    <div id="all_terms" class="row-fluid list">
        <?php foreach ($this->arr_kanji as $key => $value) : ?>
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 term_wrap">
                <div class="single_term" data-html="true" data-delay='{"show":"500"}'
                     rel="popover" data-trigger="hover click"
                     data-placement="bottom" title="<?php
                     echo $value['C_CHARACTER'];
                     echo isset($value['C_SINO_VIETNAMESE']) ? ' (' . $value['C_SINO_VIETNAMESE'] . ')' : ''
                     ?>"
                     data-content="<?php echo isset($value['C_WRITE_IMAGE_LOCATION']) ? "<img src='" . $value['C_WRITE_IMAGE_LOCATION'] . "'/>" : '' ?>
                     <?php echo isset($value['C_COMPOUND_WORD']) ? '<h4>' . translate('Từ ghép') . ':</h4>' . $value['C_COMPOUND_WORD'] : '' ?>
                     ">
                    <div class="word col-md-4 col-sm-4 col-xs-12" style="height:100px; vertical-align: middle;"><?php echo $value['C_CHARACTER'] . ' (' . $value[C_SINO_VIETNAMESE] . ')'  ?>
                    </div>
                    <div class="word col-md-4 col-sm-4 col-xs-12">
                        <?php echo $value['C_ON'] ?> <br/>
                        <?php echo $value['C_KUN'] ?>
                    </div>
                    <div class="word col-md-4 col-sm-4 col-xs-12">
                        <?php echo $value['C_COMPOUND_WORD']; ?>
                    </div>
                    <!--
                    <div class="term_action col-xs-3">
                        <a href="javascript:;"
                           class="sel-star"
                           rel="tooltip"  data-container="body"
                           data-placement="top" title="Đánh dấu">
                            <i class="icon-star spin"></i>
                        </a>
                    </div>
                    -->
                    <div></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<div style="height: 200px"></div>
<script>

    function grid_view() {
        $('#all_terms').removeClass('list').addClass('grid');
    }

    function list_view() {
        $('#all_terms').removeClass('grid').addClass('list');
    }
    $(document).ready(function() {
    });
</script>
