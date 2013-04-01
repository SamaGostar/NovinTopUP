<?php
    if(isset($forms) && !empty($forms)){ 
		echo '<div style="display:none">';
		echo $this->Form->create(null, array('url' => $forms['url'],'id' => 'BankRedirect'));
		if(!empty($forms['params'])){
			foreach($forms['params'] as $ParamName => $ParamValue){
				echo $this->Form->input($ParamName, array('value' => $ParamValue, 'name' => $ParamName, 'type' => 'hidden'));
			}
		}
		echo $this->Form->end('');
		echo '</div>';
	}
?>