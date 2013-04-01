<?php echo $this->Form->create('Product',array('action' => 'view')); ?>
    <fieldset>
        <legend><?php echo __('Sale Product'); ?></legend>
        <?php $opretors = array_keys($products);?>
        <?php foreach($products as $product): ?>
        <?php echo $this->Form->input('product',array('options' => $product));?>
        <?php echo $this->Form->hidden('oprator',array('value' => $opretors[0]));?>
        <?php endforeach; ?>
    </fieldset>
<?php echo $this->Form->end(__('Sale')); ?>