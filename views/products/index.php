<h1>
    Found: <?php echo $this->numberOfProduct ?> product(s)
    <?php if (isset($this->manufacturer)) echo 'by <b>' . $this->manufacturer['ManufacturerName'] . '</b>' ?>
    <?php if (isset($this->category)) echo 'in <b>' . $this->category['CategoryName'] . '</b>' ?>
</h1>
<hr/>
<form class="form-horizontal">
    <input name="url" type="hidden" value="Products">
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="row">
                <label class="control-label col-lg-3 col-md-2" for="productname">Search</label>
                <div class="col-lg-9  col-md-10">
                    <input type="text" name="productname" id="productname" 
                           class="form-control input-sm" placeholder="Product Name"
                           value="<?php echo $_GET['productname'] ?>">
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="row">
                <label class='control-label col-lg-2 col-md-2'for="pricefrom">Price</label>
                <div class="col-lg-5 col-md-5">
                    <input type='number' id="pricefrom" min="0" step="100000"
                           class="form-control input-sm" placeholder="From"
                           name="pricefrom" value="<?php echo $_GET['pricefrom'] ?>">
                </div>
                <div class="col-lg-5 col-md-5">
                    <input type="number"  id="priceto" min="0" step="100000"
                           class="form-control input-sm" placeholder="To"
                           name="priceto"  value="<?php echo $_GET['priceto'] ?>">
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-5 col-lg-offset-0 col-md-offset-1">
            <select class='form-control input-sm'
                    name ='categoryid' id="category">
                <option value='0'>Any category</option>
                <?php
                $database = new Database();
                $categories = $database->search("Categories", 0, 0);

                foreach ($categories as $key => $category) {
                    ?>
                    <option <?php if (isset($_GET['categoryid']) && ($_GET['categoryid'] == $category["CategoryID"])) echo 'selected' ?>  value="<?php echo $category['CategoryID'] ?>"><?php echo $category['CategoryName'] ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
        <div class="col-lg-2 col-md-5 col-lg-offset-0 col-md-offset-1">
            <select class='form-control input-sm'
                    name ='manufacturerid' id='manufacturer'>

                <option value='0'>Any manufacturer</option>
                <?php
                $database = new Database();
                $manufacturers = $database->search("manufacturers", '');

                foreach ($manufacturers as $key => $manufacturer) {
                    ?>
                    <option <?php if (isset($_GET['manufacturerid']) && ($_GET['manufacturerid'] == $manufacturer["ManufacturerID"])) echo 'selected' ?> value="<?php echo $manufacturer['ManufacturerID'] ?>">
                        <?php echo $manufacturer["ManufacturerName"]; ?>
                    </option>
                    <?php
                }
                ?>
            </select>
        </div>
        <div class="col-lg-1 col-md-11 col-lg-offset-0 col-md-offset-1">
            <button id='go' class='btn btn-sm btn-block btn-default'>Go</button>
        </div>
    </div>
</form>
<hr/>
<form method ='GET'>
    <?php
    foreach ($_GET as $key => $value):
        if ($key != 'limit' && $key != 'page'):
            ?>
            <input type = 'hidden' name="<?php echo $key ?>" value="<?php echo $value ?>">
            <?php
        endif;
    endforeach;
    $limit = array(5, 10, 20, 50);
    ?>
    <label for="resultsperpage">Display</label>
    <select id="resultsperpage" name ='limit' onchange=' if (this.value != 0) {
                    this.form.submit();
                }'>
                <?php foreach ($limit as $key => $value) : ?>
            <option <?php if ($_GET['limit'] == $value) echo 'selected' ?> value ='<?php echo $value ?>'><?php echo $value ?></option>
        <?php endforeach; ?>
    </select>
    <label for="resultsperpage">results per page</label>
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
<form method ='POST' action = '<?php echo URL ?>Products/DeleteMany'>
    <a class='btn btn-primary' href = '<?php echo URL ?>Products/Add'>Add a product</a>
    <button class='btn btn-danger'>Delete selected</button>
    <?php if ($this->numberOfProduct): ?>
        <table class='table table-condensed table-hover'>
            <tr>
                <th><input type="checkbox" id="all"></th>
                <th>Product name</th>
                <th>Price</th>
                <th>Manufacturer</th>
                <th>Category</th>
                <th>Origin</th>
                <th>Warranty</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
            <?php
            require 'libs/Product.php';
            foreach ($this->products as $key => $product) :
                ?>
                <tr>
                    <?php Product::display($product, 1) ?>
                    <td>
                        <a class='btn btn-xs btn-success' href = "<?php echo URL ?>Products/Edit/<?php echo $product['ProductID'] ?>">Edit</a>
                        <a class='btn btn-xs btn-danger'  href = "<?php echo URL ?>Products/Delete/<?php echo $product['ProductID'] ?>">Delete</a>
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
    <?php
endif;
?>
<script>
    $(document).ready(function() {
        $('#all').click(function() {
            var c = this.checked;
            $('.single_product').prop('checked', c);
        });
    });
</script>