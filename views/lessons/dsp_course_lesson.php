<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<style> 
    .lesson_list ul { list-style-type: none; margin: 0; padding: 0; } 
    .lesson_list li { border-bottom: 1px solid #ccc; font-size: medium;line-height: 40px} 
    .lesson_list li:last-child { border: none; } 
    .lesson_list li a { text-decoration: none; color: #000; display: block; 
                        width: 200px; -webkit-transition: font-size 0.3s ease, 
                            background-color 0.3s ease; -moz-transition: font-size 0.3s ease, 
                            background-color 0.3s ease; -o-transition: font-size 0.3s ease, 
                            background-color 0.3s ease; -ms-transition: font-size 0.3s ease, 
                            background-color 0.3s ease; transition: font-size 0.3s ease, 
                            background-color 0.3s ease; } 
    .lesson_list li a:hover { font-size: 40px;  } 
</style> 

<div class="lesson_list row-fluid">
    <div class="box">
        <div class="box-title">
            <h3><?php echo $this->course_name . ': '. count($this->arr_lesson).' '.translate('bài') ?></h3> 
        </div>
        <div class="box-content">
            <ul> 
                <?php
                foreach ($this->arr_lesson as $key => $value) {
                    echo '<li><a href = "' . URL . 'lessons/dsp_single_lesson/' . $value['PK_LESSON'] . '">' . $value['C_NAME'] . '</a></li>';
                }
                ?>
            </ul> 
        </div>
    </div>
</div>






