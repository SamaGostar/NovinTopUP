<div class="login form">
<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Please enter your username and password'); ?></legend>
        <?php echo $this->Form->input('email');
        ?>
    </fieldset>
<?php echo $this->Form->end(__('Send')); ?>
</div>