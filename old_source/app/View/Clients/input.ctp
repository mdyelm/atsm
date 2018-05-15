<div class="col-lg-12 non-float m40">
    <div class="well bs-component">
        <div class="inputForm">
            <?php echo $this->Form->create("Client", array("type" => "post", "class" => "form-horizontal")) ?>
            <table class="table font13">
                <tbody>
                    <?php if ($this->action == "edit"): ?>
                        <tr class="cap">
                            <th><span>クライアントID</span></th>
                            <td colspan="4">
                                <label><?php echo $this->Form->value("Client.client_id") ?></label>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <tr class="cap">
                        <th width="160"><span>クライアント名称</span></th>
                        <td colspan="4">
                            <?php echo $this->Form->input("Client.client_name", array("type" => "text", "label" => false, "size" => 25, "div" => false, 'error' => array('attributes' => array('wrap' => "span", 'class' => 'error-message')))) ?>
                        </td>
                    </tr>
                    <tr class="cap">
                        <th><span>観測場所</span></th>
                        <td colspan="4">
                            <?php echo $this->Form->input("Client.place", array("type" => "text", "label" => false, "size" => 25, "div" => false, 'error' => array('attributes' => array('wrap' => "span", 'class' => 'error-message')))) ?>
                        </td>
                    </tr>
                    <tr class="cap">
                        <th><span>パスワード</span></th>
                        <td colspan="4">
                            <?php echo $this->Form->input("Client.login_pw", array("type" => "text", "label" => false, "size" => 25, "div" => false, 'error' => array('attributes' => array('wrap' => "span", 'class' => 'error-message')))) ?>
                        </td>
                    </tr>
                    <tr class="cap">
                        <th><span>通知用メールアドレス</span></th>
                        <td colspan="4">
                            <?php echo $this->Form->input("Client.mail_address", array("type" => "text", "label" => false, "size" => 25, "div" => false, 'error' => array('attributes' => array('wrap' => "span", 'class' => 'error-message')))) ?>
                        </td>
                    </tr>
<!--                    <tr class="cap">
                        <th rowspan="3"><span>アラート閾値</span></th>
                        <td class="no-border-bottom">
                            <b class="mL10 mR14">画素差異数</b>
                            <?php echo $this->Form->text("Client.diff_pix", array("type" => "text", "label" => false, "size" => 2, "div" => false)) ?>
                            <span>%</span>
                            <?php echo $this->Form->error("Client.diff_pix", array('attributes' => array('wrap' => "span", 'class' => 'error-message'))) ?>
                        </td>
                    </tr>
                    <tr class="cap">
                        <td class="no-border-bottom">
                            <b class="mL10 mR26">時間差分</b>
                            <?php echo $this->Form->text("Client.time_gap", array("type" => "text", "label" => false, "size" => 2, "div" => false)) ?>
                            <span>秒</span>
                            <?php echo $this->Form->error("Client.time_gap", array('attributes' => array('wrap' => "span", 'class' => 'error-message'))) ?>
                        </td>
                    </tr>
                    <tr class="cap">
                        <td>
                            <b class="mL10">出力時間単位</b>
                            <?php echo $this->Form->text("Client.output_time", array("type" => "text", "label" => false, "size" => 2, "div" => false)) ?>
                            <span>分</span>
                            <?php echo $this->Form->error("Client.output_time", array('attributes' => array('wrap' => "span", 'class' => 'error-message'))) ?>
                        </td>
                    </tr>-->
                    <tr class="cap">
                        <th><span>ホスト名</span></th>
                        <td colspan="4">
                            <?php echo $this->Form->input("Client.host", array("type" => "text", "label" => false, "size" => 25, "div" => false, 'error' => array('attributes' => array('wrap' => "span", 'class' => 'error-message')))) ?>
                        </td>
                    </tr>
<!--                    <tr class="cap">
                        <th><span>IPアドレス</span></th>
                        <td colspan="2">
                            <?php echo $this->Form->text("Client.ip_address.0", array("type" => "text", "label" => false, "size" => 5, "div" => false)) ?>
                            <span>.</span>
                            <?php echo $this->Form->text("Client.ip_address.1", array("type" => "text", "label" => false, "size" => 5, "div" => false)) ?>
                            <span>.</span>
                            <?php echo $this->Form->text("Client.ip_address.2", array("type" => "text", "label" => false, "size" => 5, "div" => false)) ?>
                            <span>.</span>
                            <?php echo $this->Form->text("Client.ip_address.3", array("type" => "text", "label" => false, "size" => 5, "div" => false)) ?>
                            <?php echo $this->Form->error("Client.ip_address", array('attributes' => array('wrap' => "span", 'class' => 'error-message'))) ?>
                        </td>
                    </tr>-->
                    <tr class="cap">
                        <th><span>FTPアカウントID</span></th>
                        <td colspan="4"><?php echo $this->Form->input("Client.ftp_id", array("type" => "text", "label" => false, "size" => 25, "div" => false, 'error' => array('attributes' => array('wrap' => "span", 'class' => 'error-message')))) ?></td>
                    </tr>
                    <tr class="cap">
                        <th><span>FTPパスワード</span></th>
                        <td colspan="4"><?php echo $this->Form->input("Client.ftp_pw", array("type" => "text", "label" => false, "size" => 25, "div" => false, 'error' => array('attributes' => array('wrap' => "span", 'class' => 'error-message')))) ?></td>
                    </tr>
<!--                    <tr class="cap">
                        <th><span>画像取得時間</span></th>
                        <td colspan="4">
                            <?php echo $this->Form->text("Client.get_pic_time", array("type" => "text", "label" => false, "size" => 2, "div" => false)) ?>
                            <span>分間隔</span>
                            <?php echo $this->Form->error("Client.get_pic_time", array('attributes' => array('wrap' => "span", 'class' => 'error-message'))) ?>
                        </td>
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
<?php $this->start("viewscript"); ?>
<script>
    $(document).ready(function () {
        $("#confirmBtn").hover(function () {
            $(this).attr("src", "<?php echo Router::url('/images/buttons/btn_confirm_on.jpg') ?>");
        }, function () {
            $(this).attr("src", "<?php echo Router::url('/images/buttons/btn_confirm_off.jpg') ?>");
        });
        $("#backBtn").hover(function () {
            $(this).attr("src", "<?php echo Router::url('/images/buttons/btn_back_on.jpg') ?>");
        }, function () {
            $(this).attr("src", "<?php echo Router::url('/images/buttons/btn_back_off.jpg') ?>");
        });
        $("#clearBtn").hover(function () {
            $(this).attr("src", "<?php echo Router::url('/images/buttons/btn_clear_on.png') ?>");
        }, function () {
            $(this).attr("src", "<?php echo Router::url('/images/buttons/btn_clear_off.png') ?>");
        });
    });
</script>
<?php $this->end(); ?>

