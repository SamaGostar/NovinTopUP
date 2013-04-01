<?php
	$user = AuthComponent::user('id') ;
	if(!empty($user)){
		$NovinResponse = $this->requestAction('/transactions/novincredit');
		echo '<span class="novincredit"> اعتبار باقی مانده شما در سامانه نوین '.$NovinResponse.' تومان ميباشد. ('.date('h:m:s').') </span>';
	}
?>