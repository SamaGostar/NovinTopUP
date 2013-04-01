<?php if(isset($transactions) && !empty($transactions)): ?>
  <div class="span5">
    <table class="table table-bordered table-striped">
<?php foreach($transactions as $transaction): ?>
<tr>
<th>شناسه</th>
<td><?php echo $transaction['Transaction']['id']; ?></td>
</tr>
<tr>
<th>شماره همراه</th>
<td><?php echo $transaction['Transaction']['cell_number']; ?></td>
</tr>
<tr>
<th>ایمیل</th>
<td><?php echo $this->Html->link($transaction['Transaction']['email'],'mailto:'.$transaction['Transaction']['email']); ?></td>
</tr>
<tr>
<th>شارژ</th>
<td><?php echo $transaction['Product']['slug']; ?></td>
</tr>
<tr>
<th>نوع شارژ</th>
<td><?php echo __('Magics'.$transaction['Transaction']['magic']); ?></td>
</tr>
<tr>
<th>اپراتور</th>
<td><?php echo $transaction['Product']['Service']['slug']; ?></td>
</tr>
<tr>
<th>تاریخ</th>
<td>
<?php echo $this->Persiandate->pdate('Y-m-d H:i:s', strtotime($transaction['Transaction']['created'])); ?>
</td>
</tr>
<tr>
<th>آی پی</th>
<td><?php echo $transaction['Transaction']['ip']; ?></td>
</tr>
<tr>
<th>وضعیت</th>
<td><?php echo __('TransactionStatus'.$transaction['Transaction']['status']); ?></td>
</tr>
<tr>
<th>درگاه</th>
<td><?php echo $transaction['Payment']['name']; ?></td>
</tr>
<tr>
<th>مبلغ</th>
<td><?php echo $transaction['Transaction']['amount']; ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
<?php endif; ?>