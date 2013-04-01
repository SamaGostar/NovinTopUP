<?php
App::uses('Component', 'Controller');
 class PecComponent extends Component {

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
		$this->callBackUrl = Router::url('/', true)."transactions/verify/pec";
    }
	
	function SetVar($variable,$value){
		$this->{$variable} = $value;
	}
	
	function Execute(){
		$this->client = new SoapClient('https://www.pec24.com/pecpaymentgateway/eshopservice.asmx?wsdl', array('encoding' => 'UTF-8', 'connection_timeout' => 20));
    	$params = array(
                            'pin' => $this->merchantID,
                            'amount' => intval($this->amount),
                            'orderId' => $this->orderID,
                            'callbackUrl' => $this->callBackUrl,
                            'authority' => 0,
                            'status' => 1
                        );
		$res = $this->client->PinPaymentRequest($params);
		if( $res->authority && $res->status == 0 ){
			$this->Authority = $res->authority ;
			$this->BankForm['url'] = 'https://www.pec24.com/pecpaymentgateway/?au='. $this->Authority ;
			$this->ErrorCode = 200 ;
			return true;
		}
		return false;
	}
	
	function Dispatch(){
		if(isset($_GET['au'])){
		    $this->Authority = $_GET['au'];
			return true ;
	    }
		return false;
	}
	
	function Verify(){
		$this->client = new SoapClient('https://www.pec24.com/pecpaymentgateway/eshopservice.asmx?wsdl', array('encoding' => 'UTF-8', 'connection_timeout' => 20));
		$params = array(
                        'pin' => $this->merchantID,
                        'authority' => $this->Authority,
                        'status' => 1,
                        'invoiceNumber' => 0
                );
                
		$res = $this->client->PaymentEnquiry($params);
		if($res->status == 0 && !empty($res->invoiceNumber)){
			$this->Detail = $res->invoiceNumber;
			return true;
		}
		return false;

	}





}


