<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ja">
    <head>
        <?php echo $this->Html->charset(); ?>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1"></meta>
         <?php
            echo $this->Html->css(array("bootstrap", "bootswatch", "base"));
            echo $this->fetch('css');
        ?>
        <?php
            echo $this->Html->script(array("jquery-1.11.3.min"));
        ?>
        <title>ATDS</title>
        <style>
            body{
                -ms-autohiding-scrollbar: scrollbar ;
              }
</style>
    </head>
    <body>
        <?php echo $this->fetch('content'); ?>
    </body>
    <style>
        body{background: #fff;}
    </style>
</html>