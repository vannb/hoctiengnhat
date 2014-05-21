<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<style>
    .single_term{border: #e2e2e2 1px solid}
</style>
<div class='container-fluid'>
    <div id='terms' class='list'>
        <?php foreach ($this->arr_vocab as $key => $value) : ?>
            <div class="single_term">
                <div class="japanese span5"><?php echo $value['C_JAPANESE'] ?></div>
                <div class="vietnamese span5"><?php echo $value['C_VIETNAMESE'] ?></div>
                <div class="span2">star</div>
            </div>
        <?php endforeach; ?>
    </div>
</div>