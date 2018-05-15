<!--メインコンテンツ-->
<div class="container backWhite">
    <div class="col-lg-12 non-float m40">
        <div class="well bs-component">
            <table class="table font13">
                <tbody>
                <?php echo $this->Form->create("AlertMessage", array("type" => "post", "url" => array("controller" => $this->name, "action" => "index", $id))) ?>
                <tr class="cap inputForm">
                    <th>アラートメッセージ</th>
                    <td colspan="5">
                        <div style="float: left; padding: 6px 0 0 4px;">
                            <b>件名</b>
                        </div>
                        <br><br>
                        <div>
                            <?php echo $this->Form->input("AlertMessage.title", array("type" => "text", "label" => false, "div" => false, "style" => "width: 737px;")) ?>
                        </div>
                        <div style="float: left; padding: 12px 0 0 4px;">
                            <b>本文</b>
                        </div>
                        <br><br>
                        <div>
                            <?php echo $this->Form->textarea("AlertMessage.message", array("label" => false, "div" => false, "style" => "width: 737px; margin-bottom: -12px;", "rows" => 10, "cols" => 86)) ?>
                            <input type="submit" class="btn btn-def2" style="margin-left: 27px;" value="&nbsp;&nbsp;編集&nbsp;&nbsp;"/>
                            <?php echo $this->Form->error("AlertMessage.message") ?>
                        </div>
                    </td>
                </tr>
                <?php echo $this->Form->end(); ?>
                <tr class="cap">
                    <th rowspan="<?php echo ($data) ? count($data) + 2 : 2 ?>">通知先アドレス</th>
                    <th>通知先名</th>
                    <th colspan="3">メールアドレス</th>
                    <th>登録/削除</th>
                </tr>
                <?php echo $this->Form->create("AlertTarget", array("type" => "post", "url" => array("controller" => $this->name, "action" => "create"), "id" => "alertTargetCreateForm")) ?>
                <tr class="cap inputForm">
                    <td><?php echo $this->Form->text("AlertTarget.notification_name", array("type" => "text", "label" => false, "size" => 35, "div" => false)) ?></td>
                    <td colspan="3"><?php echo $this->Form->text("AlertTarget.mail_address", array("type" => "text", "label" => false, "size" => 35, "div" => false)) ?></td>
                    <td style="padding-left: 8px; padding-right: 35px;">
                        <input type="hidden" name="token_act" value="<?php echo $token_act ?>">
                        <button type="button" class="btn btn-def2" data-toggle="modal" data-target="#alertTargetCreateConfirmModal">&nbsp;&nbsp;登録&nbsp;&nbsp;</button>
                    </td>
                </tr>
                <?php echo $this->Form->end(); ?>
                <?php if ($data): ?>
                    <?php foreach ($data as $row): ?>
                        <tr class="cap">
                            <td><?php echo h($row["AlertTarget"]["notification_name"]) ?></td>
                            <td colspan="3"><?php echo $row["AlertTarget"]["mail_address"] ?></td>
                            <td><button type="button" class="btn btn-def2" onClick="showAlertDeleteConfirm(<?php echo $row["AlertTarget"]["id"] ?>)">&nbsp;&nbsp;削除&nbsp;&nbsp;</button></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!--確認メッセージ用-->
<div id="modal">
    <!--
   <div id="open01">
   <a href="#" class="close_overlay">×</a>
   <span class="modal_window">
   <h2>登録確認</h2>
   <p>入力した内容でアラートメッセージを登録します。よろしいですか？</p>
   <input type="button" value="はい" onClick="location.href='#'">
   <input type="button" value="いいえ" onClick="location.href='#'"><p>-->
    <!--</span>--><!--/.modal_window-->
    <!--</div>--><!--/#open01-->

    <div id="alertTargetCreateConfirmModal" class="modal fade" role="dialog">
        <span class="modal_window">
            <h2>登録確認</h2>
            <p>入力した内容で通知先アドレスを登録します。よろしいですか？</p>
            <input type="button" value="はい" onclick="alertTargetCreate(); $('#alertTargetCreateConfirmModal').modal('hide');">
            <input type="button" value="いいえ" onClick="$('#alertTargetCreateConfirmModal').modal('hide');"><p>
        </span>
    </div>

    <div id="alertTargetDeleteConfirmModal" class="modal fade" role="dialog">
        <span class="modal_window">
            <h2>削除確認</h2>
            <p>選択したアドレスを削除します。<br />よろしいですか？</p>
            <input type="button" value="はい" id="deleteBtn">
            <input type="button" value="いいえ" onClick="$('#alertTargetDeleteConfirmModal').modal('hide');"><p>
        </span>
    </div>

    <div id="alertTargetConfirmModal" class="modal fade" role="dialog">
        <a href="#" class="close_overlay">×</a>
        <span class="modal_window">
            <h2>確認</h2>
            <p id="msg">通知先アドレスを登録しました。</p>
            <input type="button" value="はい" onClick="location.href = '<?php echo $this->Html->url(array("controller" => $this->name, "action" => "index")) ?>'">
        </span>
    </div>
</div><!--/#modal-->
<?php $this->start("viewscript"); ?>
<script>
    var showAlertDeleteConfirm = function (id) {
        $("#alertTargetDeleteConfirmModal").find("#deleteBtn").attr("onclick", "alertTargetDelete(" + id + "); $('#alertTargetDeleteConfirmModal').modal('hide');");
        $("#alertTargetDeleteConfirmModal").modal("show");
    }

    var alertTargetCreate = function () {
        $.ajax({
            type: "post",
            url: "<?php echo $this->html->url(array("controller" => $this->name, "action" => "create")); ?>",
            data: $("#alertTargetCreateForm").serialize(),
            dataType: "json",
            success: function (data)
            {
                if (data.valid) {
                    $('#alertTargetConfirmModal').show();
                    $('#alertTargetConfirmModal').find("#msg").html(data.message);
                    $('#alertTargetConfirmModal').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                } else {
                    $(".error-message").remove();
                    for (fieldName in data.error_message) {
                        var element = $("input[name='data[AlertTarget][" + fieldName + "]']");
                        var create = $(document.createElement('div')).insertAfter(element);
                        create.addClass('error-message').text(data.error_message[fieldName][0]);
                    }
                }
            }
        });
    };

    var alertTargetDelete = function (id) {
        $.ajax({
            type: "post",
            url: "<?php echo $this->html->url(array("controller" => $this->name, "action" => "delete")); ?>/" + id,
            dataType: "json",
            success: function (data)
            {
                $('#alertTargetConfirmModal').show();
                $('#alertTargetConfirmModal').find("#msg").html(data.message);
                $('#alertTargetConfirmModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
            }
        });
    };
</script>
<?php $this->end(); ?>

