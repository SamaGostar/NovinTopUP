<?php
    if(isset($forms) && !empty($forms)){ 
		echo $this->Form->create(null, array('class'=>'forms', 'id'=>'chargeform', 'url' => $forms['url'],'id' => 'BankRedirect'));
			if(!empty($forms['params'])){
				foreach($forms['params'] as $ParamName => $ParamValue){
					echo $this->Form->input($ParamName, array('value' => $ParamValue, 'name' => $ParamName, 'type' => 'hidden'));
				}
			}
		$options = array(
    		'label' => 'انتقال به درگاه پرداخت',
    		'div' => array('class' => 'banksubmits')
		);
		echo $this->Form->end($options);
	}
?>