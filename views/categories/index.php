<h1>Total: <?php
    echo count($this->categories);
    echo (count($this->categories) > 1) ? ' categories' : ' category';
    ?>
</h1>
<div>
    <a class='btn btn-primary' href = '<?php echo URL ?>Categories/Add'>Add new category</a>

    <div class='row'>
        <div class='col-sm-5'>
            <table class='table table-hover table-condensed'>
                <tr>
                    <th>ID</th>
                    <th>Category</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($this->categories as $key => $category): ?>
                    <tr>
                        <td><?php echo $category['CategoryID'] ?></td>
                        <td><?php echo $category['CategoryName'] ?></td>
                        <td>
                            <a class='btn btn-success btn-xs' href = '<?php echo URL ?>Categories/Edit/<?php echo $category['CategoryID'] ?>'>Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>