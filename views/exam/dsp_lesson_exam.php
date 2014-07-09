<link rel="stylesheet" href="<?php echo PATH ?>css/plugins/icheck/all.css">
<style>
    #box-content{
        overflow: auto;
    }

    #outter-tab-content{
        padding:10px;
    }

    .question-tab{
        border: #cccccc 1px solid;
        overflow: auto;
    }
    .bwizard-steps {
        position: relative;
        width: 100%;
        margin: 0 0 10px 0; padding: 0;
    }
    .bwizard-steps .active:after {
        border-left-color: #007ACC 
    }
    .bwizard-steps .active a {
        background: #007ACC ;
        color: #fff;
        cursor: default 
    }

    .bwizard-steps li {
        padding-right: 6px;
        width: <?php echo 100 / count($this->arr_multi_choices_question); ?>%;
        display: inline-block;
        position: relative;
        margin-right: -4px;
        line-height: 18px;
        list-style: none;
    }
    .bwizard-steps li:first-child:before {
        border: none;
    }

    .bwizard-steps li:first-child a{
        padding-left: 0;
    }
    .bwizard-steps li:last-child {
        margin-right: 0;
    }
    .bwizard-steps li:last-child:after {
        border: none 
    }
    .bwizard-steps li:before {
        position: absolute;
        left: 0; top: 0;
        height: 0; width: 0;
        border-bottom: 20px inset transparent;
        border-left: 20px solid #fff;
        border-top: 20px inset transparent;
        content: "" 
    }
    .bwizard-steps li:after {
        position: absolute;
        right: -14px; top: 0;
        height: 0; width: 0;
        border-bottom: 20px inset transparent;
        border-left: 20px solid #efefef;
        border-top: 20px inset transparent;
        content: "";
        z-index: 2;
    }
    .bwizard-steps a {
        text-decoration: none ;
        padding-left: 20px;
        display: table-cell;
        line-height: 40px;
        text-align: center;
        display: block;
        background: #efefef;
        color: #333 
    }
    @media (max-width: 512px) {
        .breadcrumbs{
            display: none
        }
        #main .page-header .pull-left h1{
            font-size: medium
        }
    }
    @media (max-width: 768px) {
        .bwizard-steps li a{
            line-height:25px;
            padding-left: 0;
        }
        .bwizard-steps li:after,
        .bwizard-steps li:before {
            border: none 
        }
        .bwizard-steps li,
        .bwizard-steps li.active,
        .bwizard-steps li:first-child,
        .bwizard-steps li:last-child {
            margin-right: -4px;
            padding-right: 4px;
            background-color: transparent 
        }
    }
</style>
<div class="row-fluid">
    <div class="span12">
        <div class="box box-bordered box-color lightgrey">
            <form id ='form' method="POST" action="<?php echo $this->get_controller_url() . 'dsp_exam_result/' . $this->lesson_id ?>">
                <?php echo hidden('exam_code', uniqid()) ?>
                <?php echo hidden('remain', '') ?>
                <div class="box-title">
                    <h3>
                        <?php if ($this->dsp_mode == 'exam'): ?>
                            <?php echo translate('Thời gian') . ': ' . 15 . ' ' . translate('phút'); ?>
                            (<?php echo translate('Còn') ?>: <span id='clock'>15:00</span>)
                        <?php else: ?>
                            <?php echo translate('Điểm') . ': ' . round($this->point, 2) . '/10'; ?>
                            (<a href="<?php echo $this->get_controller_url() . 'dsp_rank/' . $this->lesson_id ?>">#<?php echo translate('Xếp hạng').': '. $this->rank?></a>)
                        <?php endif; ?>
                    </h3>
                    <?php if ($this->dsp_mode == 'exam'): ?>
                        <div class="pull-right" style="padding-right: 10px">
                            <div class="input-group">
                                <button class="btn btn-danger">
                                    <?php echo translate('Nộp bài') ?>
                                </button>
                            </div><!-- /input-group -->
                        </div>
                    <?php endif; ?>
                </div>
                <div class="box-content nopadding" id="box-content">
                    <div class="tabs-container">
                        <ul class="tabs tabs-inline tabs-left" id="tabs-left">
                            <li class='active'>
                                <a href="#tab_multi_choices" data-toggle='tab'><i class="icon-check"></i> <?php echo translate('Trắc nghiệm'); ?></a>
                            </li>
                            <?php if (isset($this->arr_reading['question']) && !empty($this->arr_reading['question'])): ?>
                                <li>
                                    <a href="#tab_reading" data-toggle='tab'><i class="glyphicon-book_open"></i> <?php echo translate('Đọc hiểu'); ?></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="tab-content tab-content-inline" id="outter-tab-content">
                        <div class="tab-pane active" id="tab_multi_choices">
                            <div id="wizard-wrap">
                                <div id="rootwizard">
                                    <ul>
                                        <?php $i = 0; ?>
                                        <?php foreach ($this->arr_multi_choices_question as $key => $value): ?>
                                            <?php $i++; ?>
                                            <li>
                                                <a href="#question<?php echo $i ?>"
                                                   data-toggle="tab"><?php echo $i ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <div class="tab-content question-tab" id="multi_choices-question-tab">
                                        <?php $ques = 0; ?>
                                        <?php foreach ($this->arr_multi_choices_question as $question) : ?>
                                            <?php $ques++; ?>
                                            <div class="tab-pane question" id="question<?php echo $ques ?>">
                                                <blockquote>
                                                    <p>
                                                        <?php echo nl2br(trim($question['C_CONTENT'])); ?>
                                                    </p>
                                                </blockquote>
                                                <input type="radio"
                                                       name="answer_multi_choices_<?php echo $question['PK_QUESTION'] ?>"
                                                       value="0" required hidden="true" checked="true"
                                                       >
                                                       <?php for ($ans = 1; $ans < 5; $ans++) : ?>
                                                           <?php if (isset($question['C_ANSWER_' . $ans]) && $question['C_ANSWER_' . $ans] !== ''): ?>
                                                        <div class="check-line">
                                                            <input type="radio" id="<?php echo 'v' . $ques . '_' . $ans ?>"
                                                                   name="answer_multi_choices_<?php echo $question['PK_QUESTION'] ?>"
                                                                   value="<?php echo $ans ?>"
                                                                   <?php
                                                                   if (isset($question['ANSWERED']))
                                                                   {
                                                                       echo ($question['ANSWERED'] == $ans) ? ' checked ' : ' disabled ';
                                                                   }
                                                                   ?>
                                                                   class='icheck-me' data-skin="square"
                                                                   data-color="<?php
                                                                   if (!isset($question['ANSWERED']))
                                                                   {
                                                                       echo 'blue';
                                                                   } else if ($question['C_CORRECT'] == $ans)
                                                                   {
                                                                       echo 'green';
                                                                   } else
                                                                   {
                                                                       echo 'red';
                                                                   }
                                                                   ?>
                                                                   ">
                                                            <label class='inline'
                                                                   for="<?php echo 'v' . $ques . '_' . $ans ?>">
                                                                       <?php echo nl2br(trim($question['C_ANSWER_' . $ans])) ?>
                                                                <span style="color: green">
                                                                    <?php if (isset($question['ANSWERED']) && $question['C_CORRECT'] == $ans): ?>
                                                                        <i class="icon-caret-left"></i> CORRECT ANSWER
                                                                    <?php endif; ?>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php endfor; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <ul class="pager wizard">
                                        <li class="previous"><a href="javascript:;"><?php echo translate('Câu trước') ?></a></li>
                                        <li class="next"><a href="javascript:;"><?php echo translate('Câu tiếp theo') ?></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php if (isset($this->arr_reading['question']) && !empty($this->arr_reading['question'])): ?>
                            <div class="tab-pane" id="tab_reading">
                                <div class="question-tab" id="reading-question-tab">
                                    <div>
                                        <?php echo hidden('reading_id', $this->arr_reading['PK_READING']); ?>
                                        <blockquote>
                                            <?php echo nl2br(trim($this->arr_reading['C_CONTENT'])); ?>
                                        </blockquote>
                                        <hr>
                                        <?php foreach ($this->arr_reading['question'] as $question): ?>
                                            <?php $ques++; ?>
                                            <blockquote>
                                                <p>
                                                    <?php echo nl2br(trim($question['C_CONTENT'])); ?>
                                                </p>
                                            </blockquote>
                                            <input type="radio"
                                                   name="answer_reading_<?php echo $question['PK_QUESTION'] ?>"
                                                   value="0" required hidden="true" checked="true"
                                                   >
                                                   <?php for ($ans = 1; $ans < 5; $ans++) : ?>
                                                       <?php if (isset($question['C_ANSWER_' . $ans])): ?>
                                                    <div class="check-line">
                                                        <input type="radio" id="<?php echo 'r' . $ques . '_' . $ans ?>"
                                                               name="answer_reading_<?php echo $question['PK_QUESTION'] ?>"
                                                               value="<?php echo $ans ?>"
                                                               <?php
                                                               if (isset($question['ANSWERED']))
                                                               {
                                                                   echo ($question['ANSWERED'] == $ans) ? ' checked ' : ' disabled ';
                                                               }
                                                               ?>
                                                               class='icheck-me' data-skin="square" data-color="<?php
                                                               if (!isset($question['ANSWERED']))
                                                               {
                                                                   echo 'blue';
                                                               } else if ($question['C_CORRECT'] == $ans)
                                                               {
                                                                   echo 'green';
                                                               } else
                                                               {
                                                                   echo 'red';
                                                               }
                                                               ?>">
                                                        <label class='inline' for="<?php echo 'r' . $ques . '_' . $ans ?>">
                                                            <?php echo nl2br(trim($question['C_ANSWER_' . $ans])) ?>
                                                            <span style="color: green">
                                                                <?php if (isset($question['ANSWERED']) && $question['C_CORRECT'] == $ans): ?>
                                                                    <i class="icon-caret-left"></i> CORRECT ANSWER
                                                                <?php endif; ?>
                                                            </span>
                                                        </label>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div id="bar" style="width: 100%;margin-top: 10px" class="progress progress-striped">
                            <div class="bar"></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    resize_tab = function() {
        var height = window.innerHeight;
        var offset = document.getElementById('outter-tab-content').offsetTop;
        document.getElementById('outter-tab-content').style.height = (height - offset - 22) + "px";
        var offset = document.getElementById('multi_choices-question-tab').offsetTop;
        document.getElementById('multi_choices-question-tab').style.height = (height - offset - 100) + "px";
<?php if (isset($this->arr_reading['question']) && !empty($this->arr_reading['question'])): ?>
            var offset = document.getElementById('reading-question-tab').offsetTop;
            document.getElementById('reading-question-tab').style.height = (height - offset - 58) + "px";
<?php endif; ?>
    }
    count_down = function() {
        var minute = 15;
        var second = minute * 60;
        var remain = second;
        var a = setInterval(function() {
            remain--;
            var percent = remain / second * 100;
            if (remain <= 0) {
                clearInterval(a);
                document.getElementById("form").submit();
            } else if (remain == 600) {
                $('#bar').addClass('progress-warning');
            } else if (remain == 300) {
                $('#bar').removeClass('progress-warning');
                $('#bar').addClass('progress-danger');
            }
            $('.bar').css('width', percent + '%');
            var minute_remain = Math.floor(remain / 60);
            var second_remain = remain % 60;
            $('#remain').val(remain);
            $('#clock').html(minute_remain + ':' + second_remain);
        }, 1000);
    }
    $(document).ready(function() {
        $('#rootwizard').bootstrapWizard({'tabClass': 'bwizard-steps'});
<?php if ($this->dsp_mode == 'exam'): ?>
            count_down();
<?php endif; ?>
        setTimeout(function() {
            resize_tab();
        });
    });
    window.onresize = function(e) {
        resize_tab();
    }

    $('#tabs-left a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
        resize_tab();
    })
</script>
<script src="js/plugins/icheck/jquery.icheck.min.js"></script>