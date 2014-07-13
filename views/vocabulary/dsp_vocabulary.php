<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<style>
    .single_term{overflow: hidden;cursor: pointer;position: relative}
    .single_term{margin: 15px}
    .word.japanese{font-size: large}
    .word.vietnamese{font-size: small}
    .term_wrap{
        -webkit-transition: width 0.3s ease-in-out;
        -moz-transition: width 0.3s ease-in-out;
        -o-transition: width 0.3s ease-in-out;
    }
    .grid .word.vietnamese{line-height: 25px;}
    .grid .word.japanese,.grid .term_action{line-height: 30px;}
    .grid .word, .grid .term_action{width: 100%}
    .grid .word{text-align: center}
    .grid .word.vietnamese{min-height: 80px}
    .grid .single_term{
        padding-top: 10px;
        -webkit-box-shadow: 0px 5px 15px 0px rgba(50, 50, 50, 0.5);
        -moz-box-shadow:    0px 5px 15px 0px rgba(50, 50, 50, 0.5);
        box-shadow:         0px 5px 15px 0px rgba(50, 50, 50, 0.5);
    }
    .list#all_terms{padding-top: 15px}
    .list .word, .list .term_action{line-height: 50px;}
    .list .term_action{background-color: #eee}
    .list .term_wrap{width: 100%;position: relative;}
    .list .single_term{border: #e2e2e2 1px solid;margin: -0.5px}
    .popover, .popover img{width: 100%}
</style>
<div class="clearfix"></div>
<div class="box">
    <div class="box-title">
        <h3><?php echo $this->v_lesson_name . ': ' . count($this->arr_vocab) . ' từ' ?></h3>
        <div class="btn-group pull-right">
            <a href="javascript:;" class="btn btn-large" onclick="grid_view()" rel="tooltip" title="<?php echo translate('Lưới') ?>"><i class="icon-th"></i></a>
            <a href="javascript:;" class="btn btn-large" onclick="list_view()" rel="tooltip" title="<?php echo translate('Danh sách') ?>"><i class="icon-th-list"></i></a>
        </div>
    </div>
    <div id="all_terms" class="row-fluid list box-content">
        <?php foreach ($this->arr_vocab as $key => $value) : ?>
            <?php single_vocab($value) ?>
            <!--            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 term_wrap">
                            <div class="single_term"
            <?php if (!empty($value['C_IMAGE_LOCATION']) || !empty($value['C_EXAMPLE'])): ?>
                                         data-html="true" rel="popover" data-trigger="hover click"
                                         data-placement="bottom" title="<?php
                echo $value['C_JAPANESE'];
                echo!empty($value['C_TYPE']) ? ' (' . $value['C_TYPE'] . ')' : ''
                ?>
                                         "
                                         data-content="
                <?php echo $value['C_VIETNAMESE'] ?>
                <?php echo!empty($value['C_IMAGE_LOCATION']) ? "<img src='" . $value['C_IMAGE_LOCATION'] . "'/>" : '' ?>
                <?php echo!empty($value['C_EXAMPLE']) ? '<h4>' . translate('Ví dụ') . ':</h4>' . $value['C_EXAMPLE'] : '' ?>
                                         "
            <?php endif; ?>>
                                <div class="word japanese col-xs-3"><?php echo $value['C_JAPANESE'] ?></div>
                                <div class="word vietnamese col-xs-7"><?php echo $value['C_VIETNAMESE'] ?></div>
                                <div class="term_action col-xs-2" style="height: 100%">
                                    <a href="javascript:;"
                                       onclick="toggle_star(<?php echo $value['PK_VOCABULARY'] ?>, this)"
                                       class="sel-star<?php echo ($value['PK_STARRED']) ? ' active ' : '' ?>"
                                       rel="tooltip"  data-container="body"
                                       data-placement="top" title="<?php echo translate("Đánh dấu") ?>">
                                        <i class="icon-star"></i>
                                    </a>
                                    <a href="<?php echo $this->get_controller_url() ?>dsp_starred_vocabulary"
                                       rel="tooltip"  data-container="body" data-placement="top" 
                                       title="<?php echo translate("Xem tất cả đánh dấu") ?>"
                                       >(<?php echo translate("Tất cả"); ?>)
                                    </a>
            
                                </div>
                                <div></div>
                            </div>
                        </div>-->
        <?php endforeach; ?>
    </div>
</div>
<div style="height: 200px"></div>
<script>
    toggle_star_vocab = function(vocabulary_id, that) {
        $.post('<?php echo $this->get_controller_url('vocab') ?>xhr_toggle_star', {'vocabulary_id': vocabulary_id})
                .done(function(data) {
                    $(that).removeClass('active');
                    if (data == '1') {
                        $(that).addClass('active');
                    } else if (data == '-1') {
                        window.location.href = '<?php echo $this->get_controller_url('user') . 'login' ?>';
                    }
                });
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