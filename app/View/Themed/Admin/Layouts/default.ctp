<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->element('metatag'); ?>
<?php echo $this->Html->css('bootstrap.min.css'.'?v1'); ?>
<?php echo $this->Html->css('style.css'.'?v4'); ?>
<?php echo $this->Html->css('jquery.fancybox.css'.'?v=2.1.4'); ?>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<?php echo $this->Html->script('jquery.fancybox.pack.js'.'?v=2.1.4'); ?>
<script type="text/javascript">
	$(document).ready(function() {
	$(".various").fancybox({
		maxWidth	: 600,
		maxHeight	: 500,
		fitToView	: false,
		width		: 420,
		height		: 430,
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none'
	});
});
</script>
<?php echo $scripts_for_layout ; ?>
</head>
<body>
  <div class="container">
    <div class="row header">
      <div class="span3">
        <span class="logo"></span>
        <small class="description">مدیریت سامانه فروش کارت شارژ</small>
      </div>
      <div class="span9">
      <?php if($this->params['controller'] == 'transactions' && $this->params['action'] == 'admin_stat'){
		  		Cache::delete('element__novincredit_cache');
	  		}
			echo $this->element('novincredit', array(), array('cache' => array('config' => 'default','time' => '+5 minutes')));
	  ?>
      </div>
	      <script type="text/javascript">
			 $(document).ready(function(){
				function callStatus() {
				$.getJSON("<?php echo Configure::read('Config.SiteUrl').'conferences/status'; ?>", function(data) {
				if(data.length > 0 ){
					if($('div.btns').length){
						$('div.btns').remove();
					}
					var items = [];
					$.each(data, function(key, val) {
					items.push('<a href="<?php echo Configure::read('Config.SiteUrl').'admin/conferences/all/'; ?>' + val.status + '" class="label"> '+ val.title +' (' + val.count + ') </a>');
				});
				$('<div/>', {
					'class': 'btns',
					html: items.join('')
					}).appendTo('.btnn');
				}
			 	});
			   }
				callStatus();
				setInterval(callStatus,40000);
			 });
			</script>
			<div class="span4 btnn pull-left">
           		<?php echo $this->Html->link('تیکت ها : ', array('controller' => 'conferences', 'action' => 'all'), array('class' => 'label pull-right')); ?>
			</div>
    </div>
    <hr />
    <div class="row">
      <div class="span3">
        <div class="users">
        <?php echo $this->Html->Image('admin-icon.png',array('width'=>'60px','height'=>'60px','class'=>'admin-avatar pull-right'));?>
          <strong>سلام <?php echo $this->Session->read('Auth.User.name'); ?></strong>
          <small>خوش آمدی !</small>
          <?php echo $this->Html->link('مشاهده سایت',Router::url('/', true),array('class'=>'label label-important')); ?>
          <?php echo $this->Html->link(__('Logout'),array('controller'=>'users','action'=>'logout','admin'=>false),array('class'=>'label label-important')); ?> 
        </div>
        <div class="menu">
           <?php echo $this->element('adminmenu'); ?>
        </div>
      </div>
      <div class="span9">
        <?php echo $this->Session->flash('admin'); ?>
        <?php echo $content_for_layout ?>
        <div class="span8">
          <p class="samanlink"> نسخه 1.0.3 - طراحی و توسعه : <a href="http://www.samansystems.com/">سامان سيستم پرداز کيش</a></p>
        </div>
      </div>
    </div>
  </div>
</body>
</html>