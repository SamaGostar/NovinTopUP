<h2 class="h2title">اصلاح رمز عبور</h2>
        <p class="Tdescrip"> در این بخش می توانید رمز عبور و یا password خود را عوض کنید .</p>
        <div class="main-box">
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <?php echo $this->Form->input('old_password',array('class' => 'input-large', 'type' => 'password', 'label' => __('Old Password').' : '));?>
        <?php echo $this->Form->input('password',array('class' => 'input-large', 'label' => __('New password').' : '));?>
        <?php echo $this->Form->input('confrim_password',array('class' => 'input-large', 'type' => 'password', 'label' => __('Confrim Password').' : '));?>
    </fieldset>
<?php
$options = array(
    'label' => __('Save'),
    'class' => 'btn btn-danger',
);
echo $this->Form->end($options);
?>
</div>