<?php if(isset($transactions) && !empty($transactions)): ?>
 <h2 class="h2title">تراکنش ها</h2>
        <p class="Tdescrip">در این قسمت می توانید تراکنش های روزانه را رصد کنید و پاسخگوی کاربرانی باشید که احتمالا با مشکل مواجه شده اند .</p>
        <div class="main-box">
<table class="table table-bordered table-striped">
<thead>
<tr>
<th><?php echo $this->Paginator->sort('id','شناسه'); ?></th>
<th><?php echo $this->Paginator->sort('Product.slug','شارژ'); ?></th>
<th><?php echo $this->Paginator->sort('Transaction.cell_number','شماره همراه'); ?></th>
<th><?php echo $this->Paginator->sort('Transaction.created','تاریخ'); ?></th>
<th><?php echo $this->Paginator->sort('Transaction.status','وضعیت'); ?></th>
<th><?php echo $this->Paginator->sort('Payment.name','درگاه'); ?></th>
<th><?php echo $this->Paginator->sort('Transaction.price','مبلغ'); ?></th>
</tr>
</thead>
<tbody>
</tbody>
<?php foreach($transactions as $transaction): ?>
<tr>
<td>
<?php echo $this->Html->link($transaction['Transaction']['id'],array('controller'=>'transactions','action'=>'view',$transaction['Transaction']['id']),array('class' => 'various fancybox.iframe btn btn-block'));?>
</td>
<td><?php echo $transaction['Product']['slug'] ;?></td>
<td><?php echo $transaction['Transaction']['cell_number'] ;?></td>
<td>
<?php echo $this->Persiandate->pdate('Y-m-d H:i:s', strtotime($transaction['Transaction']['created'])); ?>
</td>
<td>
<?php 
	echo __('TransactionStatus'.$transaction['Transaction']['status']);
	if($transaction['Transaction']['status'] == 200){ 
		echo $this->Html->link($this->Html->image('test-skip-icon.png'), array('admin' => true, 'controller' => 'transactions', 'action' => 'manualverify', $transaction['Transaction']['id']),array('class' => 'pull-left', 'escape' => false), "آیا می خواهید شارژ مجدد انجام شود ؟");
	}
?>
</td>
<td><?php echo $transaction['Payment']['name'] ;?></td>
<td><?php echo $transaction['Transaction']['amount'] ;?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<div class="pagination"><?php echo $this->Paginator->numbers(); ?></div>
</div>
<?php endif; ?>