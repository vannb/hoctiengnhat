<div class="row-fluid">
    <div class="span10">
        <div class="box">
            <div class="box-title">
                <h3>
                    <?php echo translate('Câu hỏi mới nhất') ?>
                </h3>
            </div>
            <div class="box-content">
                <ul class="messages">
                    <?php foreach ($array as $key => $value): ?>
                        <?php
                        echo '<li class="left">
                                <div class="image">
                                    <img>
                                </div>
                                <div class="message">
                                    <span class="caret"></span>
                                    <span class="name">Jane Doe</span>
                                    <p>Lorem ipsum aute ut ullamco et nisi ad. </p>
                                    <span class="time">
                                        12 minutes ago
                                    </span>
                                </div>'
                        . '</li>'
                        ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>