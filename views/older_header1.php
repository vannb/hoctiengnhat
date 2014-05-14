<html>
    <head>
        <title>Test</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?php echo PATH ?>css/bootstrap.css" rel="stylesheet"/>
        <link rel="stylesheet" href="<?php echo PATH ?>public/css/default.css"/>
        <?php
        if (isset($this->js)) {
            foreach ($this->js as $js) {
                ?><script src="<?php echo PATH ?>views/<?php echo $js ?>"></script><?php
            }
        }
        ?>
    </head>
    <body>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="<?php echo PATH ?>/js/jquery-2.0.3.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?php echo PATH ?>js/bootstrap.min.js"></script>
        <header class="navbar navbar-static-top bs-docs-nav" id="top" role="banner">
            <div class="container">
                <div class="navbar-header">
                    <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="../" class="navbar-brand">Bootstrap</a>
                </div>
                <nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="../getting-started">Getting started</a>
                        </li>
                        <li>
                            <a href="../css">CSS</a>
                        </li>
                        <li class="active">
                            <a href="../components">Components</a>
                        </li>
                        <li>
                            <a href="../javascript">JavaScript</a>
                        </li>
                        <li>
                            <a href="../customize">Customize</a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="http://expo.getbootstrap.com" onclick="_gaq.push(['_trackEvent', 'Navbar', 'Community links', 'Expo']);">Expo</a></li>
                        <li><a href="http://blog.getbootstrap.com" onclick="_gaq.push(['_trackEvent', 'Navbar', 'Community links', 'Blog']);">Blog</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        <div id= 'container'>
            <div id="header">
                <a href = '<?php echo URL ?>home'><div id = 'logo' >
                        logo
                    </div>
                </a>
                <div id='header-links'>
                    <div id='header-links-left'>
                        <ul>
                            <li><a href="<?php echo URL ?>home">Home</a></li>
                        </ul>

                    </div>
                    <div id='header-links-right'>
                        <ul>
                            <?php if (isset($_SESSION['role'])): ?>
                                <?php if (in_array($_SESSION['role'], array('Owner', 'Seller'))): ?>
                                    <li><a href = '<?php echo URL ?>Orders'>Orders</a></li>
                                <?php endif; ?>
                                <?php if ($_SESSION['role'] == 'Owner'): ?>
                                    <li><a href = '<?php echo URL ?>Products'>Products</a></li>
                                    <li><a href = '<?php echo URL ?>Manufacturers'>Manufacturers</a></li>
                                    <li><a href = '<?php echo URL ?>Categories'>Categories</a></li>
                                <?php endif; ?>
                                <li><a href = '<?php echo URL ?>Logout'>Logout</a></li>
                            <?php else: ?>
                                <li><a href="<?php echo URL ?>home/cart">Your Cart</a></li>
                                <li><a href="<?php echo URL ?>login">Login</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <div id='searchbox-container'>
                    <?php
                    if (!in_array(Session::get('role'), array('Seller', 'Owner')))
                        require 'views/searchbox.php';
                    ?>
                </div>
            </div>
            <div id = "content">