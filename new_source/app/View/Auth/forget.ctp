<div class="login-forget-bar">ID/PASSWORDを忘れた方</div>
<div class="contents">
    <div class="forget-title">
        IDを正確に入力していただき、発行パスワードのお届け先となるメールアドレス入力のうえ、下の送信ボタンを押してください。
    </div>
    <?php
    echo $this->Form->create('User', array(
        'id' =>'idLoginUser',
        'url' => array('controller' => 'auth', 'action' => 'forget'),
        'inputDefaults' => array(
            'label' => false,
            'div' => false,
            'required' => false,
    )));
    ?>
      <div class="loginform forget-form">
          <?php echo $this->Flash->render('Forget'); ?>
          <?php echo $this->Flash->render('AuthUser'); ?>
        <div class="mgB5">
            ID
        </div>
        <?php echo $this->Form->input('user_id', array('type' => 'text', 'class' => 'inputid')); ?>
        <div class="mgB5 mgT10">
            登録メールアドレス
        </div>
        <?php echo $this->Form->input('forget_mail', array('type' => 'text', 'class' => 'inputpass')); ?>
        <div class="mgT20 btn-zone">
            <?php
            echo $this->Html->link('戻る', array(
                'controller' => 'Auth',
                'action' => 'login'
                ), 
                array('class' => 'forget-btn pull-left mgR26 btn-left')
            );
            ?>
            <a href="javascript:void(0)" class="forgetsend submitForget forget-btn pull-left btn-right">送信する</a>
        </div>
        <p class="copyrightforget">Copyright © Digitaleaf.com All Rights Reserved</p>
      </div>
    <?php echo $this->Form->end(); ?>
</div>