<div id = 'searchbox'>
    <form method = 'GET' action = '<?php echo URL ?>'>
        <input type="hidden" name="url" value="home/searchproducts">
        <label for="keyword">Search</label>
        <input type = 'text' id="keyword" name = 'keyword' value='<?php if (isset($_GET['keyword'])) echo $_GET['keyword'] ?>'>
            <label for="category">Category</label>
            <select name ='categoryid'>
                <option value='0'>All</option>
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
            <label for="manufacturer">Manufacturer</label>
        <select name ='manufacturerid'>

            <option value='0'>All</option>
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
        <input type ='submit' value='Search'>
    </form>
</div>