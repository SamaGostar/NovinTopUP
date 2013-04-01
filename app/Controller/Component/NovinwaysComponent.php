<?php
App::uses('Component', 'Controller');
class NovinwaysComponent extends Component {
	
	public $ErrorCode; 
	
	private $WebServiceUrl = 'http://novinways.com/WebService/wsdl';

	function SetVar($variable,$value){
		$this->{$variable} = $value;
	}

	function Charge(){
		$this->client = new SoapClient($this->WebServiceUrl, array('cache_wsdl' => WSDL_CACHE_NONE));
		$res = $this->client->ReCharge(array('webservice_id' => $this->UserID, 'webservice_pass' => $this->Pass), $this->Amount, $this->Operator, $this->Email, $this->CellNumber, $this->TransID);

		if(isset($res)){
			//$this->ErrorCode = $res;
			if($res < 0){
				$this->ErrorCode = $res -100 ;
				return false ;
			}else{
				$this->ErrorCode = $res +100 ;
				return true ;
			}
		}
		return false;
	}
	
	function GetInfo(){
		$this->client = new SoapClient($this->WebServiceUrl);
		$res = $this->client->CheckCredit(array('webservice_id' => $this->UserID, 'webservice_pass' => $this->Pass));	
		if(isset($res)){
			return $res ;
		}
		return false;	
	}
	
}