<style type='text/css'>
    p {
        margin-left: 15px;
    }
</style>
<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <div class="box-title">
                <h3>
                    <i class="icon-reorder"></i>
                    Ngữ pháp
                </h3>
            </div>
            <div class="box-content">
                <div class="accordion" id="accordion2">
                    <?php $i = 0; ?>
                    <?php foreach ($this->arr_grammar as $key => $value) : ?>

                        <div class="accordion-group">
                            <div class="accordion-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#<?php echo $value['PK_GRAMMAR']; ?>">
                                    <?php $i++;
                                    echo $i . ' . ' . $value['C_NAME'];
                                    ?>
                                </a>
                            </div>
                            <div id="<?php echo $value['PK_GRAMMAR']; ?>" class="accordion-body collapse">
                                <div class="accordion-inner">
                                    <?php echo empty($value['C_GRAMMAR']) ? '' : '<h5>' . translate('Cấu trúc') . ':</h5>' . '' . '<p>' . $value['C_GRAMMAR'] . ' </p>'; ?>
                                    <?php echo empty($value['C_USAGE']) ? '' : '<h5>' . translate('Cách dùng') . ':</h5>' . '' . '<p>' . $value['C_USAGE'] . '</p>'; ?>
                                    <?php echo empty($value['C_EXAMPLE']) ? '' : '<h5>' . translate('Ví dụ') . ':</h5>' . '<p>' . $value['C_EXAMPLE'] . '</p>'; ?>

                                </div>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
