<style type='text/css'>
    p {
        margin-left: 15px;
    }
</style>
<div class="row-fluid">
    <div class="span10">
        <div class="box">
            <div class="box-title">
                <h3>
                    <i class='icon-list'></i>
                    <?php echo $this->v_lesson_name . ': ' . count($this->arr_grammar) . ' ' . translate('ngữ pháp') ?>
                </h3>
            </div>
            <div class="box-content">
                <div class="accordion accordion-widget" id="accordion_grammar">
                    <?php foreach ($this->arr_grammar as $key => $value) : ?>
                    <?php single_grammar($value)?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
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
</script>