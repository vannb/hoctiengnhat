<h3><?php echo isset($this->category['CategoryID'])?'Edit':'Add'?> category</h3>
<form class="form-horizontal"  action = '<?php echo URL ?>Categories/EditSubmit' method = 'POST'>
    <input name = categoryid type = 'hidden'
           value = '<?php echo isset($this->category['CategoryID'])?$this->category['CategoryID']:0 ?>'>
    <div class="form-group">
        <label for="categoryname" class="col-sm-2 control-label">Category Name: </label>
        <div class="col-sm-5">
            <input value = '<?php echo isset($this->category['CategoryID'])?$this->category['CategoryName']:''?>' placeholder="Category Name" type = 'text' id="categoryname" class="form-control" name = 'categoryname'>
        </div>
    </div>
    
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-5">
            <button type="submit" class="btn btn-default">Submit</button>
        </div>
    </div>
</form>
