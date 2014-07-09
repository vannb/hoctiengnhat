<div id="modal-exam" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="ExamModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="ExamModalLabel"><?php echo translate("Kiểm tra"); ?></h3>
    </div>
    <div class="modal-body">
        <p><?php echo translate("Bạn có thể làm bài nhiều lần, nhưng sẽ chỉ được tính điểm kiểm tra của lần làm bài đầu tiên") ?></p>
    </div>
    <div class="modal-footer">
        <a href="<?php echo $this->get_controller_url('exam').'dsp_lesson_exam/' . $this->lesson_id ?>" class="btn btn-danger" aria-hidden="true"><?php echo translate('Bắt đầu!') ?></a>
        <a class="btn btn-primary" data-dismiss="modal"><?php echo translate('Hủy') ?></a>
    </div>
</div>
<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<style>
    .tiles>li>a{
    }
</style>

<div class="row-fluid">
    <div class="box">
        <div class="box-title">
            <h3>
                <?php echo $this->lesson_name ?>
            </h3>
        </div>
        <div class="box-content">
            <ul class="tiles row-fluid">
                <?php if ($this->has_vocab): ?>
                    <li class="lime col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <?php
                        echo '<a href= "' . URL . 'vocabulary/dsp_lesson_vocabulary/' . $this->lesson_id . '">'
                        . '<span class="count"><i class="icon-book"></i>語彙</span>'
                        . '<span class="name">Từ vựng</span></a>';
                        ?>
                    </li>
                <?php endif; ?>
                <?php if ($this->has_grammar): ?>
                    <li class="teal col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <?php
                        echo '<a href= "' . URL . 'grammar/dsp_lesson_grammar/' . $this->lesson_id . '">'
                        . '<span class="count"><i class="icon-list"></i>文法</span>'
                        . '<span class="name">Ngữ pháp</span></a>';
                        ?>
                    </li>
                <?php endif; ?>
                <?php if ($this->has_exam): ?>
                    <li class="blue col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <?php
                        echo '<a href= "#modal-exam" role="button" data-toggle="modal">'
                        . '<span><i class="icon-beaker"></i>テスト</span>'
                        . '<span class="name">Kiểm tra</span></a>';
                        ?>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>