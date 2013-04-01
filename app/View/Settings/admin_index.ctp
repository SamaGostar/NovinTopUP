<?php if(isset($settings) && !empty($settings)): ?>
 <h2 class="h2title">تنظيمات</h2>
        <p class="Tdescrip">برای مشاهده ساير تنظيمات از اين قسمت اقدام نمائيد. همچنين امکان پيکربندی تنظيمات نيز وجود دارد.</p>
        <div class="main-box">
<table class="table table-bordered table-striped">
<thead>
<tr>
<th><?php echo $this->Paginator->sort('Setting.name','عنوان'); ?></th>
<th><?php echo $this->Paginator->sort('Setting.value','مقدار'); ?></th>
<th><?php echo $this->Paginator->sort('Setting.id','ویرایش'); ?></th>
</tr>
</thead>
<tbody>
</tbody>
<?php foreach($settings as $setting): ?>
<tr>
<th><?php echo __($setting['Setting']['name']) ;?></th>
<td><?php echo $setting['Setting']['value']; ?></td>
<td><?php //echo $setting['Setting']['id'] ;?>
<?php echo $this->Html->link(__('Edit'),array('controller'=>'settings','action'=>'edit',$setting['Setting']['id']), array('class' => 'btn btn-block'));?>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<div class="pagination pagination-small"><ul><?php echo $this->Paginator->numbers(array('tag' => 'li', 'separator' => '', 'currentClass' => 'active', 'currentTag' => 'span')); ?></ul></div>
</div>
<?php endif; ?>