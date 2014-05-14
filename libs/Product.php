<?php

class Product {

    public static function display($product, $viewmode = 0) {
        if ($viewmode == 0):
            $images = array();
            $dirname = 'views/images/products/' . $product['ProductID'];
            if (is_dir($dirname)) {
                $images = scandir($dirname);
                unset($images[0]);
                unset($images[1]);
            }
            if (empty($images))
                $images[2] = '../default.jpg';
            ?>
            <div class="product_preview">
                <a href = '<?php echo URL . 'home/displayproduct/' . $product['ProductID'] ?>'>
                    <div class="product_preview_image">
                        <img style="max-height: 200;max-width: 200;" src="<?php echo 'views/images/products/' . $product['ProductID'] . '/' . $images[2]; ?>"
                             alt="<?php echo $product['ProductName'] ?>">
                    </div>
                </a>
                <a href = '<?php echo URL . 'home/displayproduct/' . $product['ProductID'] ?>'>
                    <h3><?php echo $product['ProductName']; ?></h3>
                </a>
                Price: <font style="color: red"><?php echo number_format($product['Price']) ?> VND</font>
                <div class='product_popover'>

                    <div class="product_popover_image">
                        <img style="max-height: 200;max-width: 200;" src='<?php echo PATH ?>views/images/products/<?php echo $product['ProductID'] . '/' . $images[2] ?>' >
                        <ul>
                            <?php foreach ($images as $key => $value): ?>
                                <li>
                                    <?php echo PATH ?>views/images/products/<?php echo $product['ProductID'] . '/' . $images[$key] ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <a href = '<?php echo URL . 'home/displayproduct/' . $product['ProductID'] ?>'>
                        <h3><?php echo $product['ProductName']; ?></h3>
                    </a>
                    <ul id='product_info'>
                        <li>Manufacturer: <?php echo $product['ManufacturerName']; ?></li>
                        <li>Origin: <?php echo $product['Origin'] ?></li>
                        <li>Warranty: <?php echo $product['Warranty'] ?> Year(s)</li>
                    </ul>

                    Price: <font style="color: red"><?php echo number_format($product['Price']) ?> VND</font>
                    <form action ='<?php echo URL ?>home/addtocart' method ='POST'>
                        Quantity: <input type='text' name='quantity' value="1" style="width: 25">
                        <input name = 'productID' type ='hidden' value='<?php echo $product['ProductID'] ?>'>
                        <input name = 'price' type ='hidden' value='<?php echo $product['Price'] ?>'>
                        <input type ='submit' value = 'Add to cart'>
                    </form>
                </div>
            </div>
            <script src="<?php echo PATH ?>js/jquery-2.0.3.js"></script>
            <script>
                $(document).ready(function() {
                    $('.product_preview').each(function(i) {
                        var interval;
                        $(this).hover(function() {
                            current_popover_img_container =
                                    $(this).children('.product_popover')
                                    .addClass('current')
                                    .children('.product_popover_image');
                            var imgsrc = current_popover_img_container
                                    .children('ul')
                                    .children('li');
                            imgsrc.eq(0).addClass('show');
                            interval = setInterval(function() {
                                var current_img = imgsrc.filter('.show').removeClass('show');
                                var next_img = imgsrc.eq((imgsrc.index(current_img) + 1) % imgsrc.length)
                                next_img.addClass('show');
                                current_popover_img_container.children('img').attr('src', next_img.text());
                            }, 3000);
                        }, function() {
                            $(this).children('.product_popover')
                                    .removeClass('current');
                            clearInterval(interval);
                        });
                    });
                });
            </script>
        <?php elseif ($viewmode == 1): ?>

            <td><input class="single_product" type="checkbox" name = "selected[]" value=<?php echo $product['ProductID'] ?>></td>
            <td><?php echo $product['ProductName'] ?></td>
            <td><?php echo $product['Price'] ?></td>
            <td><?php echo $product['ManufacturerName'] ?></td>
            <td><?php echo $product['CategoryName'] ?></td>
            <td><?php echo $product['Origin'] ?></td>
            <td><?php echo $product['Warranty'] ?></td>
            <td><?php echo $product['Description'] ?></td>
            <?php
        elseif ($viewmode == 3):
            $images = array();
            $dirname = 'views/images/products/' . $product['ProductID'];
            if (is_dir($dirname)) {
                $images = scandir($dirname);
                unset($images[0]);
                unset($images[1]);
            }
            if (empty($images))
                $images[2] = '../default.jpg';
            ?>
            <div style="width: 300; text-align: center; float: left">
                <a href="<?php echo URL . 'home/displayproduct/' . $product['ProductID']; ?>">
                    <img style="max-height: 300;max-width: 300;" src="<?php echo 'views/images/products/' . $product['ProductID'] . '/' . $images[2]; ?>"
                         alt="<?php echo $product['ProductName'] ?>">
                </a>
            </div>
            <div style="width: 600; float: left">
                <table class='table'>
                    <tr>
                        <th>Product name</th>
                        <td><?php echo $product['ProductName']?></td>
                    </tr>
                    <tr>
                        <th>Manufacturer</th>
                        <td><?php echo $product['ManufacturerName']?></td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td><?php echo $product['CategoryName']?></td>
                    </tr>
                    <tr>
                        <th>Origin</th>
                        <td><?php echo $product['Origin']?></td>
                    </tr>
                    <tr>
                        <th>Warranty</th>
                        <td><?php echo $product['Warranty']?></td>
                    </tr>
                    <tr>
                        <th>Price</th>
                        <td><?php echo $product['Price']?></td>
                    </tr>
                </table>
            </div>
            <?php
        else:
            $images = array();
            $dirname = 'views/images/products/' . $product['ProductID'];
            if (is_dir($dirname)) {
                $images = scandir($dirname);
                unset($images[0]);
                unset($images[1]);
            }
            if (empty($images))
                $images[2] = '../default.jpg';
            ?>
            <td style="width: 230; text-align: center;">
                <a href="<?php echo URL . 'home/displayproduct/' . $product['ProductID']; ?>">
                    <img style="max-height: 200;max-width: 200;" src="<?php echo 'views/images/products/' . $product['ProductID'] . '/' . $images[2]; ?>"
                         alt="<?php echo $product['ProductName'] ?>">
                </a>
            </td>
            <td>
                <a href="<?php echo URL . 'home/displayproduct/' . $product['ProductID']; ?>"><?php echo $product['ProductName'] ?></a>
            </td>
        <?php
        endif;
    }

}
