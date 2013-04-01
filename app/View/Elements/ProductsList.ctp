<?php if(isset($operator) && !empty($operator)): ?>
<?php $products = $this->requestAction(
    array('controller' => 'products', 'action' => 'index'),
    array('pass' => array($operator))
);?>
<?php else:?>
<?php $products = $this->requestAction('/products/index'); ?>
<?php endif;?>
<?php //$products = $this->requestAction(array('controller' => 'products', 'action' => 'index'),array('return'));?>
<?php echo $this->Form->input('Transaction.product_id',array('options' => $products['product'], 'class'=>'input-medium', 'id' => 'ProductIdInput', 'label'=>__('Charges').' : '));?>
<?php echo $this->Form->hidden('Transaction.operator',array('value' => $products['operator'], 'id' => 'OperatorInput'));?>