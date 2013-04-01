<?php if(isset($payments) && !empty($payments)): ?>
 <h2 class="h2title">درگاه های پرداخت</h2>
        <p class="Tdescrip">در اين قسمت امکان مشاهده، ويرايش و پيکربندی درگاه های پرداخت موجود روی سايت وجود دارد.</p>
        <div class="main-box">
<table class="table table-bordered table-striped">
<thead>
<tr>
<th><?php echo $this->Paginator->sort('id','شناسه'); ?></th>
<th><?php echo $this->Paginator->sort('Payment.name','عنوان'); ?></th>
<th><?php echo $this->Paginator->sort('Payment.psp','اپراتور'); ?></th>
<th><?php echo $this->Paginator->sort('Payment.active','وضعیت'); ?></th>
<th><?php echo $this->Paginator->sort('Payment.id','ویرایش'); ?></th>

</tr>
</thead>
<tbody>
</tbody>
<?php foreach($payments as $payment): ?>
<tr>
<td><?php echo $payment['Payment']['id'] ;?></td>
<td><?php echo $payment['Payment']['name'] ;?></td>
<td><?php echo $payment['Payment']['psp'] ;?></td>
<td>
<?php echo $this->Charge->actives($payment['Payment']['active'],$payment['Payment']['id']); ?>
</td>
<td><?php //echo $payment['Payment']['id'] ;?>
<?php echo $this->Html->link(__('Edit'),array('controller'=>'payments','action'=>'edit',$payment['Payment']['id']), array('class' => 'btn btn-block'));?>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php echo $this->Paginator->numbers(); ?>
</div>
<?php endif; ?>