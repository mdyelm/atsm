<?php
if ($this->action == "create") {
    $msg = "以下の情報で登録します。よろしいですか？";
    $form_act = array("controller" => $this->name, "action" => "create_act");
    $back_url = array("controller" => $this->name, "action" => "create");
} elseif ($this->action == "edit") {
    $msg = "以下の項目で編集します。よろしいですか？";
    $form_act = array("controller" => $this->name, "action" => "edit_act", $id);
    $back_url = array("controller" => $this->name, "action" => "edit", $id);
} elseif ($this->action == "delete") {
    $msg = "以下の項目を削除してもよろしいでしょうか?";
    $form_act = array("controller" => $this->name, "action" => "delete", $id);
    $back_url = array("controller" => $this->name, "action" => "index");
}
?>
<!--メインコンテンツ-->
<div class="container backWhite">
    <div class="col-lg-12">
        <h4><?php echo $msg ?></h4>
    </div>
    <div class="col-lg-12 non-float m40">
        <div class="well bs-component">
            <div class="inputForm">
                <?php echo $this->Form->create("SUser", array("type" => "post", "url" => $form_act, "class" => "form-horizontal", "id" => "confirmForm")) ?>
                <table class="table font13">
                    <tbody>
                        <?php if ($this->action == "edit" || $this->action == "delete"): ?>
                            <tr class="cap">
                                <th><span>担当者ID</span></th>
                                <td><?php echo $this->Form->value("SUser.user_id") ?></td>
                            </tr>
                        <?php endif; ?>
                        <tr class="cap">
                            <th width="200"><span>組織名</span></th>
                            <td><?php echo h($this->Form->value("SUser.organization_name")) ?></td>
                        </tr>
                        <tr class="cap">
                            <th><span>担当・役職名</span></th>
                            <td><?php echo h($this->Form->value("SUser.position")) ?></td>
                        </tr>
                        <tr class="cap">
                            <th><span>氏名</span></th>
                            <td><?php echo h($this->Form->value("SUser.user_name")) ?></td>
                        </tr>
                        <tr class="cap">
                            <th><span>電話番号１</span></th>
                            <td><?php echo $this->Form->value("SUser.phone1") ?></td>
                        </tr>
                        <tr class="cap">
                            <th><span>電話番号２</span></th>
                            <td><?php echo $this->Form->value("SUser.phone2") ?></td>
                        </tr>
                        <tr class="cap">
                            <th><span>通知用メールアドレス１</span></th>
                            <td><?php echo $this->Form->value("SUser.mail_address1") ?></td>
                        </tr>
                        <tr class="cap">
                            <th><span>通知用メールアドレス２</span></th>
                            <td><?php echo $this->Form->value("SUser.mail_address2") ?></td>
                        </tr>
                        <tr class="cap">
                            <th><span>システム権限</span></th>
                            <td><?php echo $this->App->getAuthority($this->Form->value("SUser.authority")) ?></td>
                        </tr>
                        <tr class="cap">
                            <th><span>ログインID</span></th>
                            <td><?php echo $this->Form->value("SUser.ftp_id") ?></td>
                        </tr>
                        <tr class="cap">
                            <th><span>パスワード</span></th>
                            <td><?php echo $this->Form->value("SUser.ftp_pw") ?></td>
                        </tr>
                    </tbody>
                </table>
                <input type="hidden" name="token_act" value="<?php echo $token_act ?>">
                <div class="btnDiv">
                    <?php if ($this->action == "create"): ?>
                        <?php echo $this->Form->submit("buttons/btn_create_off.jpg", array("name" => "conf_act", "alt" => "編集", "div" => FALSE, "id" => "createBtn")); ?>
                        <?php echo $this->Html->link($this->Html->image("buttons/btn_back_off.jpg", array("id" => "backBtn")), "javascript:void(0);", array("id" => "backLink", "escape" => false)); ?>
                    <?php elseif ($this->action == "edit"): ?>
                        <?php echo $this->Form->submit("buttons/btn_edit_off.jpg", array("name" => "conf_act", "alt" => "登録", "div" => FALSE, "id" => "editBtn")); ?>
                        <?php echo $this->Html->link($this->Html->image("buttons/btn_back_off.jpg", array("id" => "backBtn")), "javascript:void(0);", array("id" => "backLink", "escape" => false)); ?>
                    <?php elseif ($this->action == "delete"): ?>
                        <?php echo $this->Form->submit("buttons/btn_delete_off.jpg", array("name" => "conf_act", "alt" => "削除", "div" => FALSE, "id" => "deleteBtn")); ?>
                        <?php echo $this->Html->link($this->Html->image("buttons/btn_back_off.jpg", array("id" => "backBtn")), $back_url, array("id" => "backLink", "escape" => false)); ?>
                    <?php endif; ?>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
<!--確認メッセージ用-->
<?php if ($this->action != "delete"): ?>
    <?php echo $this->Form->create(null, array("type" => "post", "url" => $back_url, "id" => "backForm")) ?>
    <input type="hidden" name="back_form" value="confirm">
    <input type="hidden" name="token" value="<?php echo $token; ?>">
    <?php echo $this->Form->end() ?>
<?php endif; ?>
<!--メインコンテンツ終了-->
<div id="confirmModal" class="modal fade" role="dialog">
    <!--<a href="#" class="close_overlay">×</a>-->
    <span class="modal_window">
        <h2>確認</h2>
        <p id="msg"></p>
        <input type="button" value="はい" onClick="location.href = '<?php echo $this->html->url(array("controller" => $this->name, "action" => "index")) ?>'">
    </span>
</div>
<?php $this->start("viewscript"); ?>
<script>
    $(document).ready(function () {
        $("#editBtn").hover(function () {
            $(this).attr("src", "<?php echo Router::url('/images/buttons/btn_edit_on.jpg') ?>");
        }, function () {
            $(this).attr("src", "<?php echo Router::url('/images/buttons/btn_edit_off.jpg') ?>");
        });
        $("#createBtn").hover(function () {
            $(this).attr("src", "<?php echo Router::url('/images/buttons/btn_create_on.jpg') ?>");
        }, function () {
            $(this).attr("src", "<?php echo Router::url('/images/buttons/btn_create_off.jpg') ?>");
        });
        $("#deleteBtn").hover(function () {
            $(this).attr("src", "<?php echo Router::url('/images/buttons/btn_delete_on.jpg') ?>");
        }, function () {
            $(this).attr("src", "<?php echo Router::url('/images/buttons/btn_delete_off.jpg') ?>");
        });
        $("#backBtn").hover(function () {
            $(this).attr("src", "<?php echo Router::url('/images/buttons/btn_back_on.jpg') ?>");
        }, function () {
            $(this).attr("src", "<?php echo Router::url('/images/buttons/btn_back_off.jpg') ?>");
        });
        $("#backLink").click(function () {
            $("#backForm").submit();
        });
        $("#confirmForm").submit(function (e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: "<?php echo $this->html->url($form_act); ?>",
                data: $("#confirmForm").serialize(),
                dataType: "json",
                success: function (data)
                {
                    $('#confirmModal').show();
                    $('#confirmModal').find("#msg").html(data.message);
                    $('#confirmModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    })
                }
            });
        });
    });
</script>
<?php $this->end(); ?>


