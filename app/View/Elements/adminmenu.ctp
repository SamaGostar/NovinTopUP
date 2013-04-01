<ul>
<li><?php echo $this->Html->link(' <i class="icon-home"></i> '.__('Home Page'),array('controller'=>'transactions','action'=>'stat','admin'=>true),array('escape'=>false)); ?></li>
<li><?php echo $this->Html->link(' <i class="icon-tasks"></i> '.__('Transactions'),array('controller'=>'transactions','action'=>'index','admin'=>true),array('escape'=>false)); ?></li>
<li><?php echo $this->Html->link(' <i class="icon-comment"></i> '.__('Conferences'),array('controller'=>'conferences','action'=>'index','admin'=>true),array('escape'=>false)); ?></li>
<li><?php echo $this->Html->link(' <i class="icon-wrench"></i> '.__('Payments'),array('controller'=>'payments','action'=>'index','admin'=>true),array('escape'=>false)); ?></li>
<li><?php echo $this->Html->link(' <i class="icon-gift"></i> '.__('Products'),array('controller'=>'products','action'=>'index','admin'=>true),array('escape'=>false)); ?></li>
<li><?php echo $this->Html->link(' <i class="icon-shopping-cart"></i> '.__('Services'),array('controller'=>'services','action'=>'index','admin'=>true),array('escape'=>false)); ?></li>
<li><?php echo $this->Html->link(' <i class="icon-wrench"></i> '.__('Settings'),array('controller'=>'settings','action'=>'index','admin'=>true),array('escape'=>false)); ?></li>
<li><?php echo $this->Html->link(' <i class="icon-user"></i> '.__('Users'),array('controller'=>'users','action'=>'index','admin'=>true),array('escape'=>false)); ?></li>
</ul>