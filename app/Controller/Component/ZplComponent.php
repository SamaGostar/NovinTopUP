<?php
App::uses('Component', 'Controller');
 class ZplComponent extends Component {

	private $site = '';
	private $amount;
	private $user_id;
	private $pin = '';
	private $payment_id = 0;
	private $callBackUrl ;
	public $Authority ;
	public $ErrorCode ;
	public $BankForm ;
	
	function __construct() {
		$this->callBackUrl = Router::url('/', true)."transactions/verify/zpl";
    }
	
	function SetVar($variable,$value){
		$this->{$variable} = $value;
	}
	
	function Execute(){
		$this->client = new SoapClient('http://www.zarinpal.com/WebserviceGateway/wsdl', array('encoding' => 'UTF-8'));
		$res = $this->client->PaymentRequest($this->merchantID, intval($this->amount), $this->callBackUrl, urlencode($this->desc));

		if(strlen($res) == 36){
			$this->Authority = $res;
			$this->BankForm['url'] = 'https://www.zarinpal.com/users/pay_invoice/'. $this->Authority ;
			$this->ErrorCode = 200 ;
			return true;
		}else{
			if($res < 0){
				$this->ErrorCode = $res - 200 ;
			}else{
				$this->ErrorCode = $res + 220 ;
			}
		    return true;
		}
		return false;
	}
	
	function Dispatch(){
		if(isset($_GET['au']) && strlen($_GET['au']) == 36){
		    $this->Authority = $_GET['au'];
			return true ;
	    }
		return false;
	}
	
	function Verify(){
		$this->client = new SoapClient('http://www.zarinpal.com/WebserviceGateway/wsdl', array('encoding' => 'UTF-8'));
		$res = $this->client->PaymentVerification($this->merchantID, $this->Authority, $this->Amount);

		if(isset($res) && $res == 1){
			$this->Detail = $_GET['refID'];
			return true;
		}
			return false;
	}
		
	function ManualVerify(){
		$this->client = new SoapClient('http://www.zarinpal.com/WebserviceGateway/wsdl', array('encoding' => 'UTF-8'));
		$res = $this->client->PaymentVerification($this->merchantID, $this->Authority, $this->Amount);

		if(isset($res) && $res == 1){
			$this->Detail = '' ;
			return true;
		}
			return false;
	}
}