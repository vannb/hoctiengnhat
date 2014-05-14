<h3>Review information</h3>
<form>
    <table class = 'noborder'>
        <tr>
            <td>Your full name</td>
            <td><?php echo $this->order['name'] ?></td>
        </tr>
        <tr>
            <td>Delivery address</td>
            <td><?php echo $this->order['address'] ?></td>
        </tr>
        <tr>
            <td>Phone number</td>
            <td><?php echo $this->order['phone'] ?></td>
        </tr>
        <tr>
            <td>Note:</td>
            <td><?php echo $this->order['note'] ?></td>
        </tr>
    </table></form>
<table>
    <h3>Your cart</h3>
    <?php
    if (!count($this->cart)) :
        echo 'No item';
        return;
    endif;
    ?>
    <table class="table">
        <tr>
            <th>&nbsp;</th>
            <th>&nbsp;</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
        <?php
        $total = 0;
        require 'libs/Product.php';
        foreach ($this->cart as $productID => $info) :
            echo '<tr>';
            Product::display($this->product[$productID], 2);
            ?>
            <td><?php echo $info['quantity'] ?></td>
            <td><?php
                $productPrice = $info['quantity'] * $info['price'];
                $total += $productPrice;
                echo number_format($productPrice)
                ?>
            </td>
            </tr>
            <?php
        endforeach;
        ?>
        <tr>
            <td></td>
            <td></td>
            <td><b>Total:</b></td>
            <td>
                <b>
                    <?php
                    $_SESSION['total'] = $total;
                    echo number_format($total)
                    ?>
                </b>
            </td>
        </tr>
    </table>
    <div class="row">
        <a class="btn btn-primary col-xs-2 col-sm-offset-8" href = 'javascript:history.go(-1);'>Back</a>
        <a class="btn btn-success col-xs-2" href = '<?php echo URL; ?>home/processorder'>Confirm</a>
    </div>