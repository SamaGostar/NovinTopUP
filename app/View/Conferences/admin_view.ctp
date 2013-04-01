 <h2 class="h2title">پیام ها</h2>
        <p class="Tdescrip">برای مشاهده پیام های سرويس از اين قسمت ميتوانيد اقدام نمائيد.</p>
        <div class="main-box">
<?php if(isset($transactions) && !empty($transactions)): ?>
<div class="alert alert-success transdetail">
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
<?php endif; ?>

<?php if(isset($conferences) && !empty($conferences)): ?>
<?php foreach($conferences as $conference): ?>
<?php if(!empty($conference['User']['name'])){
		if($conference['Conference']['note'] == 0){
		    echo '<div class="alert alert-info conferences">';
		    echo '<h4>'.$conference['User']['name'].'</h4>';
		}else{
		    echo '<div class="alert alert-error conferences">';
		    echo '<h4>'.$conference['User']['name'].'</h4>';
		}
	  }else{
	     echo '<div class="alert alert-gray conferences">' ;
	     echo '<h4>'.__('Buyer').'</h4>';
	  } ?>
<small><?php echo $this->Persiandate->pdate('Y-m-d H:i:s', strtotime($conference['Conference']['created'])); ?></small>
<p><?php echo $conference['Conference']['message']; ?></p>
</div>
<?php endforeach; ?>
<?php endif; ?>
<?php echo $this->Form->create('Conference',array('class' => 'cnforms')); ?>
        <?php echo $this->Form->input('message',array('class'=>'cnmessage input-xxlarge','label' => __('message')));?>
        <?php echo $this->Form->input('note',array('class'=>'input-large','label' => __('note')));?>
        <?php $status = array(1 => __('ConferenceStatus1'), 2 => __('ConferenceStatus2'), 3 => __('ConferenceStatus3'), 4 => __('ConferenceStatus4')); ?>
        <?php echo $this->Form->input('status',array('label' => __('status'),'options' => $status, 'default' => 2)); ?>
<?php
$options = array(
    'label' => __('Send'),
    'class' => 'btn btn-danger',
);
echo $this->Form->end($options);
?>
</div>
</div>