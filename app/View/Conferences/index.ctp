<div class="conference">
<?php if(isset($transactions) && !empty($transactions)): ?>
<div class="alert transdetail">
<?php foreach($transactions as $transaction): ?>
<label>شناسه پرداخت : </label><p><?php echo $transaction['id']; ?></p>
<label>شماره همراه : </label><p><?php echo $transaction['cell_number']; ?></p>
<label>مبلغ پرداخت شده :</label><p><?php echo $transaction['amount']; ?></p>
<label>نوع شارژ :</label><p><?php echo __('Magics'.$transaction['magic']); ?></p>
<label>تاریخ پرداخت : </label><p><?php echo $this->Persiandate->pdate('Y-m-d H:i:s', strtotime($transaction['created'])); ?></p>
<label>وضیعیت : </label><p><?php echo __('TransactionStatus'.$transaction['status']); ?></p>
<label>وضعیت بررسی : </label><p><?php echo __('ConferenceStatus'.$transaction['conference_status']); ?></p>
<?php endforeach; ?>
</div>
<?php if(isset($conferences) && !empty($conferences)): ?>
<?php foreach($conferences as $conference): ?>
<?php if(!empty($conference['User']['name'])){
		 echo '<div class="alert alert-admin">';
		 echo '<strong>'.$conference['User']['name'].'</strong>';
	  }else{
	     echo '<div class="alert alert-gray conferences">' ;
	     echo '<strong>'.__('Buyer').'</strong>';
	  } ?>
<small><?php echo $this->Persiandate->pdate('Y-m-d H:i:s', strtotime($conference['Conference']['created'])); ?></small>
<p><?php echo $conference['Conference']['message']; ?></p>
</div>
<?php endforeach; ?>
<?php endif; ?>
<?php echo $this->Form->create('Conference',array('class' => 'cnforms')); ?>
        <?php echo $this->Form->input('message',array('class'=>'cnmessage input-large','label' => __('message')));?>
<?php
$options = array(
    'label' => __('Send'),
    'class' => 'btn btn-danger',
);
echo $this->Form->end($options);
?>
<?php endif; ?>
</div>