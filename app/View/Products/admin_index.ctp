<?php if(isset($products) && !empty($products)): ?>
 <h2 class="h2title">محصولات</h2>
        <p class="Tdescrip">ليست ساير محصولات از اين قسمت قابل مشاهده ميباشد. امکان مشاهده وضعيت و ويرايش جزئيات نيز وجود دارد.</p>
        <div class="main-box">
<table class="table table-bordered table-striped">
<thead>
<tr>
<th><?php echo $this->Paginator->sort('id','شناسه'); ?></th>
<th><?php echo $this->Paginator->sort('Product.slug','عنوان'); ?></th>
<th><?php echo $this->Paginator->sort('Product.description','توضیحات'); ?></th>
<th><?php echo $this->Paginator->sort('Product.price','قیمت'); ?></th>
<th><?php echo $this->Paginator->sort('Product.service_id','اپراتور'); ?></th>
<th><?php echo $this->Paginator->sort('Product.active','وضعیت'); ?></th>
<th><?php echo $this->Paginator->sort('Product.id','ویرایش'); ?></th>
</tr>
</thead>
<tbody>
</tbody>
<?php foreach($products as $product): ?>
<tr>
<td><?php echo $product['Product']['id'] ;?></td>
<td><?php echo $product['Product']['slug'] ;?></td>
<td><?php echo $product['Product']['description'] ;?></td>
<td><?php echo $product['Product']['price'] ;?></td>
<td><?php echo __($product['Service']['slug']) ;?></td>
<td>
<?php echo $this->Charge->actives($product['Product']['active'],$product['Product']['id']); ?>
</td>
<td><?php //echo $product['Product']['id'] ;?>
<?php echo $this->Html->link(__('Edit'),array('controller'=>'products','action'=>'edit',$product['Product']['id']),array('class' => 'btn btn-block'));?>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<div class="pagination"><?php echo $this->Paginator->numbers(); ?></div>
</div>
<?php endif; ?>