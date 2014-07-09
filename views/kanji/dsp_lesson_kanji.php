<style type='text/css'>
    p {
        margin-left: 15px;
        font-size: large
    }
</style>
<div class="row-fluid">
    <div class="span10">
        <div class="box">
            <div class="box-title">
                <h3>
                    <?php echo $this->lesson_name . ': ' . count($this->arr_kanji) . ' ' . translate('chữ Hán') ?>
                </h3>
            </div>
            <div class="box-content">
                <div class="accordion accordion-widget" id="accordion_kanji">
                    <?php $i = 0; ?>
                    <?php foreach ($this->arr_kanji as $key => $value) : ?>
                    <?php single_kanji($value)?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    toggle_star_kanji = function(kanji_id, that) {
        $.post('<?php echo $this->get_controller_url() ?>xhr_toggle_star', {'kanji_id': kanji_id})
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