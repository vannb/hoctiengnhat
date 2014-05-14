<body onload="window.print()">
    <h3>Order information</h3>
    <table class='noborder' style="width: 220px">
        <tr>
            <td>Order ID:</td>
            <td>#<?php echo $this->orderid ?></td>
        </tr>

        <tr>
            <td>Order date:</td>
            <td><?php echo date_format($this->orderdatetime, 'd-m-Y') ?></td>
        </tr>
        <tr>
            <td>Order time:</td>
            <td><?php echo date_format($this->orderdatetime, 'H:i:s') ?></td>
        </tr>
    </table>
    <h3>Your information</h3>
    <table class='noborder'>
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
    </table>
    <h3>Your cart</h3>
    <table style="border-collapse: collapse;min-width: 500;width: 50%" >
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
        <?php
        $total = 0;
        require 'libs/Product.php';
        foreach ($this->cart as $productID => $info) :
            echo '<tr>';
            ?>
            <td style="text-align: center;"><?php echo $info['productname'] ?></td>
            <td style="text-align: center;"><?php echo $info['quantity'] ?></td>
            <td style="text-align: center;"><?php
                $productPrice = $info['quantity'] * $info['price'];
                $total += $productPrice;
                echo number_format($productPrice)
                ?>
            </td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td></td>
        <td style='text-align: center; border-top: dotted 1px'><b>Total:</b></td>
        <td style='text-align: center; border-top: dotted 1px'>
            <b>
                <?php
                $_SESSION['total'] = $total;
                echo number_format($total)
                ?>
            </b>
        </td>
    </tr>
    <tr>
        <td></td>
        <td></td>
        <td onload="window.print()"></td>
    </tr>
</table>
</body>