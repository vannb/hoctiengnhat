<link rel="stylesheet" href="<?php echo PATH ?>css/plugins/icheck/all.css">
<style>
    #box-content{
        overflow: auto;
    }
    #tab-content{
        padding:10px;
    }
    .bwizard-steps {
        position: relative;
        width: 100%;
        margin: 0; padding: 0;
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
        width: <?php echo 100 / count($this->arr_vocab_question); ?>%;
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
    @media (max-width: 768px) { 
        /* badges only on small screens */

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
            <div class="box-title">
                <h3><i class="icon-reorder"></i> Left tabs</h3>
            </div>
            <div class="box-content nopadding" id="box-content">
                <div class="tabs-container">
                    <ul class="tabs tabs-inline tabs-left" id="tabs-left">
                        <li class='active'>
                            <a href="#tab_vocabulary" data-toggle='tab'><i class="icon-lock"></i> Security</a>
                        </li>
                        <li>
                            <a href="#second" data-toggle='tab'><i class="icon-user"></i> Account</a>
                        </li>
                        <li>
                            <a href="#thirds" data-toggle='tab'><i class="icon-twitter"></i> Social</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content tab-content-inline" id="tab-content">
                    <div class="tab-pane active" id="tab_vocabulary">
                        <div id="wizard-wrap">
                            <div id="rootwizard">
                                <ul>
                                    <?php $i = 0; ?>
                                    <?php foreach ($this->arr_vocab_question as $key => $value) : ?>
                                        <?php $i++; ?>
                                        <li>
                                            <a href="#question<?php echo $i ?>"
                                               data-toggle="tab"><?php echo $i ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                                <div class="tab-content">
                                    <?php $i = 0; ?>
                                    <?php foreach ($this->arr_vocab_question as $key => $value) : ?>
                                        <?php $i++; ?>
                                        <div class="tab-pane question" id="question<?php echo $i ?>">
                                            <div class="check-line">
                                                <input type="radio" id="c8" class='icheck-me' name="same3" data-skin="square" data-color="blue" checked> <label class='inline' for="c8">Checked</label>
                                            </div>
                                            <div class="check-line">
                                                <input type="radio" id="c8" class='icheck-me' name="same3" data-skin="square" data-color="red" checked> <label class='inline' for="c8">Checked</label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>

                                </div>
                            </div>
                        </div>
                        <ul class="pager wizard">
                            <li class="previous tab_vocabulary"><a href="#">First</a></li>
                            <li class="previous"><a href="javascript:;">Previous</a></li>
                            <li class="next last"><a href="#">Last</a></li>
                            <li class="next"><a href="javascript:;">Next</a></li>
                        </ul>
                        <div id="bar" style="width: 100%" class="progress progress-striped">
                            <div class="bar"></div>
                        </div>
                    </div>
                    <div class="tab-pane" id="second">
                    </div>
                    <div class="tab-pane" id="thirds">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#rootwizard').bootstrapWizard({'tabClass': 'bwizard-steps'});
        percent = 100;
        var a = setInterval(function() {
            percent -= 1;
            if (a <= 0)
                clearInterval(a);
            $('.bar').css('width', percent + '%');
        }, 100);
        setTimeout(function() {
            var height = window.innerHeight;
            var offset = document.getElementById('tab-content').offsetTop;
            document.getElementById('tab-content').style.height = (height - offset - 20) + "px";
            var height = window.innerHeight;
            var offset = document.getElementById('wizard-wrap').offsetTop;
            document.getElementById('wizard-wrap').style.height = (height - offset - 100) + "px";
        });
    });
    window.onresize = function(e) {
        var height = window.innerHeight;
        var offset = document.getElementById('tab-content').offsetTop;
        document.getElementById('tab-content').style.height = (height - offset - 20) + "px";
        var height = window.innerHeight;
        var offset = document.getElementById('wizard-wrap').offsetTop;
        document.getElementById('wizard-wrap').style.height = (height - offset - 100) + "px";
    }

</script>
<script src="js/plugins/icheck/jquery.icheck.min.js"></script>