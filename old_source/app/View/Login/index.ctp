<?php echo $this->Html->image("contents/login_enter_title.png", array("class" => "enter_title", "alt" => "ログインIDとパスワードをご入力ください")) ?>
<div class="login_form">
    <?php echo $this->Form->create("SUser", array("type" => "POST", "url" => array("controller" => $this->name, "action" => "index"))) ?>
    <?php echo $this->Session->flash(); ?>
    <p><?php echo $this->Html->image("contents/login_serverid.png", array("alt" => "担当者ID")) ?></p>
    <?php echo $this->Form->text("login_id", array("class" => "input_field", "style" => "margin-bottom: 5px")) ?>
    <p><?php echo $this->Html->image("contents/login_pass.png", array("alt" => "パスワード")) ?></p>
    <?php echo $this->Form->password("login_pw", array("class" => "input_field")) ?>
    <div class="btnDiv">
        <?php echo $this->Form->submit("buttons/login.png", array("div" => false, "alt" => "ログイン")) ?>
        <?php echo $this->Html->link($this->Html->image("buttons/clear.png"), array("controller" => $this->name, "action" => "index"), array("escape" => FALSE, "alt" => "クリア")); ?>
    </div>
    <?php echo $this->Form->end(); ?>
    <p><?php echo $this->Html->link($this->Html->image("buttons/forget.jpg"), array("controller" => $this->name, "action" => "forget"), array("escape" => FALSE, "alt" => "ログインID、パスワードをお忘れの方")); ?></p>
</div>