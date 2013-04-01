 <h2 class="h2title">افزودن محصول</h2>
        <p class="Tdescrip">از اين صفحه امکان افزودن محصول وجود دارد.</p>
        <div class="main-box">
<?php echo $this->Form->create('Product'); ?>
    <fieldset>
        <?php echo $this->Form->input('slug',array('class'=>'input-large','label'=>__('Slug').' : '));?>
        <?php echo $this->Form->input('description',array('class'=>'input-large','label'=>__('Description').' : '));?>
        <?php echo $this->Form->input('price',array('class'=>'input-large','label'=>__('Price').' : '));?>
        <?php echo $this->Form->input('service_id',array('class'=>'input-large','label'=>__('Services').' : '));?>
        <?php echo $this->Form->input('active',array('label'=>__('Active').' : '));?>
    </fieldset>
<?php
$options = array(
    'label' => __('Create'),
    'class' => 'btn btn-danger',
);
echo $this->Form->end($options);
?>
</div>