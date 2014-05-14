<h1>Total: <?php echo $this->numberOfOrder ?> order(s)</h1>

<?php if ($this->numberOfOrder): ?>
    <form  method ='GET'>
        <?php $limit = array(1, 3, 5, 7, 10) ?>

        <?php foreach ($_GET as $key => $value): if ($key != 'limit' && $key != 'page'): ?>
                <input type = 'hidden' name="<?php echo $key ?>" value="<?php echo $value ?>">
                <?php
            endif;
        endforeach;
        ?>
        <label for="resultsperpage">Display</label>
        <select id="resultsperpage" name ='limit' onchange='if (this.value != 0) {
                        this.form.submit();
                    }'>
                    <?php foreach ($limit as $key => $value) : ?>
                <option <?php if ($_GET['limit'] == $value) echo 'selected' ?> value ='<?php echo $value ?>'><?php echo $value ?></option>
            <?php endforeach; ?>
        </select>
        <label for="resultsperpage">results per page</label>
    </form>
    <form method='POST' action="<?php echo URL ?>Orders/Mark">
        <label for="markas">Mark selected as:</label>
        <select id="markas" name='action'>
            <option value = 'purchased'>Purchased</option>
            <option value = 'delivered'>Delivered</option>
            <option value = 'notpurchased'>Not purchased</option>
            <option value = 'notdelivered'>Not delivered</option>
        </select>
        <button class="btn btn-xs btn-success">Go</button>
        <table class='table table-condensed table-hover'>
            <tr>
                <th><input type="checkbox" id="all"></th>
                <th>Customer</th>
                <th>Address</th>
                <th>Phone</th>
                <th style="min-width: 76">DateTime</th>
                <th>Purchased</th>
                <th>Delivered</th>
                <th>Action</th>
            </tr>
            <?php
            foreach ($this->orders as $key => $order) :
                ?>
                <tr class='<?php
                if ($order['Purchased']) {
                    if ($order['Delivered']) {
                        echo 'active';
                    } else {
                        echo 'success';
                    }
                } else {
                    if ($order['Delivered']) {
                        echo 'danger';
                    } else {
                        echo 'warning';
                    }
                }
                ?>'>
                    <td><input class="single_order" type="checkbox" name = "selected[]" value=<?php echo $order['OrderID'] ?>></td>
                    <td><?php echo $order['CustomerName'] ?></td>
                    <td><?php echo $order['CustomerAddress'] ?></td>
                    <td><?php echo $order['CustomerPhone'] ?></td>
                    <td><?php
                        $datetime = new DateTime($order['OrderDateTime'], new DateTimeZone('Asia/Bangkok'));

                        echo date_format($datetime, 'd-m-Y') . '</br>' . date_format($datetime, 'H:i:s');
                        ?>
                    </td>
                    <td><b><?php echo $order['Purchased'] ? '<font style="color: green">Yes</font>' : '<font style="color: red">No</font>' ?></b></td>
                    <td><b><?php echo $order['Delivered'] ? '<font style="color: green">Yes</font>' : '<font style="color: red">No</font>' ?></b></td>
                    <td>
                        <?php if (!$order['Purchased']): ?>
                            <a class='btn btn-xs btn-success btn-block' href = "<?php echo URL ?>Orders/Purchased/<?php echo $order['OrderID'] ?>">Purchased</a>
                        <?php else: ?>
                            <a class='btn btn-xs btn-warning btn-block' href = "<?php echo URL ?>Orders/NotPurchased/<?php echo $order['OrderID'] ?>">Not purchased</a>
                        <?php endif; ?>
                        <?php if (!$order['Delivered']): ?>
                            <a class='btn btn-xs btn-success btn-block' href = "<?php echo URL ?>Orders/Delivered/<?php echo $order['OrderID'] ?>">Delivered</a>
                        <?php else: ?>
                            <a class='btn btn-xs btn-warning btn-block' href = "<?php echo URL ?>Orders/NotDelivered/<?php echo $order['OrderID'] ?>">Not delivered</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php
            endforeach;
            ?>
        </table>
    </form> 
    <table class='noborder'>
        <?php if ($_GET['page'] > 1): ?>
            <td>
                <form>
                    <?php foreach ($_GET as $key => $value): if ($key != 'page'): ?>
                            <input type = 'hidden' name="<?php echo $key ?>" value="<?php echo $value ?>">
                            <?php
                        endif;
                    endforeach;
                    ?>
                    <input type = 'hidden' name="page" value="<?php echo $_GET['page'] - 1; ?>">
                    <button class="btn btn-default">&larr; Previous</button>
                </form>
            </td>
        <?php endif; ?>
        <td>Page: <?php echo $_GET['page'] . '/' . $this->pages ?></td>
        <?php if ($_GET['page'] < $this->pages): ?>
            <td>
                <form>
                    <?php foreach ($_GET as $key => $value): if ($key != 'page'): ?>
                            <input type = 'hidden' name="<?php echo $key ?>" value="<?php echo $value ?>">
                            <?php
                        endif;
                    endforeach;
                    ?>
                    <input type = 'hidden' name="page" value="<?php echo $_GET['page'] + 1; ?>">
                    <button class="btn btn-default">Next &rarr;</button>
                </form>
            </td>
        <?php endif; ?>
    </table>
<?php endif; ?>
<script>
    $(document).ready(function() {
        $('#all').click(function() {
            var c = this.checked;
            $('.single_order').prop('checked', c);
        });
    });
</script>