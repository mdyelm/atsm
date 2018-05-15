<!DOCTYPE html>
<html lang="ja">
    <head>
        <title>ATDS</title>

        <?php
        echo $this->Html->charset();
        echo $this->fetch('meta');
        echo $this->Html->css(array("bootstrap", "bootswatch", "base"));
        echo $this->fetch('css');
        ?>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <!--*<body style="background:#5473A1;">-->
    <body style="background:#6880A5; padding-top:0px;">
        <!--メインコンテンツ-->
        <div class="bs-docs-section br-margin-login">
            <div class="maincontents">
                <p class="logintitle">盗難自動検知システム</p>
                <?php echo $this->fetch('content'); ?>
            </div>
        </div>
        <!--メインコンテンツ終了-->
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <?php
        echo $this->Html->script(array("jquery-1.11.3.min.js", "bootstrap.min.js"));
        echo $this->fetch('script');
        echo $this->fetch("viewscript");
        ?>
        <script>
            $('.loginbutton,.submitForget').click(function () {
                $('#idLoginUser').submit();
            });
            $('.clearbutton').click(function () {
                $('#UserUserId').val('');
                $('#UserLoginPw').val('');
            });
        </script>
    </body>
</html>