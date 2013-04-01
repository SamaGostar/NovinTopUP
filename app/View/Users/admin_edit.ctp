<h2 class="h2title">ويرايش کاربر</h2>
        <p class="Tdescrip">امکان ويرايش اطلاعات کاربر در اين قسمت وجود دارد.</p>
        <div class="main-box">
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <?php echo $this->Form->input('name',array('class' => 'input-large', 'label' => __('Name').' : '));?>
        <?php echo $this->Form->input('email',array('class' => 'input-large', 'label' => __('Email').' : '));?>
        <?php //echo $this->Form->input('old_password',array('class' => 'input-large', 'type' => 'password', 'label' => __('Old Password').' : '));?>
        <?php //echo $this->Form->input('password',array('class' => 'input-large', 'label' => __('New password').' : '));?>
        <?php //echo $this->Form->input('confrim_password',array('class' => 'input-large', 'type' => 'password', 'label' => __('Confrim Password').' : '));?>
    </fieldset>
<?php
$options = array(
    'label' => __('Save'),
    'class' => 'btn btn-danger',
);
echo $this->Form->end($options);
?>
</div>