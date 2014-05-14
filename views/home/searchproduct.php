<h1>
    Found <?php echo $this->numberOfProduct ?> product(s)
    <?php if (isset($this->manufacturer)) echo 'by <b>' . $this->manufacturer['ManufacturerName'] . '</b>' ?>
    <?php if (isset($this->category)) echo 'in <b>' . $this->category['CategoryName'] . '</b>' ?>
</h1>
<?php if (count($this->result)): ?>
    <form  method ='GET'>
        <?php $limit = array(4, 8, 12, 16, 20) ?>

        <?php
        foreach ($_GET as $key => $value):
            if ($key != 'limit' && $key != 'page'):
                ?>
                <input type = 'hidden' name="<?php echo $key ?>" value="<?php echo $value ?>">
                <?php
            endif;
        endforeach;
        ?>
        Display: 
        <select name ='limit' onchange='if (this.value != 0) {
                        this.form.submit();
                    }'>
                    <?php foreach ($limit as $key => $value) : ?>
                <option <?php if ($_GET['limit'] == $value) echo 'selected' ?> value ='<?php echo $value ?>'>
                    <?php echo $value ?>
                </option>
            <?php endforeach; ?>
        </select>
        results per page
    </form>
    <table class='noborder'>
        <?php if ($_GET['page'] > 1): ?>
            <td>
                <form>
                    <?php
                    foreach ($_GET as $key => $value):
                        if ($key != 'page'):
                            ?>
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
    <?php
    require 'libs/Product.php';
    foreach ($this->result as $key => $product) :
        Product::display($product);
    endforeach;
endif; ?>