<div class="login-forget-bar">LOGIN</div>
<div class="contents">
    <?php echo $this->Html->image('/images/enterid.png', array('class' => 'enteridLogin')) ?>
    <?php
    echo $this->Form->create('User', array(
        'id' => 'idLoginUser',
        'url' => array('controller' => 'auth', 'action' => 'login'),
        'inputDefaults' => array(
            'label' => false,
            'div' => false,
            'required' => false,
    )));
    ?>

    <div class="loginformC">
        <?php echo $this->Flash->render('AuthUser'); ?>
        <div class="mgB5">
            <?php echo $this->Html->image('/images/serverID.png', array('class' => 'loginid')) ?>
        </div>
        <?php echo $this->Form->input('user_id', array('type' => 'text', 'class' => 'inputid')); ?>
        <div class="mgB5 mgT10">
            <?php echo $this->Html->image('/images/pass.png', array('class' => 'loginpass')) ?>
        </div>
        <?php echo $this->Form->input('login_pw', array('maxlength'=>15,'type' => 'password', 'class' => 'inputpass')); ?>
        <p class="pForgetbutton">
            <?php echo $this->Html->image('/images/log_off.png', array('class' => 'loginbutton cursorPointer')) ?>
            <?php echo $this->Html->image('/images/logc_off.png', array('class' => 'clearbutton cursorPointer')) ?>
        </p>

        <p class="pForgetbutton">
            <?php
            echo $this->Html->image("/images/forget.jpg", array(
                "class" => "forgetbutton",
                'url' => array('controller' => 'Auth', 'action' => 'forget')
            ));
            ?>
        </p>
        <p class="copyright">Copyright © Digitaleaf.com All Rights Reserved</p>
    </div>
    <!--<input type="submit" style="display:none"/>-->
    <?php echo $this->Form->end(); ?>
</div>
<?php $this->start("viewscript"); ?>
<script>
    $(document).ready(function () {
        $('input').keypress(function (e) {
            if (e.which == 13) {
                $('form#idLoginUser').submit();
                return false;    //<---- Add this line
            }
        });
    });
</script>
<?php $this->end(); ?>

