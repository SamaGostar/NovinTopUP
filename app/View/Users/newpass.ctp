<div class="login form">
<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Form->create('User',array('url' => array('controller' => 'users' , 'action' => 'newpass',$this->request->pass[0],$this->request->pass[1]))); ?>
    <fieldset>
        <legend><?php echo __('Please enter your username and password'); ?></legend>
        <?php
              echo $this->Form->input('password');
			  echo $this->Form->input('confpass',array('type' => 'password', 'label' => __('Confirm Password')));
        ?>
    </fieldset>
<?php echo $this->Form->end(__('Save')); ?>
</div>