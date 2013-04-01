<?php echo $this->Session->flash('charge'); ?>
<?php if(!empty($trans['refid'])): ?>
<div class="alert alert-success">
<p>شارژ شما با موفقیت انجام شده و تا چند لحظه دیگر خط شما به صورت مستقیم شارژ می شود .</p>
</div>
<div class="verify">
<div class="verifys"><label>شناسه پرداخت : </label><p><?php echo $trans['id'] ; ?></p></div>
<div class="verifys"><label>شماره تراکنش بانکی : </label><p><?php echo $trans['refid'] ; ?></p></div>
</div>
<?php elseif(!empty($trans['cellnumber'])): ?>
<?php echo $this->Html->link(__('Follow My Payment'),array('controller' => 'conferences', 'action' => 'index',$trans['id'] ,$trans['cellnumber']),array('class' => 'verifybtn')); ?>
<?php endif; ?>