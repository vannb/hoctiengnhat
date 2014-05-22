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
    .grid .single_term .word, .grid .single_term .term_action{line-height: 30px;}
    .grid .word, .grid .term_action{width: 100%}
    .grid .word{text-align: center}
    .grid .single_term{
        padding-top: 15px;
        -webkit-box-shadow: 3px 3px 10px 0px rgba(50, 50, 50, 0.5);
        -moz-box-shadow:    3px 3px 10px 0px rgba(50, 50, 50, 0.5);
        box-shadow:         3px 3px 10px 0px rgba(50, 50, 50, 0.5);
    }
    .list .single_term .word, .list .single_term .term_action{line-height: 50px;}
    .list .term_action{background-color: #eee}
    .list .term_wrap{width: 100%;position: relative}
    .list .single_term{border: #e2e2e2 1px solid;margin: -0.5px}
    .popover, .popover img{width: 100%}
</style>
<div class="clearfix"></div>
<div class="row-fluid list box" id="all_terms">
    <div class="box-title">
        <h3><?php echo translate('Tổng cộng: ') . count($this->arr_vocab) . ' từ' ?></h3>
        <div class="btn-group pull-right">
            <a href="javascript:;" class="btn btn-large" onclick="grid_view()" rel="tooltip" title="Grid view"><i class="icon-th"></i></a>
            <a href="javascript:;" class="btn btn-large" onclick="list_view()" rel="tooltip" title="List view"><i class="icon-th-list"></i></a>
        </div>
    </div>
    <?php foreach ($this->arr_vocab as $key => $value) : ?>
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 term_wrap">
            <div class="single_term" onclick="expand(this)" data-html="true" data-delay='{"show":"500"}' rel="popover" data-trigger="hover click"
                 title="<?php
                 echo $value['C_JAPANESE'];
                 echo isset($value['C_TYPE']) ? ' (' . $value['C_TYPE'] . ')' : ''
                 ?>"
                 data-placement="bottom" data-content="
                 <?php echo isset($value['C_IMAGE_LOCATION']) ? "<img src='" . $value['C_IMAGE_LOCATION'] . "'/>" : '' ?>
                 <?php echo isset($value['C_EXAMPLE'])?'<h4>'.translate('Ví dụ').':</h4>'.$value['C_EXAMPLE']:''?>
                 ">
                <div class="word col-xs-5"><?php echo $value['C_JAPANESE'] ?></div>
                <div class="word col-xs-5"><?php echo $value['C_VIETNAMESE'] ?></div>
                <div class="term_action col-xs-2">
                    <a href="javascript:;">
                        <i class="icon-headphones"></i>
                    </a>
                </div>
                <div></div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<div style="height: 200px"></div>
<script>

    function expand(that) {
        $(that).addClass('expand');
    }
    function grid_view() {
        $('#all_terms').removeClass('list').addClass('grid');
    }

    function list_view() {
        $('#all_terms').removeClass('grid').addClass('list');
    }
    $(document).ready(function() {
        grid_view();
    });
</script>