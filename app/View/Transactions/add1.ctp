<?php $this->Html->script('novinways.js'.'?v1', array('inline' => false)); ?>
<?php echo $this->Form->create('Transaction',array('class'=>'forms','id'=>'chargeform','url' => array('controller' => 'transactions','action' => 'add'))); ?>
    <fieldset>
        <?php echo $this->Form->input('Transaction.cell_number',array('class'=>'input-large', 'id' => 'CellNumberInput', 'label' => __('Cell Number').' : '));?>
        <?php if(isset($this->request->pass[0]) && !empty($this->request->pass[0])){$operator = $this->request->pass[0] ;}else{$operator = '' ;} ?>
        <?php echo $this->element('ProductsList',array('operator' => $operator)); ?>
        <?php echo $this->element('PaymenstList'); ?>
        <?php echo $this->Form->input('Transaction.email', array('class' => 'input-large', 'id' => 'EmailInput', 'label' => __('Email').' : '));?>
    </fieldset>
<?php
$options = array(
    'label' => '',
    'div' => array(
        'class' => 'submits',
    )
);
echo $this->Form->end($options);
?>