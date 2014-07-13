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
<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <div class="box-title">
                <h3><?php echo translate("Từ vựng được quan tâm"); ?></h3>
                <div class="btn-group pull-right">
                    <a href="javascript:;" class="btn btn-large" onclick="grid_view()" rel="tooltip" title="<?php echo translate('Lưới') ?>"><i class="icon-th"></i></a>
                    <a href="javascript:;" class="btn btn-large" onclick="list_view()" rel="tooltip" title="<?php echo translate('Danh sách') ?>"><i class="icon-th-list"></i></a>
                </div>
            </div>
            <div id="all_terms" class="row-fluid list">
                <?php foreach ($this->arr_hot_vocab as $key => $value): ?>
                    <?php single_vocab($value) ?>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="box">
            <div class="box-title">
                <h3>
                    <?php echo translate("Ngữ pháp được quan tâm"); ?>
                </h3>
            </div>
            <div class="box-content">
                <div class="accordion accordion-widget" id="accordion_kanji">
                    <?php foreach ($this->arr_hot_kanji as $key => $value): ?>
                        <?php single_kanji($value) ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="box">
            <div class="box-title">
                <h3>
                    <?php echo translate("Ngữ pháp được quan tâm"); ?>
                </h3>
            </div>
            <div class="box-content">
                <div class="accordion accordion-widget" id="accordion_grammar">
                    <?php foreach ($this->arr_hot_grammar as $key => $value): ?>
                        <?php single_grammar($value) ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    toggle_star_vocab = function(vocabulary_id, that) {
        $.post('<?php echo $this->get_controller_url('vocabulary') ?>xhr_toggle_star', {'vocabulary_id': vocabulary_id})
                .done(function(data) {
                    $(that).removeClass('active');
                    if (data == '1') {
                        $(that).addClass('active');
                    } else if (data == '-1') {
                        window.location.href = '<?php echo $this->get_controller_url('user') . 'login' ?>';
                    }
                });
    }
    toggle_star_grammar = function(grammar_id, that) {
        $.post('<?php echo $this->get_controller_url('grammar') ?>xhr_toggle_star', {'grammar_id': grammar_id})
                .done(function(data) {
                    console.log(data);
                    $(that).removeClass('active');
                    if (data == '1') {
                        $(that).addClass('active');
                    } else if (data == '-1') {
                        window.location.href = '<?php echo $this->get_controller_url('user') . 'login' ?>';
                    }
                });
    }

    toggle_star_kanji = function(kanji_id, that) {
        $.post('<?php echo $this->get_controller_url('kanji') ?>xhr_toggle_star', {'kanji_id': kanji_id})
                .done(function(data) {
                    console.log(data);
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