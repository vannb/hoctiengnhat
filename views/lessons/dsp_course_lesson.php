<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<style> 
    .lesson_list ul { list-style-type: none; margin: 0; padding: 0; } 
    .lesson_list li { font: 200 20px/1.5 Helvetica, Verdana, sans-serif; border-bottom: 1px solid #ccc; } 
    .lesson_list li:last-child { border: none; } 
    .lesson_list li a { text-decoration: none; color: #000; display: block; 
                       width: 200px; -webkit-transition: font-size 0.3s ease, 
                           background-color 0.3s ease; -moz-transition: font-size 0.3s ease, 
                           background-color 0.3s ease; -o-transition: font-size 0.3s ease, 
                           background-color 0.3s ease; -ms-transition: font-size 0.3s ease, 
                           background-color 0.3s ease; transition: font-size 0.3s ease, 
                           background-color 0.3s ease; } 
    .lesson_list li a:hover { font-size: 30px; background: #f6f6f6; } 
</style> 

<div class="lesson_list"> 
    <h2><?php echo translate('Bài học') ?></h2> 
    <ul> 
        <?php
        foreach($this->lessonList as $key =>$value){
        echo '<li><a href = "'.URL.'lessons/dsp_single_lesson/'.$value['PK_LESSON'].'">'.$value['C_NAME'].'</a></li>';
        }
        ?>
    </ul> 
</div>



