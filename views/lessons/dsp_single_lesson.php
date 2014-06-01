<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<style>
    .tiles>li>a{
    }
</style>

<div class="container-fluid">
    <h1>Bài <?php echo $this->lesson_id?></h1>
    <div class="row-fluid">
        <div class="span12">
            <ul class="tiles">
                <li class="lime col-lg-12">
                    <?php 
                    echo '<a href= "'.URL.'vocabulary/dsp_lesson_vocabulary/'.$this->lesson_id.'"><span class="count"><i class="icon-book"></i>語彙</span><span class="name">Từ vựng</span></a>';
                    ?>
                </li>
                <li class="teal col-lg-12">
                    <?php 
                    echo '<a href= "'.URL.'vocabulary/dsp_lesson_vocabulary/'.$this->lesson_id.'"><span class="count"><i class="icon-list"></i>文法</span><span class="name">Ngữ pháp</span></a>';
                    ?>
                </li>
                <li class="pink col-lg-12">
                     <?php 
                    echo '<a href= "'.URL.'vocabulary/dsp_lesson_vocabulary/'.$this->lesson_id.'"><span><i class="icon-beaker"></i>テスト</span><span class="name">Kiểm tra</span></a></a>';
                    ?>
                </li>
            </ul>

        </div>
    </div>
</div>
