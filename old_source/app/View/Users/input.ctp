<!--メインコンテンツ-->
<div class="container backWhite">
    <div class="col-lg-12 non-float m40">
        <div class="well bs-component">
            <div class="inputForm">
                <?php echo $this->Form->create("User", array("type" => "post", "class" => "form-horizontal")) ?>
                <table class="table font13">
                    <tbody>
                        <?php if ($this->action == "edit"): ?>
                            <tr class="cap">
                                <th><span>担当者ID</span></th>
                                <td>
                                    <label><?php echo $this->Form->value("SUser.user_id") ?></label>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <tr class="cap">
                            <th width="180"><span>組織名</span></th>
                            <td><?php echo $this->Form->input("SUser.organization_name", array("type" => "text", "label" => false, "size" => 25, "div" => false, 'error' => array('attributes' => array('wrap' => "span", 'class' => 'error-message')))) ?></td>
                        </tr>
                        <tr class="cap">
                            <th><span>担当・役職名</span></th>
                            <td><?php echo $this->Form->input("SUser.position", array("type" => "text", "label" => false, "size" => 25, "div" => false, 'error' => array('attributes' => array('wrap' => "span", 'class' => 'error-message')))) ?></td>
                        </tr>
                        <tr class="cap">
                            <th><span>氏名</span></th>
                            <td><?php echo $this->Form->input("SUser.user_name", array("type" => "text", "label" => false, "size" => 25, "div" => false, 'error' => array('attributes' => array('wrap' => "span", 'class' => 'error-message')))) ?></td>
                        </tr>
                        <tr class="cap">
                            <th><span>電話番号１</span></th>
                            <td><?php echo $this->Form->input("SUser.phone1", array("type" => "text", "label" => false, "size" => 15, "div" => false, 'error' => array('attributes' => array('wrap' => "span", 'class' => 'error-message')))) ?></td>
                        </tr>
                        <tr class="cap">
                            <th><span>電話番号２</span></th>
                            <td><?php echo $this->Form->input("SUser.phone2", array("type" => "text", "label" => false, "size" => 15, "div" => false, 'error' => array('attributes' => array('wrap' => "span", 'class' => 'error-message')))) ?></td>
                        </tr>
                        <tr class="cap">
                            <th><span>通知用メールアドレス１</span></th>
                            <td><?php echo $this->Form->input("SUser.mail_address1", array("type" => "text", "label" => false, "size" => 35, "div" => false, 'error' => array('attributes' => array('wrap' => "span", 'class' => 'error-message')))) ?></td>
                        </tr>
                        <tr class="cap">
                            <th><span>通知用メールアドレス２</span></th>
                            <td><?php echo $this->Form->input("SUser.mail_address2", array("type" => "text", "label" => false, "size" => 35, "div" => false, 'error' => array('attributes' => array('wrap' => "span", 'class' => 'error-message')))) ?></td>
                        </tr>
                        <tr class="cap">
                            <th><span>システム権限</span></th>
                            <td><?php echo $this->Form->input("SUser.authority", array("type" => "select", "options" => Configure::read("authority_list"), "empty" => "選択してください", "style" => "width: 225px", "label" => false, "div" => false, 'error' => array('attributes' => array('wrap' => "span", 'class' => 'error-message')))); ?></td>
                        </tr>
                        <tr class="cap">
                            <th><span>ログインID</span></th>
                            <td><?php echo $this->Form->input("SUser.ftp_id", array("type" => "text", "label" => false, "size" => 25, "div" => false, 'error' => array('attributes' => array('wrap' => "span", 'class' => 'error-message')))) ?></td>
                        </tr>
                        <tr class="cap">
                            <th><span>パスワード</span></th>
                            <td><?php echo $this->Form->input("SUser.ftp_pw", array("type" => "text", "label" => false, "size" => 25, "div" => false, 'error' => array('attributes' => array('wrap' => "span", 'class' => 'error-message')))) ?></td>
                        </tr>
                        <!--<tr class="cap">
                          <th>パスワード確認用</th>
                          <td><input type="password" class="form-cont2 wid31" id="inputEmail"></td>
                        </tr>-->
                    </tbody>
                </table>
                <input type="hidden" name="token" id="Token" value="<?php echo $token; ?>">
                <div class="btnDiv">
                    <?php echo $this->Form->submit("buttons/btn_confirm_off.jpg", array("div" => false, "id" => "confirmBtn")) ?>
                    <?php if ($this->action == "create"): ?>
                        <?php echo $this->Html->link($this->Html->image("buttons/btn_clear_off.png", array("id" => "clearBtn")), array("controller" => $this->name, "action" => "create"), array("escape" => false)) ?>
                    <?php elseif ($this->action == "edit"): ?>
                        <?php echo $this->Html->link($this->Html->image("buttons/btn_back_off.jpg", array("id" => "backBtn")), array("controller" => $this->name, "action" => "index"), array("escape" => false)) ?>
                    <?php endif; ?>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->start("viewscript"); ?>
<script>
    $(document).ready(function () {
        $("#confirmBtn").hover(function () {
            $(this).attr("src", "<?php echo Router::url('/images/buttons/btn_confirm_on.jpg') ?>");
        }, function () {
            $(this).attr("src", "<?php echo Router::url('/images/buttons/btn_confirm_off.jpg') ?>");
        });
        $("#clearBtn").hover(function () {
            $(this).attr("src", "<?php echo Router::url('/images/buttons/btn_clear_on.png') ?>");
        }, function () {
            $(this).attr("src", "<?php echo Router::url('/images/buttons/btn_clear_off.png') ?>");
        });
        $("#backBtn").hover(function () {
            $(this).attr("src", "<?php echo Router::url('/images/buttons/btn_back_on.jpg') ?>");
        }, function () {
            $(this).attr("src", "<?php echo Router::url('/images/buttons/btn_back_off.jpg') ?>");
        });
    });
</script>
<?php $this->end(); ?>

