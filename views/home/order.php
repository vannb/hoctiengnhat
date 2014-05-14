<h3>Order information</h3>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);
    $note = trim($_POST['note']);
    $error = array();
    if (empty($name)) {
        $error['name'] = 'Enter name';
    }
    if (empty($address)) {
        $error['address'] = 'Enter address';
    }
    if (empty($phone)) {
        $error['phone'] = 'Enter phone number';
    }
    if (empty($error)) {
        $_SESSION['order']['name'] = $name;
        $_SESSION['order']['address'] = $address;
        $_SESSION['order']['phone'] = $phone;
        $_SESSION['order']['note'] = $note;
        header('location:' . URL . 'home/confirmorder');
    }
}
?>
<form class="form-horizontal" method ='POST' action='<?php echo htmlspecialchars(URL . 'home/order') ?>'>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="name" >Your full name</label>
        <div class="col-sm-5">
            <input required class="form-control" type = 'text' id = "name" name = 'name' value='<?php if (isset($name)) echo $name ?>'><font color='red'><?php if (isset($error['name'])) echo $error['name']; ?></font>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2">Delivery address</label>
        <div class="col-sm-5">
            <input required class="form-control" id="address" type = 'text' name = 'address' value='<?php if (isset($address)) echo $address ?>'><font color='red'><?php if (isset($error['address'])) echo $error['address']; ?></font>
        </div>
    </div>
    <div class="form-group">
        <label for="phone" class="control-label col-sm-2">Phone number</label>
        <div class="col-sm-5">
            <input required class="form-control" id = "phone" type = 'text' name = 'phone' value='<?php if (isset($phone)) echo $phone ?>'><font color='red'><?php if (isset($error['phone'])) echo $error['phone']; ?></font>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label" for="note">Note:</label>
        <div class="col-sm-5">
            <input class="form-control" id = "note" type = 'text' name = 'note' value='<?php if (isset($note)) echo $note ?>'>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-5 col-sm-offset-2">
            <a class="btn btn-primary col-xs-2 col-sm-4" href='<?php echo URL ?>cart'>Review Cart</a>
            <button class="btn btn-success  col-xs-2 col-sm-4">Submit</button>
        </div>
    </div>
</form>