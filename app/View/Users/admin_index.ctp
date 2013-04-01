<?php if(isset($users) && !empty($users)): ?>
 <h2 class="h2title">کاربران</h2>
        <p class="Tdescrip">ليست ساير کاربران دسترسی پيدا کننده به بخش مديريت نرم افزار در اين قسمت قابل مشاهده ميباشد.</p>
        <div class="main-box">
<table class="table table-bordered table-striped">
<thead>
<tr>
<th><?php echo $this->Paginator->sort('User.id','شناسه'); ?></th>
<th><?php echo $this->Paginator->sort('User.name','نام'); ?></th>
<th><?php echo $this->Paginator->sort('User.value','ایمیل'); ?></th>
<th><?php echo $this->Paginator->sort('User.last_login','آخرین ورود'); ?></th>
<th><?php echo $this->Paginator->sort('User.id','ویرایش'); ?></th>
</tr>
</thead>
<tbody>
</tbody>
<?php foreach($users as $user): ?>
<tr>
<th><?php echo $user['User']['id'] ;?></th>
<th><?php echo $user['User']['name'] ;?></th>
<td><?php echo $user['User']['email']; ?></td>
<td><?php echo $user['User']['last_login']; ?></td>
<td><?php //echo $user['User']['id'] ;?>
<?php echo $this->Html->link(__('Edit'),array('controller'=>'users','action'=>'edit',$user['User']['id']), array('class' => 'btn btn-block'));?>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<div class="pagination"><?php echo $this->Paginator->numbers(); ?></div>
</div>
<?php echo $this->Html->link(__('ChangePassword'),array('admin' => true, 'controller' => 'users', 'action' => 'changepass', AuthComponent::user('id')), array('class' => 'btn btn-danger')); ?>
<?php endif; ?>