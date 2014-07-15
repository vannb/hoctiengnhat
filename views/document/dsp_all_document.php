<div class="row-fluid">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-title">
                <h3>
                    <i class="icon-cloud-download"></i>
                    <?php echo translate('Tải về') ?>
                </h3>
            </div>
            <div class="box-content nopadding">
                <table class="table table-hover table-nomargin">
                    <thead>
                        <tr>
                            <th><?php echo translate('Tên tài liệu') ?></th>
                            <th class='hidden-768'><?php echo translate('Người đóng góp'); ?></th>
                            <th class='hidden-1024'><?php echo translate('Ngày tải lên'); ?></th>
                            <th><?php echo translate('Tải về') ?></th>
                            <th class='hidden-768'><?php echo translate('Đánh giá') ?></th>
                            <?php if (about_user::is_admin()): ?>
                                <th><?php echo translate('Duyệt') ?></th>
                                <th><?php echo translate('Xóa') ?></th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($this->arr_all_document as $document):
                            single_document($document);
                        endforeach;
                        ?>
                    </tbody>
                </table>
                <?php paginator($this->get_controller_url() . 'dsp_all_document/', $this->count_all_document) ?>
            </div>
            <div class="box">
                <div class="box-title">
                    <h3>
                        <i class="icon-cloud-upload"></i>
                        <?php echo translate('Tải lên') ?>
                    </h3>
                </div>
                <div class="box-content nopadding">
                    <form class="form-horizontal form-bordered" action="<?php echo $this->get_controller_url() ?>upload_document" method="POST" enctype="multipart/form-data">
                        <div class="control-group">
                            <label for="name" class="control-label"><?php echo translate('Tên tài liệu') ?></label>
                            <div class="controls">
                                <input type="text" name="name" id="name"
                                       class="col-md-6 col-xs-12" required="true"
                                       placeholder="Tên tài liệu" maxlength="100">
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="uploader" class="control-label">
                                <?php echo translate("Chọn tệp tải lên"); ?>
                                <small>
                                    (<?php echo translate("Sẽ xuất hiện sau khi được kiểm duyệt"); ?>)
                                </small>
                            </label>
                            <div class="controls">
                                <input type="file" name="uploader" id="uploader" class="input-block-level" required="true">
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary"><?php echo translate('Tải lên') ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    rate_document = function(document_id, rating, that) {
        $.post('<?php echo $this->get_controller_url() ?>xhr_rate_document', {'document_id': document_id, 'rating': rating})
                .done(function(data) {
                    console.log(data);
                    if (data == '-1') {
                        window.location.href = '<?php echo $this->get_controller_url('user') . 'login' ?>';
                    } else if (data == '1') {
                        location.reload();
                    }
                });
    }
</script>