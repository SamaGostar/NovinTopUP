<h2 class="h2title">پیام ها</h2>
<p class="Tdescrip">برای مشاهده تمام پیام های سرويس از اين قسمت ميتوانيد اقدام نمائيد.</p>
<div class="main-box">
<?php if(isset($conferences) && !empty($conferences)): ?>
<table class="table table-bordered table-striped">
<thead>
<tr>
<th><?php echo $this->Paginator->sort('id','شناسه'); ?></th>
<th><?php echo $this->Paginator->sort('Conference.created','تاریخ پیام'); ?></th>
<th><?php echo $this->Paginator->sort('Transaction.conference_status','وضعیت'); ?></th>
<th><?php echo $this->Paginator->sort('Transaction.cell_number','شماره همراه'); ?></th>
<th><?php echo $this->Paginator->sort('Transaction.created','تاریخ تراکنش'); ?></th>
<th><?php echo $this->Paginator->sort('Transaction.id','شماره تراکنش'); ?></th>
</tr>
</thead>
<tbody>
</tbody>
<?php foreach($conferences as $conference): ?>
<tr>
<td>
<?php echo $this->Html->link($conference['Conference']['id'], array('controller'=>'conferences','action'=>'view',$conference['Transaction']['id']), array('class' => 'btn btn-block'));?>
</td>
<td><?php echo $this->Persiandate->pdate('Y-m-d H:i:s', strtotime($conference['Conference']['created'])); ?></td>
<td><?php echo __('ConferenceStatus'.$conference['Transaction']['conference_status']); ?></td>
<td><?php echo $conference['Transaction']['cell_number'] ;?></td>
<td><?php echo $this->Persiandate->pdate('Y-m-d', strtotime($conference['Transaction']['created'])); ?></td>
<td>
<?php echo $this->Html->link($conference['Conference']['transaction_id'],array('controller'=>'transactions','action'=>'view',$conference['Conference']['transaction_id']),array('class' => 'various fancybox.iframe btn btn-block'));?>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<div class="pagination"><?php echo $this->Paginator->numbers(); ?></div>
<?php endif; ?>
</div>