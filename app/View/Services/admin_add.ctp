 <h2 class="h2title">افزودن اپراتور</h2>
        <p class="Tdescrip">برای افزودن سرويس از اين قسمت اقدام نمائيد.</p>
        <div class="main-box">
<?php echo $this->Form->create('Service'); ?>
    <fieldset>
        <?php echo $this->Form->input('slug',array('class'=>'input-large','label'=>__('Operator').' : '));?>
		<?php echo $this->Form->input('active');?>
    </fieldset>
<?php
$options = array(
    'label' => __('Create'),
    'class' => 'btn btn-danger',
);
echo $this->Form->end($options);
?>
</div>