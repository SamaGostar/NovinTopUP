<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo $this->element('metatag'); ?>
<?php echo $this->Html->css('style.css'.'?v6'); ?>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<?php echo $this->Html->script('jquery.inputmask.js'.'?v1'); ?>
<script type="text/javascript">
$(function () {
	$('.Conference .ConferenceBtn').click(function() {
		$(".ConferenceContent").slideToggle(1000);
	});
});
</script>
<?php echo $scripts_for_layout ; ?>
</head>
<body>
 <div class="bgs">
  <div class="Conference">
    <div style="display: none;" class="ConferenceContent">
      <?php echo $this->Form->create('Conference', array('url' => array('controller' => 'conferences', 'action' => 'index'))); ?>
   		<?php echo $this->Form->input('number', array('label' => __('Cell Number'), 'maxlength' => '11', 'class' => 'cntrnu')); ?>
    	<?php echo $this->Form->input('id', array('label' => __('Transaction Id'), 'maxlength' => '15', 'type' => 'text', 'class' => 'cntrid')); ?>
      <?php $options = array('label' => __('Send'),'div' => array('class' => 'cnsubmit')); echo $this->Form->end($options);?>
    </div>
    <div class="ConferenceBtn"><span><?php echo __('Follow My Payment'); ?></span></div>
  </div>
  <div class="main container">
    <div class="box">
      <div class="slider">
      </div>
      <div class="logo">
      </div>
      <div class="operators">
        <a href="#" id="RIGHTELlogo" class="rightellogo operator" >RIGHTEL</a>
        <?php echo $this->Html->link(__('MCI Charge'),array('controller'=>'transactions','action'=>'add','slug'=>'MCI'),array('id'=>'MCIlogo', 'class'=>'mcilogo operator')); ?>
        <?php echo $this->Html->link(__('MTN Charge'),array('controller'=>'transactions','action'=>'add','slug'=>'MTN'),array('id'=>'MTNlogo', 'class'=>'mtnlogo operator')); ?>
      </div>
      <div class="content">
        <?php echo $content_for_layout ?>
      </div>
    </div>
  </div>
 </div>
</body>
</html>