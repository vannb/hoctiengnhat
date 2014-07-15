<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <?php if ($this->v_qna_id): ?>
                <div class="box-title">
                    <h3>
                        <?php echo translate('Câu hỏi mới nhất') ?>
                    </h3>
                </div>
                <div class="box-content nopadding">
                    <ul class="messages" style="line-height: ">
                        <?php
                        $value = $this->arr_qna;
                        single_qna($value);
                        ?>
                    </ul>
                </div>
            </div>
            <div class="box">
                <div class="box-title">
                    <h3>
                        <?php
                        echo translate('Các câu trả lời');
                        if (!empty($this->arr_answer))
                        {
                            echo '(' . count($this->arr_answer) . ')';
                        }
                        ?>
                    </h3>
                </div>
                <div class="box-content nopadding">
                    <?php
                    if (empty($this->arr_answer)):
                        echo translate("Chưa có câu trả lời nào");
                    else:
                        ?>
                        <ul class="messages" style="line-height: ">
                            <?php
                            foreach ($this->arr_answer as $key => $value)
                            {
                                single_qna($value);
                            }
                            ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
        <div class="box">
            <div class="box-title">
                <h3>
                    <?php echo translate('Gửi trả lời') ?>
                </h3>
            </div>
            <div class="box-content nopadding">
                <?php if (!about_user::is_login()): ?>
                    <?php echo translate("Xin vui lòng đăng nhập để sử dụng chức năng này") ?>
                <?php else: ?>
                    <form class="form-horizontal form-bordered" method="POST" 
                          action="<?php echo $this->get_controller_url() ?>add_qna">
                              <?php echo hidden('hdn_qna_id', ($this->v_qna_id)) ?>
                        <div class="control-group">
                            <label for="txt_title" class="control-label"><?php echo translate('Tiêu đề') ?></label>
                            <div class="controls">
                                <input type="text" name="txt_title" id="txt_title"
                                       class="col-md-9 col-xs-12" required="true"
                                       placeholder="Tiêu đề" maxlength="100">
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="txt_content" class="control-label">
                                <?php echo translate('Nội dung') ?>
                            </label>
                            <div class="controls">
                                <textarea name="txt_content" id="txt_content"
                                          class="col-md-9 col-xs-12" required="true"
                                          style="resize: vertical"
                                          placeholder="Nội dung"></textarea>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary"><?php echo translate('Gửi') ?></button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script>
    function vote_qna(qna_id, vote, that) {
        $.post('<?php echo $this->get_controller_url() ?>xhr_vote', {'qna_id': qna_id, 'vote': vote})
                .done(function(data) {
                    if (data == '-1') {
                        window.location.href = '<?php echo $this->get_controller_url('user') . 'login' ?>';
                        return;
                    }
                    var voted_up = $(that).parent().find('.vote_up');
                    var voted_down = $(that).parent().find('.vote_down');
                    var voted_sum = $(that).parent().find('.sum_vote');
                    if (data.up != '0' || data.down != '0') {
                        voted_up.html(parseInt(data.up));
                        voted_down.html(parseInt(data.down));
                        voted_sum.html(parseInt(data.up) - parseInt(data.down));
                    }
                }
                );
    }
</script>