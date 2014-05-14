


<!--<div id ='list_categories'>
    <ul>
        <?php foreach ($this->categories as $key => $value): ?>
            <li>
                <a class='white' href = '<?php echo URL ?>home/searchProducts&categoryid=<?php echo $value['CategoryID'] ?>'>
                    <?php echo $value['CategoryName']; ?>
                </a>
            </li>
            <?php
        endforeach;
        ?>
    </ul>
</div>
<div id="slider">

    <div id ='tabs_container'>
        <ul id ='tabs'>
            <li class='selected'>&nbsp;</li>
            <li>&nbsp;</li>
            <li>&nbsp;</li>
        </ul>
    </div>
    <div id='tabs_content'>
        <a href="<?php echo URL ?>home/displayproduct/27">
            <div class="current" style="background-image: url(<?php echo PATH; ?>/views/home/slider_img/vaio.jpg)">
            </div>
        </a>
        <a href="<?php echo URL ?>home/displayproduct/19">
            <div class style="background-image: url(<?php echo PATH; ?>/views/home/slider_img/iphone.png)"></div>
        </a>
        <a href="<?php echo URL ?>home/displayproduct/22">
            <div class style="background-image: url(<?php echo PATH; ?>/views/home/slider_img/xperia.jpg)"></div>
        </a>
    </div>
</div>
<script>
    $(document).ready(function() {
        var a
        var tabs = $('#tabs li');
        a = setInterval(function() {
            $('#tabs li:eq(' + (tabs.index($('#tabs li.selected')) + 1) % tabs.length + ')').click();
        }, 3000);
        $('#tabs li').each(function(i, item) {
            $(this).click(function() {
                $('#tabs li.selected').removeClass('selected');
                $(this).addClass('selected');
                $('#tabs_content div.current').removeClass('current');
                $('#tabs_content div:eq(' + i + ')').addClass('current');
                clearInterval(a);
                a = setInterval(function() {
                    $('#tabs li:eq(' + (tabs.index($('#tabs li.selected')) + 1) % tabs.length + ')').click();
                }, 3000);
            });
        });
    });
</script>-->