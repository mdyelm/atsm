<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="ja">
    <head>
        <?php echo $this->Html->charset(); ?>
        <meta name="copyright" content="&copy; digitaleaf">
            <title><?php echo $title_for_layout; ?></title>
    </head>
    <body>
        <?php echo $this->fetch('content'); ?>
    </body>
</html>
