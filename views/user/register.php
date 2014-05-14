<script src="<?php echo PATH ?>js/plugins/complexify/jquery.complexify-banlist.min.js"></script>
<script src="<?php echo PATH ?>js/plugins/complexify/jquery.complexify.js"></script>
<script src="<?php echo PATH ?>js/plugins/validation/jquery.validate.min.js"></script>
<script src="<?php echo PATH ?>js/plugins/validation/additional-methods.min.js"></script>
<div class="row-fluid">
    <div class="span12">
        <div class="box box-bordered">
            <div class="box-title">
                <h3><i class="icon-th-list"></i>Mẫu đăng ký</h3>
            </div>
            <div class="box-content nopadding">
                <form action="#" method="POST" class='form-horizontal form-bordered form-validate' id="bb">
                    <div class="control-group">
                        <label for="username" class="control-label">Tên đăng nhập</label>
                        <div class="controls">
                            <div class="span8">
                                <input class="input-block-level" type="text" id="username" name="username"
                                       maxlength="32" placeholder="Tên đăng nhập"
                                       data-rule-required="true" data-rule-minlength="5"
                                       required="true" value="<?php echo get_post_var('username', '') ?>">
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="password" class="control-label">Mật khẩu</label>
                        <div class="controls">
                            <div class="span8">
                                <input type="password" id="password" name="password"
                                       placeholder="Mật khẩu" size="60"
                                       class='complexify-me input-block-level'
                                       data-rule-required="true" data-rule-minlength="5"
                                       required="true">
                                <span class="help-block">
                                    <div class="span3">Độ mạnh: </div>
                                    <div class="span9">
                                        <div class="progress progress-info">
                                            <div class="bar bar-red" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </span>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="confirm_password" class="control-label">Nhập lại mật khẩu</label>
                        <div class="controls">
                            <div class="span8">
                                <input type="password" id="confirm_password" name="confirm_password"
                                       placeholder="Nhập lại mật khẩu"
                                       class='input-block-level' size="60"
                                       data-rule-required="true" 
                                       data-rule-equalTo="#password"
                                       required="true">
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="name" class="control-label">Họ và tên</label>
                        <div class="controls">
                            <div class="span8">
                                <input class="input-block-level" type="text" id="name" name="name"
                                       maxlength="100" placeholder="Họ và tên"
                                       data-rule-required="true"
                                       required="true" value="<?php echo get_post_var('name', '') ?>">
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="email" class="control-label">Email</label>
                        <div class="controls">
                            <div class="span8">
                                <input class="input-block-level" type="email"
                                       id="email" name="email"
                                       maxlength="100" placeholder="Email"
                                       data-rule-required="true"
                                       data-rule-email ="true" required="true" value="<?php echo get_post_var('email'); ?>">
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="confirm_email" class="control-label">Nhập lại Email</label>
                        <div class="controls">
                            <div class="span8">
                                <input type="text" id="confirm_email" name="confirm_email"
                                       placeholder="Nhập lại Email"
                                       class='input-block-level'
                                       data-rule-required="true" 
                                       data-rule-equalTo="#email"
                                       required="true">
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="policy" class="control-label">&nbsp;</label>
                        <div class="controls">
                            <label class="checkbox">
                                <input type="checkbox" name="policy" value="agree"
                                       data-rule-required="true" required="true">
                                Tôi đồng ý quy định
                            </label>
                        </div>
                    </div>
                    <div class="form-actions">
                        <input type="submit" class="btn btn-primary" value="Đăng ký">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>