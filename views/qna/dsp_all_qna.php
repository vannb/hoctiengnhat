<style>
    .center{
        text-align: center !important
    }
</style>
<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <div class="box-title">
                <h3>
                    <?php echo translate('Hỏi đáp mới nhất') ?>
                </h3>
                <div class="pull-right"><a class="btn btn-success" href="<?php echo $this->get_controller_url() . 'dsp_single_qna/0' ?>"><?php echo translate("Câu hỏi mới"); ?></a></div>
            </div>
            <div class="box-content nopadding">
                <table class="table">
                    <?php
                    echo '<thead>'
                    . '<th  class="center hidden-768" style="width:80px">' . translate("Trả lời") . '</th>'
                    . '<th  class="center hidden-768" style="width:120px">' . translate("Đánh giá") . '</th>'
                    . '<th>' . translate("Tiêu đề") . '</th>'
                    . '<th>' . translate("Được hỏi lúc") . '</th>';
                    if (about_user::is_admin()):
                        echo '<th class="center">' . translate('Xóa') . '</th>';
                    endif;
                    echo '<thead>';
                    foreach ($this->arr_all_qna as $value):
                        single_qna_list($value);
                    endforeach;
                    ?>
                </table>
                <?php paginator($this->get_controller_url() . 'dsp_all_qna/', $this->count_all_qna) ?>
            </div>
        </div>
    </div>
</div>