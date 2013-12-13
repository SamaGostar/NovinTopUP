<?php
App::uses('Component', 'Controller');
class NovinwaysComponent extends Component {
	
	public $ErrorCode; 
	
	private $WebServiceUrl = 'http://www.novinways.com/services/ChargeBox/wsdl';

	function SetVar($variable,$value){
		$this->{$variable} = $value;
	}

	function Charge(){
		$this->client = new SoapClient($this->WebServiceUrl);
		$res = $this->client->ReCharge(
			array(
				'Auth' => array('WebserviceId' => $this->UserID, 'WebservicePassword' => $this->Pass),
				'Amount' => $this->Amount,
				'Type' => $this->Operator,
				'Account' => $this->CellNumber,
				'ReqId' => $this->TransID
			)
		);
		
		if(isset($res)){
			//$this->ErrorCode = $res;
			if($res->Status < 0){
				$this->ErrorCode = $res->Status -100 ;
				return false ;
			}else{
				$this->ErrorCode = $res->Status +100 ;
				return true ;
			}
		}
		return false;
	}
	
	function GetInfo(){
		$this->client = new SoapClient($this->WebServiceUrl);
		$res = $this->client->CheckCredit(array('Auth' => array('WebserviceId' => $this->UserID, 'WebservicePassword' => $this->Pass)));
		if(isset($res) && $res->Status == 100){
			return $res->Credit;
		}
		return false;	
	}
	
}
