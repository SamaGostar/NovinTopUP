<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->element('metatag'); ?>
<?php echo $this->Html->css('bootstrap.min.css'.'?v1'); ?>
<?php echo $this->Html->css('style.css'.'?v3'); ?>
<?php echo $this->Html->css('jquery.fancybox.css'.'?v=2.1.4'); ?>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<?php echo $scripts_for_layout ; ?>
</head>
<body>
      <div class="content">
        <?php echo $content_for_layout ?>
      </div>
</body>
</html>