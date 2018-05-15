<?php
$form_act = array("controller" => $this->name, "action" => "forget");
?>
<?php echo $this->Html->image("contents/login_forget_title.png", array("class" => "forget_title", "alt" => "ログインID、パスワードをお忘れの方")) ?>
<div class="login_form">
    <?php echo $this->Session->flash(); ?>
    <?php echo $this->Form->create("ForgetSendForm", array("url" => $form_act, "type" => "POST")); ?>
    <p><?php echo $this->Html->image("contents/login_idpass.png", array("alt" => "ログインIDまたはクライアント名")) ?></p>
    <?php echo $this->Form->text("Forget.user", array("class" => "input_field", "div" => false)) ?>
    <!--<input type="text" class="input_field">-->
    <p><?php echo $this->Html->image("contents/login_email.png", array("alt" => "通知用のメールアドレス")) ?></p>
    <?php echo $this->Form->text("Forget.email", array("class" => "input_field", "div" => false)) ?>
    <!--<input type="password" class="input_field">-->
    <div class="btnDiv">
        <?php echo $this->Form->submit("buttons/send.png", array("div" => false, "class" => "forget_send", "alt" => "送信する")) ?>
    </div>
    <?php echo $this->Form->end(); ?>
</div>