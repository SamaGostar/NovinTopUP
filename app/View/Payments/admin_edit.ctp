 <h2 class="h2title">ويرايش درگاه پرداخت</h2>
        <p class="Tdescrip">برای ويرايش و پيکربندی درگاه پرداخت از اين قسمت اقدام نمائيد.</p>
        <div class="main-box">
<?php echo $this->Form->create('Payment'); ?>
    <fieldset>
        <?php echo $this->Form->input('name',array('class'=>'input-large','label'=>__('Name').' : '));?>
        <?php echo $this->Form->input('data',array('type' => 'textarea'));?>
		<?php echo $this->Form->input('active');?>
    </fieldset>
<?php
$options = array(
    'label' => __('Save'),
    'class' => 'btn btn-danger',
);
echo $this->Form->end($options);
?>
</div>