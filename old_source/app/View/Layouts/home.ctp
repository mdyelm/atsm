<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ja">
    <head>
        <?php echo $this->Html->charset(); ?>
        <meta name="copyright" content="&copy; digitaleaf">
        <title><?php echo $title_for_layout; ?></title>
        <?php echo $this->Html->meta('icon'); ?>
        <?php echo $this->fetch('meta'); ?>
        <?php echo $this->Html->css(array("bootstrap", "bootswatch", "base", "home", "lightbox", "jquery.fs.tipper.min")); ?>
        <?php echo $this->fetch('css'); ?>
        <?php echo $this->Html->script(array("jquery-1.11.3", "bootstrap.min", "jquery.fs.tipper.min", "lightbox", "Chart")); ?>
        <?php echo $this->fetch('script'); ?>
    </head>
    <body>
        <div id="container2">
            <!--メニューバー-->
            <div id="head">
                <div class="container s-back">
                    <div class="navbar-header">
                        <?php echo $this->Html->link($this->Html->image("logos/header_s.png"), array("controller" => "Observations", "action" => "index"), array("escape" => false, "class" => "navbar-brand title-font")) ?>
                    </div>
                    <div class="navbar-collapse collapse" id="navbar-main">
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <?php echo $this->Html->link($this->Html->image('contents/menu1.png', array('id' => 'Smenu1')), array('controller' => 'Clients', "action" => "index"), array('escape' => false, "alt" => "クライアント管理")); ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link($this->Html->image('contents/menu2.png', array('id' => 'Smenu2')), array('controller' => 'Users', "action" => "index"), array('escape' => false, "alt" => "担当者管理")); ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link($this->Html->image('contents/menu3.png', array('id' => 'Smenu3')), array('controller' => 'Notifications', "action" => "index"), array('escape' => false, "alt" => "通知先管理")); ?>
                            </li>
                            <li class="dropdown">
                                <?php echo $this->Html->link($this->Html->image('contents/menu4.png', array('id' => 'Smenu4')), array('controller' => 'Observations', "action" => "index"), array('escape' => false, "alt" => "観測状況管理")); ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link($this->Html->image('contents/menu5.png', array('id' => 'Smenu5')), array('controller' => 'Alerts', "action" => "index"), array('escape' => false, "alt" => "アラート管理")); ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link($this->Html->image('contents/menu6.png', array('id' => 'Smenu6')), array('controller' => 'Datas', "action" => "index"), array('escape' => false, "alt" => "データ出力")); ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id="main2">
                <?php echo $this->Element("title"); ?>
                <!--メニューバー終了-->
                <?php echo $this->fetch('content'); ?>
                <div style="clear:both"></div>
            </div>
            <!--フッター-->
            <div id="footer2">
                <div class="container">
                    <?php echo $this->Html->image("logos/footer.png", array("align" => "left")) ?>
                    <span>Copyright ©  Digitaleaf.com All Rights Reserved.</span>
                </div>
            </div>
        </div>
        <!--フッター終了-->
        <?php echo $this->fetch("viewscript") ?>
        <script>
            $(document).ready(function () {
                $("#Smenu1").hover(function () {
                    $(this).attr("src", "<?php echo Router::url('/images/contents/menu1_on.png') ?>");
                }, function () {
                    $(this).attr("src", "<?php echo Router::url('/images/contents/menu1.png') ?>");
                });
                $("#Smenu2").hover(function () {
                    $(this).attr("src", "<?php echo Router::url('/images/contents/menu2_on.png') ?>");
                }, function () {
                    $(this).attr("src", "<?php echo Router::url('/images/contents/menu2.png') ?>");
                });
                $("#Smenu3").hover(function () {
                    $(this).attr("src", "<?php echo Router::url('/images/contents/menu3_on.png') ?>");
                }, function () {
                    $(this).attr("src", "<?php echo Router::url('/images/contents/menu3.png') ?>");
                });
                $("#Smenu4").hover(function () {
                    $(this).attr("src", "<?php echo Router::url('/images/contents/menu4_on.png') ?>");
                }, function () {
                    $(this).attr("src", "<?php echo Router::url('/images/contents/menu4.png') ?>");
                });
                $("#Smenu5").hover(function () {
                    $(this).attr("src", "<?php echo Router::url('/images/contents/menu5_on.png') ?>");
                }, function () {
                    $(this).attr("src", "<?php echo Router::url('/images/contents/menu5.png') ?>");
                });
                $("#Smenu6").hover(function () {
                    $(this).attr("src", "<?php echo Router::url('/images/contents/menu6_on.png') ?>");
                }, function () {
                    $(this).attr("src", "<?php echo Router::url('/images/contents/menu6.png') ?>");
                });
            });
        </script>
    </body>
</html>
