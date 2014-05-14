<html>
    <head>
        <title>Test</title>
        <link rel="stylesheet" href="<?php echo PATH ?>public/css/admin.css"/>
        <?php
        if (isset($this->js)) {
            foreach ($this->js as $js) {
                ?><script src="<?php echo PATH ?>views/<?php echo $js ?>"></script><?php
            }
        }
        ?>
                
    </head>
    <body>
        <div id="header">
            <a href = '<?php echo URL?>/Products'>Products</a>
            <a href = '<?php echo URL?>/Orders'>Orders</a>
            <a href = '<?php echo URL?>/Logout'>Logout</a>
        </div>
        <div id = "content">