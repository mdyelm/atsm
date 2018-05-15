<!DOCTYPE html>
<html lang="ja">
    <head>
        <?php echo $this->Html->charset(); ?>
        <meta name="copyright" content="&copy; digitaleaf">
        <title><?php echo $title_for_layout; ?></title>
        <?php echo $this->Html->meta('icon'); ?>
        <?php echo $this->fetch('meta'); ?>
        <?php echo $this->Html->css(array("base-style", "bootstrap", "bootswatch", "base")); ?>
        <?php echo $this->fetch('css'); ?>
        <?php echo $this->fetch('script'); ?>
    </head>
    <body>
        <!--    <?php echo $this->Html->image("abc.png") ?>-->
        <!--メニューバー-->
        <div id="head">
            <div class="container s-back">
                <div class="navbar-header">
                    <a href="#" class="navbar-brand title-font"><img src="./images/S-logo.png" alt="logo"></a>
                </div>
                <div class="navbar-collapse collapse" id="navbar-main">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <?php
                            echo $this->Html->link(
                                    $this->Html->image('header-menu1.png', array(
                                        'class' => 'Smenu1',
                                        'onmouseover' => "this.src='./images/header-menu1-on.png'",
                                        'onmouseout' => "this.src='./images/header-menu1.png'"
                                    )), array(
                                'controller' => 'Clients',
                                'action' => 'index'
                                    ), array('escape' => false)
                            );
                            ?>
                        </li>
                        <li>
                            <?php
                            echo $this->Html->link(
                                    $this->Html->image('header-menu2.png', array(
                                        'class' => 'Smenu2',
                                        'onmouseover' => "this.src='./images/header-menu2-on.png'",
                                        'onmouseout' => "this.src='./images/header-menu2.png'"
                                    )), array(
                                'controller' => 'User',
                                'action' => 'index'
                                    ), array('escape' => false)
                            );
                            ?>
                        </li>
                        <li>
                            <?php
                            echo $this->Html->link(
                                    $this->Html->image('header-menu3.png', array(
                                        'class' => 'Smenu3',
                                        'onmouseover' => "this.src='./images/header-menu3-on.png'",
                                        'onmouseout' => "this.src='./images/header-menu3.png'"
                                    )), array(
                                'controller' => 'Notice',
                                'action' => 'index'
                                    ), array('escape' => false)
                            );
                            ?>
                        </li>
                        <li class="dropdown">
                            <?php
                            echo $this->Html->link(
                                    $this->Html->image('header-menu4.png', array(
                                        'class' => 'Smenu4',
                                        'onmouseover' => "this.src='./images/header-menu4-on.png'",
                                        'onmouseout' => "this.src='./images/header-menu4.png'"
                                    )), array(
                                'controller' => 'Observation',
                                'action' => 'index'
                                    ), array('escape' => false)
                            );
                            ?>
                        </li>
                        <li>
                            <?php
                            echo $this->Html->link(
                                    $this->Html->image('header-menu5.png', array(
                                        'class' => 'Smenu5',
                                        'onmouseover' => "this.src='./images/header-menu5-on.png'",
                                        'onmouseout' => "this.src='./images/header-menu5.png'"
                                    )), array(
                                'controller' => 'Alert',
                                'action' => 'index'
                                    ), array('escape' => false)
                            );
                            ?>
                        </li>
                        <li>
                            <?php
                            echo $this->Html->link(
                                    $this->Html->image('header-menu6.png', array(
                                        'class' => 'Smenu6',
                                        'onmouseover' => "this.src='./images/header-menu6-on.png'",
                                        'onmouseout' => "this.src='./images/header-menu6.png'"
                                    )), array(
                                'controller' => 'Data',
                                'action' => 'index'
                                    ), array('escape' => false)
                            );
                            ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--メニューバー終了-->
    <?php echo $this->fetch('content'); ?>
    <div id="modal">
        <div id="open01">
            <a href="#" class="close_overlay">×</a>
            <span class="modal_window">
                <h2>確認</h2>
                <p>入力した日付のCSVをダウンロードします。よろしいですか？</p>
                <input type="button" value="はい" onclick="location.href = '#'">
                <input type="button" value="いいえ" onclick="location.href = '#'"><p>
                    <!--/.modal_window-->
                </p></span></div><!--/#open01-->

        <div id="open02">
            <a href="#" class="close_overlay">×</a>
            <span class="modal_window">
                <h2>確認</h2>
                <p>入力した日付の画像をダウンロードします。よろしいですか？</p>
                <input type="button" value="はい" onclick="location.href = '#'">
                <input type="button" value="いいえ" onclick="location.href = '#'"><p>
                    <!--/.modal_window-->
                </p></span></div><!--/#open02--> 
        <!--END-->
        <!--フッター-->
        <div id="footer" class="navbar-fixed-bottom">
            <div class="container"><img src="./images/footer-logo.png" align="left"><span>Copyright ©  Digitaleaf.com All Rights Reserved.</span></div>
        </div>
        <!--フッター終了-->
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>

    </div>
    <!--<p id="footer" class="container">Copyright &copy;  Digitaleaf.com All Rights Reserved.</p>-->
</div>
</div>
</body>
</html>
