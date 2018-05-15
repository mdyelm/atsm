<!--メインコンテンツ-->
<div class="container backWhite">
    <div class="col-lg-12">
        <h4>以下の項目で編集します。よろしいですか？</h4>
    </div>
    <div class="col-lg-12 non-float m40">
        <div class="well bs-component">
            <div class="inputForm">
                <?php echo $this->Form->create("AlertMessage", array("type" => "post", "url" => array("controller" => $this->name, "action" => "edit_act", $id), "class" => "form-horizontal", "id" => "confirmForm")) ?>
                <table class="table font13">
                    <tbody>
                        <tr class="cap">
                            <th width="152"><span>件名</span></th>
                            <td><?php echo h($this->Form->value("AlertMessage.title")) ?></td>
                        </tr>
                        <tr class="cap">
                            <th><span>本文</span></th>
                            <td><?php echo nl2br(h($this->Form->value("AlertMessage.message"))) ?></td>
                        </tr>
                    </tbody>
                </table>
                <input type="hidden" name="token_edit_act" value="<?php echo $token_edit_act ?>">
                <div class="btnDiv">
                    <?php echo $this->Form->submit("buttons/btn_edit_off.jpg", array("name" => "conf_act", "alt" => "編集", "div" => FALSE, "id" => "editBtn")); ?>
                    <?php echo $this->Html->link($this->Html->image("buttons/btn_back_off.jpg", array("id" => "backBtn")), "javascript:void(0);", array("id" => "backLink", "escape" => false)); ?>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
<?php echo $this->Form->create(null, array("type" => "post", "url" => array("controller" => $this->name, "action" => "index", $id), "id" => "backForm")) ?>
<input type="hidden" name="back_form" value="confirm">
<?php echo $this->Form->end() ?>

<div id="confirmModal" class="modal fade" role="dialog">
    <!--<a href="#" class="close_overlay">×</a>-->
    <span class="modal_window">
        <h2>確認</h2>
        <p id="msg">基本情報を登録しました。</p>
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
                url: "<?php echo $this->html->url(array("controller" => $this->name, "action" => "edit_act", $id)); ?>",
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