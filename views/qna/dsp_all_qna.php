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
                    . '<th  class="center" style="width:80px">' . translate("Trả lời") . '</th>'
                    . '<th  class="center" style="width:120px">' . translate("Bình chọn") . '</th>'
                    . '<th>' . translate("Tiêu đề") . '</th>'
                    . '<thead>';
                    foreach ($this->arr_all_qna as $value):
                        $value['COUNT_ANSWER'] = isset($value['COUNT_ANSWER']) ? $value['COUNT_ANSWER'] : 0;
                        $value['COUNT_VOTE'] = isset($value['COUNT_VOTE']) ? $value['COUNT_VOTE'] : 0;
                        $value['SUM_VOTE'] = isset($value['SUM_VOTE']) ? $value['SUM_VOTE'] : 0;
                        $vote_up = ($value['COUNT_VOTE'] + $value['SUM_VOTE']) / 2;
                        $vote_down = ($value['COUNT_VOTE'] - $value['SUM_VOTE']) / 2;
                        echo '<tr>'
                        . '<td class="center">' . (isset($value['COUNT_ANSWER']) ? $value['COUNT_ANSWER'] : 0) . '</td>'
                        . '<td class="center">'
                        . $value['SUM_VOTE']
                        . ' (' . $vote_up . ' <i style="color:green" class="icon-arrow-up"></i>'
                        . $vote_down . ' <i style="color:red" class=" icon-arrow-down"></i>)'
                        . '</td>'
                        . '<td><a href="' . $this->get_controller_url() . 'dsp_single_qna/' . $value['PK_QNA'] . '">' . $value['C_TITLE'] . '<a/></td>'
                        . '</tr>';
                    endforeach;
                    ?>
                </table>
                <?php paginator($this->get_controller_url() . 'dsp_all_qna/', $this->count_all_qna) ?>
            </div>
        </div>
    </div>
</div>