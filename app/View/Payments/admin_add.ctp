<h2 class="h2title">افزودن درگاه پرداخت</h2>
        <p class="Tdescrip">در اين قسمت امکان مشاهده، ويرايش و پيکربندی درگاه های پرداخت موجود روی سايت وجود دارد.</p>
        <div class="main-box">
<?php echo $this->Form->create('Payment'); ?>
    <fieldset>
        <?php echo $this->Form->input('name',array('class'=>'input-large','label'=>__('Name').' : '));?>
		<?php echo $this->Form->input('psp',array('class'=>'input-large','label'=>__('psp').' : '));?>
		<?php echo $this->Form->input('data',array('class'=>'input-large','label'=>__('data').' : '));?>
		<?php echo $this->Form->input('active',array('class'=>'input-large','label'=>__('active').' : '));?>
    </fieldset>
<?php
$options = array(
    'label' => __('Create'),
    'class' => 'btn btn-danger',
);
echo $this->Form->end($options);
?>
</div>