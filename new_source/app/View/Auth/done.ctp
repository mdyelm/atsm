<div class="login-forget-bar">ID/PASSWORDを忘れた方</div>
<div class="contents">
    <div class="done">
      <p style="margin-top:50px;">メールアドレスにパスワードを送信しました</p>
      <p align="center" style="margin-top:50px;margin-left:-210px;">
          <?php
                echo $this->Html->image("/images/forgetback.jpg", array(
                    'url' => array('controller' => 'Auth', 'action' => 'login')
                ));
            ?>
      </p>
      <p class="copyrightdone">Copyright © Digitaleaf.com All Rights Reserved</p>
    </div>
</div>