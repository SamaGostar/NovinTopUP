<?php if(isset($services) && !empty($services)): ?>
 <h2 class="h2title">اپراتور ها</h2>
        <p class="Tdescrip">برای مشاهده سرويس ها از اين قسمت ميتوانيد اقدام نمائيد.</p>
        <div class="main-box">
<table class="table table-bordered table-striped">
<thead>
<tr>
<th><?php echo $this->Paginator->sort('id','شناسه'); ?></th>
<th><?php echo $this->Paginator->sort('Service.slug','عنوان'); ?></th>
<th><?php echo $this->Paginator->sort('Service.active','وضعیت'); ?></th>
<th><?php echo $this->Paginator->sort('Service.id','ویرایش'); ?></th>
</tr>
</thead>
<tbody>
</tbody>
<?php foreach($services as $service): ?>
<tr>
<td><?php echo $service['Service']['id'] ;?></td>
<td><?php echo $service['Service']['slug'] ;?></td>
<td>
<?php echo $this->Charge->actives($service['Service']['active'],$service['Service']['id']); ?>
</td>
<td><?php //echo $service['Service']['id'] ;?>
<?php echo $this->Html->link(__('Edit'),array('controller'=>'services','action'=>'edit',$service['Service']['id']), array('class' => 'btn btn-block'));?>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<div class="pagination"><?php echo $this->Paginator->numbers(); ?></div>
</div>
<?php endif; ?>