<?php App::uses('AppHelper', 'View/Helper'); ?>
<?php class ChargeHelper extends AppHelper {
	public $helpers = array('Html');
	public function status($mode = null){
			switch ($mode) {
              case (null) :
		         return ;
				 break;
              case (0):
		         return $this->Html->image('status-'.$mode.'.png',array('alt'=>__('Status-'.$mode))).'<span> '.__('Status-'.$mode).' </span>';
                 break;
			  case (1):
		         return $this->Html->image('status-'.$mode.'.png',array('alt'=>__('Status-'.$mode))).'<span> '.__('Status-'.$mode).' </span>';
                 break;
			  case (2):
		         return $this->Html->image('status-'.$mode.'.png',array('alt'=>__('Status-'.$mode))).'<span> '.__('Status-'.$mode).' </span>';
                 break;
            }
    }
	
	public function active($mode = null){
			switch ($mode) {
              case (null) :
		         return $this->Html->image('test-fail-icon.png',array('alt'=>__('Not Active')));
				 break;
              case (0):
		         return $this->Html->image('test-fail-icon.png',array('alt'=>__('Not Active')));
                 break;
			  case (1):
		         return $this->Html->image('test-pass-icon.png',array('alt'=>__('Active')));
                 break;
            }
    }

	public function actives($mode = null,$id = null){
			switch ($mode) {
              case (null) :
		         return $this->Html->image('test-fail-icon.png',array('alt'=>__('Not Active'),'url' => array('action' => 'active',$id,1)));
				 break;
              case (0):
		         return $this->Html->image('test-fail-icon.png',array('alt'=>__('Not Active'),'url' => array('action' => 'active',$id,1)));
                 break;
			  case (1):
		         return $this->Html->image('test-pass-icon.png',array('alt'=>__('Active'),'url' => array('action' => 'active',$id,0)));
                 break;
            }
    }	

}
?>