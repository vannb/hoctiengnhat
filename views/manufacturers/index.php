<h1>Total: <?php
    echo count($this->manufacturers);
    echo (count($this->manufacturers) > 1) ? ' manufacturers' : ' manufacturer';
    ?>
</h1>
<a class='btn btn-primary' href = '<?php echo URL ?>Manufacturers/Add'>Add new manufacturer</a>

<div class='row'>
    <div class='col-sm-5'>
        <table class='table table-hover table-condensed'>
            <th>ID</th>
            <th>Manufacturer</th>
            <th>Action</th>
            <?php foreach ($this->manufacturers as $key => $manufacturer): ?>
                <tr>
                    <td><?php echo $manufacturer['ManufacturerID'] ?></td>
                    <td><?php echo $manufacturer['ManufacturerName'] ?></td>
                    <td>
                        <a class='btn btn-success btn-xs' href ='<?php echo URL.'Manufacturers/Edit/'.$manufacturer['ManufacturerID'] ?>'>Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>