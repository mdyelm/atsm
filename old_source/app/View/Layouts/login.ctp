<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <?php
        echo $this->Html->charset();
        echo $this->fetch('meta');
        echo $this->Html->css(array("bootstrap", "bootswatch", "base", "login"));
        echo $this->fetch('css');
        echo $this->Html->script(array("jquery.min.js", "common.js"));
        echo $this->fetch('script');
        ?>
        <title>4Kカメラ災害監視システム</title>
        <!--[if lt IE 9]>
        <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>

    <body style="background:#6880A5; padding-top:0px;">
        <!--メインコンテンツ-->
        <div class="bs-docs-section">
            <div class="login_main_contents">
                <?php echo $this->Html->image("contents/login.png", array("class" => "login_title")) ?>
                <?php echo $this->Html->image("bars/login.png", array("class" => "login_bar")) ?>
                <div class="contents">
                    <?php echo $this->fetch('content'); ?>
                </div>
                <p class="copyright">Copyright © Digitaleaf.com All Rights Reserved</p>
            </div>
        </div>
        <!--メインコンテンツ終了-->
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>

    </body>
</html>
