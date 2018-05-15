<div id="title2">
    <?php echo $this->Html->image("camera.png") ?>
    <?php if ($this->name == "Clients"): ?>
        <?php if ($this->action == "index"): ?>
            <span>クライアント一覧</span>
        <?php elseif ($this->action == "create"): ?>
            <span>新規クライアント登録</span>
        <?php elseif ($this->action == "edit" || $this->action == "delete"): ?>
            <span>クライアント編集</span>
        <?php endif; ?>
    <?php elseif ($this->name == "Users"): ?>
        <?php if ($this->action == "index"): ?>
            <span>担当者一覧</span>
        <?php elseif ($this->action == "create"): ?>
            <span>新規担当者登録</span>
        <?php elseif ($this->action == "edit" || $this->action == "delete"): ?>
            <span>担当者編集</span>
        <?php endif; ?>
    <?php elseif ($this->name == "Notifications"): ?>
        <span>通知先管理</span>
    <?php elseif ($this->name == "Observations"): ?>
        <span>観測状況一覧</span>
    <?php elseif ($this->name == "Alerts"): ?>
        <?php if ($this->action == "index"): ?>
            <span>アラート管理一覧</span>
        <?php elseif ($this->action == "status"): ?>
            <span>アラート観測状況管理</span>
        <?php endif; ?>
    <?php elseif ($this->name == "Datas"): ?>
        <span>データ出力管理</span>
    <?php endif; ?>
    <?php echo $this->Html->link($this->Html->image("buttons/logout_off.png", array("id" => "logout", "align" => "right")), array("controller" => "Login", "action" => "logout"), array("escape" => false)) ?>
</div>
<?php $this->start("viewscript"); ?>
<script>
    $(document).ready(function () {
        $("#logout").hover(function () {
            $(this).attr("src", "<?php echo Router::url('/images/buttons/logout_on.png') ?>");
        }, function () {
            $(this).attr("src", "<?php echo Router::url('/images/buttons/logout_off.png') ?>");
        });
    });
</script>
<?php $this->end(); ?>