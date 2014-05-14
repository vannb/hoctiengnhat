<h3><?php echo isset($this->manufacturer['ManufacturerID'])?'Edit':'Add'?> manufacturer</h3>
<form class="form-horizontal"  action = '<?php echo URL ?>Manufacturers/EditSubmit' method = 'POST'>
    <input name = 'manufacturerid' type = 'hidden'
           value = '<?php echo isset($this->manufacturer['ManufacturerID'])?$this->manufacturer['ManufacturerID']:0 ?>'>
    <div class="form-group">
        <label for="manufacturername" class="col-sm-2 control-label">Manufacturer Name: </label>
        <div class="col-sm-5">
            <input value = '<?php echo isset($this->manufacturer['ManufacturerID'])?$this->manufacturer['ManufacturerName']:''?>' placeholder="Manufacturer Name" type = 'text' id="manufacturername" class="form-control" name = 'manufacturername'>
        </div>
    </div>
    
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-5">
            <button type="submit" class="btn btn-default">Submit</button>
        </div>
    </div>
</form>
