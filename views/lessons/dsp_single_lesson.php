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

<style>

#navcontainer
{
width: max-content;
border-right: 1px solid #000;
padding: 0 0 1em 0;
margin-bottom: 1em;
font-family: Verdana, Lucida, Geneva, Helvetica, Arial, sans-serif;
background-color: #90bade;
color: #333;
}

#navcontainer ul
{
list-style: none;
margin: 0;
padding: 0;
border: none;
}

#navcontainer li
{
border-bottom: 10px solid #90bade;
margin: 0;
}

#navcontainer li a
{
display: block;
padding: 15px 15px 15px 0.5em;
border-left: 10px solid #1958b7;
border-right: 10px solid #508fc4;
background-color: #2175bc;
color: #fff;
text-decoration: none;
width: 100%;
}

html>body #navcontainer li a { width: auto; }

#navcontainer li a:hover
{
border-left: 10px solid #1c64d1;
border-right: 10px solid #5ba3e0;
background-color: #2586d7;
color: #fff;
}
</style>
<div></div>
<div id="navcontainer">
<h2><?php echo translate('Chọn phần muốn học:') ?></h2> 
<ul id="navlist">
<li id="active"><a href="#" id="current">Item one</a></li>
<li><a href = "'.URL.'vocabulary/dsp_lesson_vocabulary/'.$this->lesson_id.'">Từ vựng</a></li>
<li><a href = "'.URL.'vocabulary/dsp_lesson_vocabulary/'.$this->lesson_id.'">Ngữ pháp</a></li>
<li><a href = "'.URL.'vocabulary/dsp_lesson_vocabulary/'.$this->lesson_id.'">Kiểm tra</a></li>
<li><a href="#">Item five</a></li>
</ul>
</div>




