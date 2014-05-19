<?php defined('SERVER_ROOT') or die('No direct script access allowed'); ?>
<!doctype html>
<html>
    <head>
        <title>
            <?php echo isset($this->template->title) ? $this->template->title : $this->template->default_title; ?>
        </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta names="apple-mobile-web-app-status-bar-style" content="black-translucent" />
        <link rel="stylesheet" href="<?php echo PATH ?>css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo PATH ?>css/bootstrap-responsive.min.css">
        <link rel="stylesheet" href="<?php echo PATH ?>css/plugins/jquery-ui/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="<?php echo PATH ?>css/plugins/gritter/jquery.gritter.css">
        <link rel="stylesheet" href="<?php echo PATH ?>css/plugins/jquery-ui/smoothness/jquery.ui.theme.css">
        <link rel="stylesheet" href="<?php echo PATH ?>css/style.css">
        <link rel="stylesheet" href="<?php echo PATH ?>css/themes.css">
        <script src="<?php echo PATH ?>js/jquery.min.js"></script>
        <link rel="shortcut icon" href="<?php echo PATH ?>img/favicon.ico" />
        <link rel="apple-touch-icon-precomposed" href="<?php echo PATH ?>img/apple-touch-icon-precomposed.png" />
        <link rel="shortcut icon" href="<?php echo PATH ?>img/favicon.ico" />
        <link rel="apple-touch-icon-precomposed" href="<?php echo PATH ?>img/apple-touch-icon-precomposed.png" />
    </head>
    <body  data-layout-sidebar="fixed" data-layout-topbar="fixed">
        <div id="modal-logout" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 id="myModalLabel"><?php echo translate("Đăng xuất"); ?></h3>
            </div>
            <div class="modal-body">
                <p><?php echo translate("Bạn thực sự muốn đăng xuất?") ?></p>
            </div>
            <div class="modal-footer">
                <a href="<?php echo URL ?>/user/logout" class="btn" aria-hidden="true"><?php echo translate('Xác nhận') ?></a>
                <a class="btn btn-primary" data-dismiss="modal"><?php echo translate('Hủy') ?></a>
            </div>
        </div>
        <div id="navigation">
            <div class="container-fluid">
                <a href="#" id="brand">
                    <?php echo isset($this->template->brand) ? $this->template->brand : DEFAULT_BRAND ?>
                </a>
                <a href="#" style="
                <?php
                echo (isset($this->template->show_toggle_sidebar) && !$this->template->show_toggle_sidebar) ? 'display: none' : 'display:block !important'
                ?>"
                   class="toggle-nav" rel="tooltip"  data-container="body"
                   data-placement="bottom" title="Ẩn/hiện thanh bên">
                    <i class="icon-reorder"></i>
                </a>
                <ul class='main-nav'>
                    <?php $this->template->navbar = isset($this->template->navbar) ? $this->template->navbar : $this->template->default_navbar ?>
                    <?php foreach ($this->template->navbar as $key => $value) : ?>
                        <li>
                            <?php if (is_array($value)): ?>
                                <a href="#" data-toggle="dropdown" class='dropdown-toggle'>
                                    <span><?php echo $key ?></span>
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php foreach ($value as $child_key => $child_value): ?>
                                        <?php if (is_array($child_value)): ?>
                                            <li class='dropdown-submenu'>
                                                <a href="#" data-toggle="dropdown" class='dropdown-toggle'>
                                                    <?php echo $child_key ?>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <?php foreach ($child_value as $grand_child_key => $grand_child_value): ?>
                                                        <li>
                                                            <a href="<?php echo is_array($grand_child_value) ? '#' : $grand_child_value ?>">
                                                                <?php echo $grand_child_key ?>
                                                            </a>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </li>
                                        <?php else: ?>
                                            <li>
                                                <a href="<?php echo $child_value ?>">
                                                    <?php echo $child_key ?>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <a href="<?php echo $value ?>">
                                    <span><?php echo $key ?></span>
                                </a>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="user">
                    <ul class="icon-nav">
                        <li class='dropdown'>
                            <a href="#" class='dropdown-toggle' data-toggle="dropdown">
                                <i class="icon-envelope"></i>
                                <span class="label label-lightred">4</span>
                            </a>
                            <ul class="dropdown-menu pull-right message-ul">
                                <li>
                                    <a href="#">
                                        <img src="img/demo/user-2.jpg" alt="">
                                        <div class="details">
                                            <div class="name">Đạt khắm lặm</div>
                                            <div class="message">
                                                Ut ad laboris est anim ut ...
                                            </div>
                                        </div>
                                        <div class="count">
                                            <i class="icon-comment"></i>
                                            <span>3</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="img/demo/user-3.jpg" alt="">
                                        <div class="details">
                                            <div class="name">Hưng bựa xít</div>
                                            <div class="message">
                                                Excepteur Duis magna dolor!
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="components-messages.html" class='more-messages'>
                                        Go to Message center <i class="icon-arrow-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown sett">
                            <a href="#" class='dropdown-toggle' data-toggle="dropdown">
                                <i class="icon-cog"></i>
                            </a>
                            <ul class="dropdown-menu pull-right theme-settings">
                                <li>
                                    <span>Layout-width</span>
                                    <div class="version-toggle">
                                        <a href="#" class='set-fixed'>Fixed</a>
                                        <a href="#" class="active set-fluid">Fluid</a>
                                    </div>
                                </li>
                                <li>
                                    <span>Topbar</span>
                                    <div class="topbar-toggle">
                                        <a href="#" class='set-topbar-fixed'>Fixed</a>
                                        <a href="#" class="active set-topbar-default">Default</a>
                                    </div>
                                </li>
                                <li>
                                    <span>Sidebar</span>
                                    <div class="sidebar-toggle">
                                        <a href="#" class='set-sidebar-fixed'>Fixed</a>
                                        <a href="#" class="active set-sidebar-default">Default</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class='dropdown colo'>
                            <a href="#" class='dropdown-toggle' data-toggle="dropdown"><i class="icon-tint"></i></a>
                            <ul class="dropdown-menu pull-right theme-colors">
                                <li class="subtitle">
                                    Predefined colors
                                </li>
                                <li>
                                    <span class='red'></span>
                                    <span class='orange'></span>
                                    <span class='green'></span>
                                    <span class="brown"></span>
                                    <span class="blue"></span>
                                    <span class='lime'></span>
                                    <span class="teal"></span>
                                    <span class="purple"></span>
                                    <span class="pink"></span>
                                    <span class="magenta"></span>
                                    <span class="grey"></span>
                                    <span class="darkblue"></span>
                                    <span class="lightred"></span>
                                    <span class="lightgrey"></span>
                                    <span class="satblue"></span>
                                    <span class="satgreen"></span>
                                </li>
                            </ul>
                        </li>
                        <li class='dropdown language-select'>
                            <a href="#" class='dropdown-toggle' data-toggle="dropdown"><img src="img/demo/flags/us.gif" alt=""><span>US</span></a>
                            <ul class="dropdown-menu pull-right">
                                <li>
                                    <a href="#"><img src="img/demo/flags/br.gif" alt=""><span>Brasil</span></a>
                                </li>
                                <li>
                                    <a href="#"><img src="img/demo/flags/de.gif" alt=""><span>Deutschland</span></a>
                                </li>
                                <li>
                                    <a href="#"><img src="img/demo/flags/es.gif" alt=""><span>España</span></a>
                                </li>
                                <li>
                                    <a href="#"><img src="img/demo/flags/fr.gif" alt=""><span>France</span></a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <?php if (about_user::is_login()): ?>
                        <div class="dropdown">
                            <a  style="line-height: 27px" href="#" class='dropdown-toggle' data-toggle="dropdown">
                                <?php echo about_user::current_user()->name; ?>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li>
                                    <a href="more-userprofile.html">Edit profile</a>
                                </li>
                                <li>
                                    <a href="#">Account settings</a>
                                </li>
                                <li>
                                    <a href="#modal-logout" role="button" data-toggle="modal">
                                        <?php echo translate("Đăng xuất"); ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <div class="dropdown">
                            <a style="line-height: 27px" href="<?php echo URL ?>user/login"><?php echo translate('Đăng nhập') ?></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="container-fluid <?php echo (isset($this->template->show_sidebar) && !$this->template->show_sidebar) ? 'nav-hidden' : '' ?>" id="content">
            <div id="left" class="">
                <form action="search-results.html" method="GET" class='search-form'>
                    <div class="search-pane">
                        <input type="text" name="search" placeholder="Search here...">
                        <button type="submit"><i class="icon-search"></i></button>
                    </div>
                </form>
                <?php if (!isset($this->template->sidebar)) $this->template->sidebar = array() ?>
                <?php foreach ($this->template->sidebar as $key => $value) : ?>
                    <div class="subnav subnav-hidden">
                        <div class="subnav-title">
                            <a <?php echo is_array($value) ? " class= 'toggle-subnav' " : " href='" . $value . "' " ?>  href="">
                                <?php echo is_array($value) ? "<i class='icon-angle-right'></i>" : "" ?>
                                <span><?php echo $key ?></span></a>
                        </div>
                        <?php if (is_array($value)): ?>
                            <ul class="subnav-menu">
                                <?php foreach ($value as $child_key => $child_value) : ?>
                                    <?php if (is_array($child_value)): ?>
                                        <li class='dropdown'>
                                            <a href="" data-toggle="dropdown"><?php echo $child_key ?></a>
                                            <ul class="dropdown-menu">
                                                <?php foreach ($child_value as $grand_child_key => $grand_child_value) : ?>
                                                    <?php if (is_array($grand_child_value)): ?>

                                                        <li class='dropdown-submenu'>
                                                            <a href="" data-toggle="dropdown" class='dropdown-toggle'><?php echo $grand_child_key ?></a>
                                                            <ul class="dropdown-menu">
                                                                <?php foreach ($grand_child_value as $great_grand_child_key => $great_grand_child_value): ?>
                                                                    <?php if (is_array($great_grand_child_value)): ?>
                                                                        <li class='dropdown-submenu'>
                                                                            <a href="" data-toggle="dropdown" class='dropdown-toggle'><?php echo $great_grand_child_key ?></a>
                                                                            <ul class="dropdown-menu">
                                                                                <?php foreach ($great_grand_child_key as $great_great_grand_child_key => $great_great_grand_child_value): ?>
                                                                                    <li>
                                                                                        <a href="<?php echo is_array($child_value) ? '' : $great_great_grand_child_value ?>">
                                                                                            <?php echo $great_great_grand_child_key ?>
                                                                                        </a>
                                                                                    </li>
                                                                                <?php endforeach; ?>
                                                                                ?>
                                                                            </ul>
                                                                        </li>
                                                                    <?php else: ?>
                                                                        <li>
                                                                            <a href="<?php echo $great_grand_child_value ?>"><?php echo $great_grand_child_key ?></a>
                                                                        </li>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        </li>
                                                    <?php else: ?>
                                                        <li>
                                                            <a href="<?php echo $grand_child_value ?>"><?php echo $grand_child_key ?></a>
                                                        </li>
                                                    <?php endif ?>
                                                <?php endforeach; ?>
                                            </ul>
                                        </li>
                                    <?php else: ?>
                                        <li>
                                            <a href="<?php echo $child_value ?>"><?php echo $child_key ?></a>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                <?php endforeach;
                ?>
            </div>
            <div id="main">
                <div class="container-fluid">
                    <div class="page-header">
                        <div class="pull-left">
                            <h1><?php echo isset($this->template->header) ? $this->template->header : translate('Trang chủ') ?></h1>
                        </div>
                    </div>
                    <div class="breadcrumbs">
                        <ul>

                            <li>
                                <a href="index.php"><?php echo translate("Trang chủ"); ?></a>
                            </li>
                            <?php
                            if (isset($this->template->breadcrumbs))
                                foreach ($this->template->breadcrumbs as $key => $value):
                                    ?>
                                    <li>
                                        <i class="icon-angle-right"></i>
                                        <a href="<?php if ($value != null and $value != '') echo $value ?>"><?php echo $key ?></a>
                                    </li>
                                <?php endforeach; ?>
                        </ul>
                        <div class="close-bread">
                            <a href="#"><i class="icon-remove"></i></a>
                        </div>
                    </div>