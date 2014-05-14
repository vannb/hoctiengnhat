<?php
require 'libs/Product.php';
?>

<?php Product::display($this->product, 3); ?>
<p style = 'margin-left: 210'>
    <?php echo $this->product['Description'] ?>
</p>