<div class="row-fluid">
    <div class="span12">
        <div class="box">
            <div class="box-title">
                <h3><?php echo translate('Xếp hạng theo lần làm bài đầu tiên').' - '.$this->lesson_name;?></h3>
            </div>
        </div>
        <div class="box-content">
            <table class="table">
                <thead>
                <th>#</th>
                <th><?php echo translate('Người dùng'); ?></th>
                <th><?php echo translate('Điểm'); ?></th>
                <th><?php echo translate('Thời gian làm bài'); ?></th>
                <th><?php echo translate('Nộp bài lúc') ?></th>
                </thead>
                <?php $rank_no = 1 ?>
                <?php foreach ($this->arr_all_rank as $rank): ?>
                <tr class="<?php if(about_user::is_login() && $rank['FK_USER'] == about_user::current_user()->user_id) echo 'info'?>">
                        <td>#<?php echo $rank_no++ ?></td>
                        <td><?php echo $rank['C_NAME'] ?></td>
                        <td><?php echo $rank['C_POINT'] ?></td>
                        <td><?php
                            $minute = floor($rank['C_TIME']/60);
                            $second = $rank['C_TIME'] % 60;
                            echo $minute.' '.  translate('phút').' '.$second.' '.  translate('giây');
                            ?></td>
                        <td><?php echo date_format(new DateTime($rank['C_SUBMIT_TIME']), 'd/m/Y H:i:s') ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>