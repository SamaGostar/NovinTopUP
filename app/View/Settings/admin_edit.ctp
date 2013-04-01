 <h2 class="h2title">ويرايش تنظيمات</h2>
        <p class="Tdescrip">برای ويرايش تنظيمات از اين قسمت اقدام نمائيد.</p>
        <div class="main-box">
<?php echo $this->Form->create('Setting'); ?>
    <fieldset>
        <?php echo $this->Form->input('value',array('class'=>'input-large','label'=>__($this->request->data['Setting']['name']).' : '));?>
    </fieldset>
<?php
$options = array(
    'label' => __('Save'),
    'class' => 'btn btn-danger',
);
echo $this->Form->end($options);
?>
</div>