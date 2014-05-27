<style type='text/css'>
    p {
        margin-left: 15px;
    }
</style>
<div class="row-fluid">
    <div class="span10">
        <div class="box">
            <div class="box-title">
                <h3>
                    <?php echo $this->v_lesson_name . ': ' . count($this->arr_vocab) . ' từ' ?>
                </h3>
            </div>
            <div class="box-content">
                <div class="accordion accordion-widget" id="accordion2">
                    <?php $i = 0; ?>
                    <?php foreach ($this->arr_grammar as $key => $value) : ?>

                        <div class="accordion-group">
                            <div class="accordion-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#<?php echo $value['PK_GRAMMAR']; ?>">
                                    <?php
                                    $i++;
                                    echo $i . ' . ' . $value['C_NAME'];
                                    ?>
                                </a>
                            </div>
                            <div id="<?php echo $value['PK_GRAMMAR']; ?>" class="accordion-body collapse">
                                <div class="accordion-inner">
                                    <fieldset>
                                        <?php echo empty($value['C_GRAMMAR']) ? '' : '<legend>' . translate('Cấu trúc') . '</legend>' . '' . '<p>' . $value['C_GRAMMAR'] . ' </p>'; ?>
                                    </fieldset>
                                    <fieldset>
                                        <?php echo empty($value['C_USAGE']) ? '' : '<legend>' . translate('Cách dùng') . '</legend>' . '' . '<p>' . $value['C_USAGE'] . '</p>'; ?>
                                    </fieldset>
                                    <fieldset>
                                        <?php echo empty($value['C_EXAMPLE']) ? '' : '<legend>' . translate('Ví dụ') . '</legend>' . '<p>' . $value['C_EXAMPLE'] . '</p>'; ?>
                                    </fieldset>

                                </div>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
