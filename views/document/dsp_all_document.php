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
                        <?php foreach ($this->arr_all_document as $document): ?>
                            <tr <?php if ($document['C_SHOWN'] != 1) echo 'class="success"' ?>>
                                <td><?php echo $document['C_NAME'] . '.' . $document['C_EXT'] ?></td>
                                <td class='hidden-768'><?php echo $document['C_UPLOADER_NAME'] ?></td>
                                <td class='hidden-1024'><?php echo date_format(new DateTime($document['C_UPLOAD_DATE']), 'd-m-Y') ?></td>
                                <td>
                                    <a href="<?php echo $this->get_controller_url() . 'download_document/' . $document['PK_DOCUMENT'] ?>">
                                        <i class=" icon-cloud-download"></i>
                                    </a>
                                </td>
                                <td class='hidden-768'>
                                    <?php
                                    for ($i = 1; $i <= 5; $i++):
                                        $active = FALSE;
                                        if ($document['AVG_RATING'] >= $i)
                                        {
                                            $active = true;
                                        }
                                        ?>
                                        <a style="color:<?php echo ($active) ? '#f8a31f' : '#aaa' ?>"
                                           rel="tooltip"  data-container="body" href="javascript:;"
                                           onclick="rate(<?php echo $document['PK_DOCUMENT'] . ',' . $i ?>, this)"
                                           data-placement="top" title="<?php echo $i . " " . translate("sao") ?>"
                                           >
                                            <i class="<?php echo ($active) ? 'icon-star' : 'icon-star-empty' ?>"></i>
                                        </a>
                                    <?php endfor; ?>
                                    (<?php echo number_format($document['AVG_RATING'], 1); ?> <i class="icon-star"></i>, 
                                    <?php echo ($document['COUNT_RATED_USER']) ? $document['COUNT_RATED_USER'] : 0 ?> 
                                    <i class="icon-user"></i>)
                                </td>
                                <?php if (about_user::is_admin()): ?>
                                    <td>
                                        <?php if ($document['C_SHOWN'] != 1): ?>
                                            <a href="<?php echo $this->get_controller_url() . 'set_document_shown/' . $document['PK_DOCUMENT'] ?>"><i class="icon-ok"></i></a>
                                        <?php endif; ?>
                                    </td>
                                    <td><a href="<?php echo $this->get_controller_url() . 'delete_document/' . $document['PK_DOCUMENT'] ?>"><i class="icon-remove"></i></a></td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
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
    rate = function(document_id, rating, that) {
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