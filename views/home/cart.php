<h3>Your cart</h3>
<?php
if (!count($this->cart)) :
    echo 'No item';
    return;
endif;
?>
<table class='table'>
    <tr>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Action</th>
    </tr>
    <?php
    $total = 0;
    require 'libs/Product.php';
    foreach ($this->cart as $productID => $info) :
        $quantity = $info['quantity'];
        Product::display($this->product[$productID], 2);
        ?>
        <td><?php echo $quantity ?></td>
        <td><?php
            $productPrice = $quantity * $this->product[$productID]['Price'];
            $total += $productPrice;
            echo number_format($productPrice)
            ?>
        </td>
        <td min-width = 150 width = 150>
            <div class='row'>
                <div class="col-sm-7">
                    <form class="form-inline" action ='<?php echo URL ?>home/addtocart' method ='POST'>
                        <div class="form-group">
                            <input  name = 'productID' type ='hidden' value='<?php echo $productID ?>'>
                            <input name = 'price' type ='hidden' value='<?php echo $info['price'] ?>'>
                            <label class="small" for="quantity">Quantity</label>
                            <input maxlength="2" class='form-control input-sm' type='text' id='quantity' name='quantity' value="1" style="width: 35">
                            <input class="btn btn-success btn-xs" type ='submit' value = 'Add'>
                        </div>
                    </form>
                </div>
                <div class="col-sm-5">
                    <form class="form-inline" action ='<?php echo URL ?>home/removefromcart' method ='POST'>
                        <div class="form-group">
                            <div style="height: 6;clear: both"></div>
                            <input name = 'productID' type ='hidden' value='<?php echo $productID ?>'>
                            <input class="btn btn-xs btn-warning" type ='submit' value = 'Remove'>
                        </div>
                    </form>
                </div>
            </div>
        </td>
    </tr>
    <?php
endforeach;
?>
<tr>
    <td></td>
    <td>&nbsp;</td>
    <td><b>Total:</b></td>
    <td><b><?php echo number_format($total) ?></b></td>
    <td>
        <a class="btn btn-primary col-xs-6" href="<?php echo URL ?>">Continue Shoping</a>
        <a class="btn btn-success col-xs-6" href='<?php echo URL ?>home/order'>Order</a>
    </td>
</tr>
</table>