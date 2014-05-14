<h3><?php echo isset($this->product['ProductID']) ? 'Edit' : 'Add' ?> Product</h3>

<form class="form-horizontal" enctype="multipart/form-data" method ='POST'
      action ='<?php echo URL ?>Products/EditSubmit'>
    <input type='hidden' name='productid'
           value='<?php echo isset($this->product['ProductID']) ? $this->product['ProductID'] : 0 ?>'>
    <div class="form-group">
        <label for="productname" class="control-label col-sm-2">Product Name</label>
        <div class="col-sm-5">
            <input value='<?php echo isset($this->product['ProductID']) ? $this->product['ProductName'] : '' ?>'
                   type="text" class="form-control" id="productname" name="productname">

        </div>
    </div>
    <div class="form-group">
        <label for="price" class="control-label col-sm-2">Price</label>
        <div class="col-sm-5">
            <input value='<?php echo isset($this->product['ProductID']) ? $this->product['Price'] : '' ?>'
                   type="text" class="form-control" id="price" name="price">
        </div>
    </div>

    <div class="form-group">
        <label for="manufacturer" class="control-label col-sm-2">Manufacturer</label>
        <div class="col-sm-3">
            <select class="form-control" name = 'manufacturerid' id="manufacturer">
                <?php
                if (isset($this->product['ProductID'])):
                    foreach ($this->manufacturers as $key => $manufacturer):
                        ?>
                        <option 
                        <?php
                        if ($this->product['ManufacturerID'] == $manufacturer['ManufacturerID'])
                            echo 'selected'
                            ?> value = '<?php echo $manufacturer['ManufacturerID'] ?>'>
                                <?php echo $manufacturer['ManufacturerName'] ?>
                        </option>
                        <?php
                    endforeach;
                else:
                    ?>
                    <?php
                    foreach ($this->manufacturers as $key => $manufacturer):
                        ?>
                        <option value = '<?php echo $manufacturer['ManufacturerID'] ?>'>
                            <?php echo $manufacturer['ManufacturerName'] ?>
                        </option>
                        <?php
                    endforeach;
                endif;
                ?>
            </select>
        </div>
        <div class="col-sm-2">
            <a class=" btn btn-block btn-primary" href ='<?php echo URL ?>Manufacturers'>Manage</a>
        </div>
    </div>
    <div class="form-group">
        <label for="category" class="control-label col-sm-2">Category</label>
        <div class="col-sm-3">
            <select class="form-control" name = 'categoryid' id="category">
                <?php
                if (isset($this->product['ProductID'])):
                    foreach ($this->categories as $key => $category):
                        ?>
                        <option 
                        <?php
                        if ($this->product['CategoryID'] == $category['CategoryID'])
                            echo 'selected'
                            ?> value = '<?php echo $category['CategoryID'] ?>'>
                                <?php echo $category['CategoryName'] ?>
                        </option>
                        <?php
                    endforeach;
                else:
                    foreach ($this->categories as $key => $category):
                        ?>
                        <option value = '<?php echo $category['CategoryID'] ?>'>
                            <?php echo $category['CategoryName'] ?>
                        </option>
                        <?php
                    endforeach;
                endif;
                ?>
            </select>
        </div>

        <div class="col-sm-2">
            <a class="btn btn-block btn-primary" href ='<?php echo URL ?>Categories'>Manage</a>
        </div>
    </div>
    <div class="form-group">
        <label for="origin" class="control-label col-sm-2">Origin</label>
        <div class="col-sm-5">
            <input value='<?php echo isset($this->product['ProductID']) ? $this->product['Origin'] : '' ?>'
                   class="form-control" type ='text' name = 'origin' id="origin">
        </div>
    </div>

    <div class="form-group">
        <label for="warranry" class="control-label col-sm-2">Warranty</label>
        <div class="col-sm-5">
            <input value='<?php echo isset($this->product['ProductID']) ? $this->product['Warranty'] : '' ?>'
                   class="form-control" type ='text' name = 'warranty' id="warranty">
        </div>
    </div>
    <div class="form-group">
        <label for="description" class="control-label col-sm-2">Description</label>
        <div class="col-sm-5">
            <textarea class="form-control" style="resize: vertical" name = 'description'><?php echo isset($this->product['ProductID']) ? $this->product['Description'] : '' ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label for="images" class="control-label col-sm-2">Images</label>
        <div class="col-sm-5">
            <input class="form-control" type="file" name="images[]" id="images"
                   multiple="multiple" accept="image/*"/>
        </div>
    </div>
    <?php
    if (isset($this->product['ProductID'])):
        $images = array();
        $dirname = 'views/images/products/' . $this->product['ProductID'];
        if (is_dir($dirname)):
            $images = scandir($dirname);
            unset($images[0]);
            unset($images[1]);
        endif;
        ?>
        <div class="form-group">
            <?php foreach ($images as $key => $value): ?>
                <div class='col-sm-5 col-sm-offset-2'>
                    <img style="max-width: 200;max-height: 400;margin-bottom: 5px;" src="<?php echo PATH ?>views/images/products/<?php echo $this->product['ProductID'] . '/' . $value ?>">
                    <a class="btn btn-primary" href="<?php echo URL . 'Products/DeletePicture&productid=' . $this->product['ProductID'] . '&image=' . $value ?>">Delete</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <div class="form-group">
        <div class="col-sm-2 col-sm-offset-2">
            <button class="btn btn-primary">Save</button>
        </div>
    </div>
</form>