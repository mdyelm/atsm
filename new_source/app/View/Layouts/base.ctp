<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
    <body>
        <!--メニューバー-->
        <div id="head">
            <div class="container s-back">
                <div class="navbar-header">

                    <?php
                        echo $this->Html->link(
                            $this->Html->image("/images/S-logo.png", array("class" => "logo", "alt"=>"logo")),
                            array(
                                'controller' => 'Monitoring',
                                'action' => 'index'
                                
                            ),
                            array('class' => 'navbar-brand title-font','escape' => false)
                        );
                    ?>
                </div>
                <div class="navbar-collapse collapse" id="navbar-main">
                    <ul class="nav navbar-nav navbar-right newUlMenu">
                        <?php if($userRole['role'] == 0): ?>
                        <li>
                            <?php
                                echo $this->Html->link(
                                    '組織管理',
                                    array(
                                        'controller' => 'Organizations',
                                        'action' => 'index'
                                    ),
                                    array('class' => 'newTextMenu')
                                );
                            ?>
                        </li>
                        <?php endif; ?>
                        <li>
                            <?php
                                echo $this->Html->link(
                                    '担当者管理',
                                    array(
                                        'controller' => 'Users',
                                        'action' => 'index'
                                    ),
                                    array('class' => 'newTextMenu')
                                );
                            ?>
                        </li>
                        <li>
                            <?php
                                echo $this->Html->link(
                                    'ユニット端末管理',
                                    array(
                                        'controller' => 'Units',
                                        'action' => 'index'
                                    ),
                                    array('class' => 'newTextMenu')
                                );
                            ?>
                        </li>
                        <li>
                            <?php
                                echo $this->Html->link(
                                    '監視状況管理',
                                    array(
                                        'controller' => 'Monitoring',
                                        'action' => 'index'
                                    ),
                                    array('class' => 'newTextMenu')
                                );
                            ?>
                        </li>
                        <li class="lastLi">
                            <?php
                                echo $this->Html->link(
                                    'データ出力',
                                    array(
                                        'controller' => 'Datas',
                                        'action' => 'index'
                                    ),
                                    array('class' => 'newTextMenu')
                                );
                            ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--メニューバー終了-->

        <!--メインコンテンツ-->
        <div class="container backWhite">
            <div id="title">
                <?php echo $this->Html->image("/images/camera.png") ?>
                <span><?php echo $title_for_layout; ?></span>
                <?php
                    echo $this->Html->image("/images/btn_out_off3.png", array(
                        "alt" => "ログアウト",
                        "class" => "logout",
                        "align" => "right",
                        'url' => array('controller' => 'auth', 'action' => 'logout')
                    ));
                ?>
                <span class="newSpanInfo">
                    組織:
                    <span class="w100">
                        <?php if($userRole['role'] == 0): ?>
                            <?php echo h('管理者DL'); ?> 
                        <?php else: ?>
                        <?php if(isset($userRole['organization_name'])){
                                echo h($userRole['organization_name']);
                        } ?>
                        <?php endif; ?>
                    </span> 
                    システム権限:
                        <span class="w100">
                            <?php if($userRole['role'] == 0): ?>
                                <?php echo h('DL管理者'); ?> 
                            <?php else: ?>
                            <?php if(isset($userRole['role']) && isset(Configure::read('User.role')[$userRole['role']])){
                                echo h(Configure::read('User.role')[$userRole['role']]);
                            } ?>
                            <?php endif; ?>
                        </span>
                </span>
            </div>
            <?php echo $this->fetch('content'); ?>
        </div>
        <!--メインコンテンツ終了-->
        <!--フッター-->
        <div id="footer">
            <div class="container"><?php echo $this->Html->image("/images/footer-logo.png", array("class" => "logo","align"=>"left")) ?><span>Copyright &copy;  Digitaleaf.com All Rights Reserved.</span></div>
        </div>
        <!--フッター終了-->
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <?php
            echo $this->Html->script(array("jquery-1.11.3.min", "bootstrap.min"));
            echo $this->fetch('script');
            echo $this->fetch("viewscript");
        ?>
        <script>
            $(document).ready(function () {
                $(".logout").hover(function () {
                    $(this).attr("src", "<?php echo Router::url('/images/btn_out_on3.png') ?>");
                }, function () {
                    $(this).attr("src", "<?php echo Router::url('/images/btn_out_off3.png') ?>");
                });
            });
        </script>
    </body>
</html>