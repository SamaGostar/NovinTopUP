<?php $payments = $this->requestAction('/payments/json'); ?>
<?php echo json_encode($payments); ?>