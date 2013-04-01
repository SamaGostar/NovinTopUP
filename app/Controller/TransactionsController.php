<?php
class TransactionsController extends AppController {
	public $name = 'Transactions';
	public $helpers = array(
		'Html',
		'Form',
		'Persiandate',
		);

	public $components = array(
		'Paginator',
		'RequestHandler',
		'Novinways',
		'Zpl',
		'Security',
		'Cookie',
		);

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('add','verify');
		
		if ($this->action == 'verify') {
			$this->Security->validatePost = false;
			$this->Security->csrfCheck = false;
		}
	}

    public function add() {

		if($this->request->is('ajax')){
			Configure::write('debug', 0);
            $this->disableCache();
			$this->layout = 'ajax';
			$this->render('ajax');
		}

        if ($this->request->is('post')){
			$this->request->data['Transaction']['ip'] = CakeRequest::clientIp() ;
			$this->Transaction->set($this->request->data);
			if($this->Transaction->validates()) {
				$this->loadModel('Product');
				$price = $this->Product->find('first', array(
				                               'conditions' => array('Product.id' => $this->request->data['Transaction']['product_id'],
											                         'Product.active' => 1 , 
																	 'Service.active' => 1 ,
											   ),
				                               'fields'=>array('Product.price'),
											   'recursive' => 0
											   ));
				if(isset($price) && !empty($price)){
				    $this->request->data['Transaction']['amount'] = $price['Product']['price'];
				}
				
				$this->loadModel('Payment');
				$payments = $this->Payment->find('first', array(
				                               'conditions' => array('Payment.id' => $this->request->data['Transaction']['payment_id'],
											                         'Payment.active' => 1 ,
																	 'Payment.data !=' => '' ,
											   ),
				                               'fields'=>array('Payment.psp','Payment.data'),
											   'recursive' => 0
											   ));

				if(isset($price) && !empty($price) && isset($payments) && !empty($payments)){
						
						$NovinCookie = $this->Cookie->read('NovinWays') ;
						if(!empty($this->request->data['Transaction']['remember'])){
							if(empty($NovinCookie['CellNumber']) || !empty($this->request->data['Transaction']['email']) && empty($NovinCookie['Email'])){
								$this->Cookie->write('NovinWays', array('CellNumber' => $this->request->data['Transaction']['cell_number'], 'Email' => $this->request->data['Transaction']['email']), true, 2592000);
								unset($this->request->data['Transaction']['remember']);
							}
						}elseif(!empty($NovinCookie)){
							$this->Cookie->delete('NovinWays');
						}
						
						if($this->request->data['Transaction']['magic'] != 1){$this->request->data['Transaction']['magic'] = 0 ;}
                        $this->Transaction->create();
                        if ($this->Transaction->save($this->request->data,array(
																			'validate' => true, 
																			'fieldList' => array('amount','product_id','payment_id','cell_number','email','ip','magic')
																			))){
							
							$ComponentName = ucfirst(strtolower($payments['Payment']['psp']));
														
							$this->{$ComponentName}->SetVar('merchantID', $payments['Payment']['data']);
			                $this->{$ComponentName}->SetVar('amount', $this->request->data['Transaction']['amount']);
							$this->{$ComponentName}->SetVar('orderID', $this->Transaction->id);
			                $this->{$ComponentName}->SetVar('desc',' جهت شارژ شماره '.$this->request->data['Transaction']['cell_number'].' با شماره سفارش '.$this->Transaction->id);

							$BankResponse = $this->{$ComponentName}->Execute();

							if($BankResponse){
								if(isset($this->{$ComponentName}->Authority) && !empty($this->{$ComponentName}->Authority)){
				                    $fields = array('authority' => $this->{$ComponentName}->Authority,'status' => $this->{$ComponentName}->ErrorCode) ;
				                    $saved = $this->Transaction->save($fields, array('validate' => false,'fieldList' => array('authority','status'))); 
								}else{
									$fields = array('status' => $this->{$ComponentName}->ErrorCode) ;
				                    $saved = $this->Transaction->save($fields, array('validate' => false, 'fieldList' => array('status')));
								}
							    if($saved && isset($this->{$ComponentName}->BankForm) && !empty($this->{$ComponentName}->BankForm) ){

								   if($this->request->is('ajax')){
									  Configure::write('debug', 0);
                                      $this->disableCache();
									  $this->layout = 'ajax';
									  $this->render('ajax');
									  $this->set('forms', $this->{$ComponentName}->BankForm);
									  $this->layout = 'ajax';
									  $this->render('ajax');
								   }else{
							          $this->set('forms', $this->{$ComponentName}->BankForm);
									  $this->render('bank');
								   }
							    }
							    else{
								    throw new NotFoundException(__('Invalid Bank Response'));
							    }
							 }else{
								    throw new NotFoundException(__('Response False'));
							 }
                        }else{
                            $this->Session->setFlash(__('The Transaction could not be saved. Please, try again.'));
                        }
				}
			}else{
				//$this->redirect($this->referer());
			}
        }
		$this->set('title_for_layout', '');
		$this->set('NovinCookie', $this->Cookie->read('NovinWays'));		
    }
	
	public function verify($psp = null) {
		if(isset($psp) && !empty($psp)){
			$this->loadModel('Payment');
			$payments = $this->Payment->find('first', array(
				                               'conditions' => array('Payment.psp' => $psp,
											                         'Payment.active' => 1 ,
																	 'Payment.data !=' => '' ,
											   ),
				                               'fields' => array('psp','data'),
											   'recursive' => 0
											   ));
		}
		if(isset($payments) && !empty($payments)){
			$ComponentName = ucfirst(strtolower($payments['Payment']['psp']));
			$dispatch = $this->{$ComponentName}->Dispatch();
			if($dispatch){
			    if(!empty($this->{$ComponentName}->Authority)){
		            $this->Transaction->Behaviors->attach('Containable');
				    $transaction = $this->Transaction->find('first',array(
						                            'contain' => array('Product' => array('Service' => array('fields' => array('Service.slug')),
																  'fields' => array('Product.slug','service_id')
																  )),
				                                    'conditions' => array(
													              'Transaction.authority' => $this->{$ComponentName}->Authority,
																  'Transaction.status' => 200
																  ),
													'fields' => array('id','product_id','amount','email','cell_number','magic'),
				                                     ));
				}elseif(!empty($this->{$ComponentName}->OrderID)){
					$this->Transaction->Behaviors->attach('Containable');
				    $transaction = $this->Transaction->find('first',array(
						                            'contain' => array('Product' => array('Service' => array('fields' => array('Service.slug')),
																  'fields' => array('Product.slug','service_id')
																  )),
				                                    'conditions' => array(
													              'Transaction.id' => $this->{$ComponentName}->OrderID,
																  'Transaction.status' => 200
																  ),
													'fields' => array('id','product_id','amount','email','cell_number','magic'),
				                                     ));
					
				}
			}else{
				$this->Session->setFlash(__('Dispatch Error'));
			}
			
			if(!empty($transaction)){
				$this->{$ComponentName}->SetVar('Amount', $transaction['Transaction']['amount']);
				$this->{$ComponentName}->SetVar('merchantID', $payments['Payment']['data']);
				$verify = $this->{$ComponentName}->Verify();
			}else{
				$this->Session->setFlash(__('Invalid Transaction'));
			}
			
			if(isset($verify) && !empty($verify)){
				$this->Novinways->SetVar('UserID', Configure::read('SiteSetting.UserId'));
			    $this->Novinways->SetVar('Pass', Configure::read('SiteSetting.Pass'));
				if($transaction['Transaction']['magic'] == 1){
			    	$this->Novinways->SetVar('Operator',$transaction['Product']['Service']['slug'].'!');
				}else{
					$this->Novinways->SetVar('Operator',$transaction['Product']['Service']['slug']);
				}
			    $this->Novinways->SetVar('Amount',$transaction['Product']['slug']);
			    $this->Novinways->SetVar('Email', $transaction['Transaction']['email']);
				$this->Novinways->SetVar('CellNumber', $transaction['Transaction']['cell_number']);
			    $this->Novinways->SetVar('TransID', $transaction['Transaction']['id']);
			    $NovinResponse = $this->Novinways->Charge();
				
				if($NovinResponse){
					$this->Transaction->id = $transaction['Transaction']['id'];
					$fields = array('status' => $this->Novinways->ErrorCode) ;
				    $saved = $this->Transaction->save($fields, array('validate' => false, 'fieldList' => array('status')));
					
					App::uses('CakeEmail', 'Network/Email');
					$email = new CakeEmail();
					$email->emailFormat('html');
					$email->template('novin');
					$email->from(array(Configure::read('SiteSetting.SiteMail') => Configure::read('SiteSetting.SiteTitle')));
					$email->to(Configure::read('SiteSetting.ContactMail'));
					$email->subject('سفارش جدید با شماره '.$transaction['Transaction']['id'].' در '.Configure::read('SiteSetting.SiteTitle'));
					$message = ' سفارشی با شناسه پرداخت شماره '.$transaction['Transaction']['id'].' در '.Configure::read('SiteSetting.SiteTitle').' ثبت گردید ';
					$email->send($message);
					
					if(!empty($transaction['Transaction']['email'])){
						$email = new CakeEmail();
						$email->from(array(Configure::read('SiteSetting.SiteMail') => Configure::read('SiteSetting.SiteTitle')));
						$email->to($transaction['Transaction']['email']);
						$email->emailFormat('html');
						$email->template('novin');
						$email->subject('سفارش شما با شماره '.$transaction['Transaction']['id'].' در '.Configure::read('SiteSetting.SiteTitle'));
						$message = ' سفارش شما با شناسه پرداخت شماره '.$transaction['Transaction']['id'].' در '.Configure::read('SiteSetting.SiteTitle').' ثبت گردید ';
						$email->send($message);
					}
					
					$trans = array('id' => $this->Transaction->id, 'cellnumber' => $transaction['Transaction']['cell_number'], 'refid' => $this->{$ComponentName}->Detail, 'au' => $this->{$ComponentName}->Authority);
					$this->set('trans',$trans);
				}else{
					$trans = array('id' => $transaction['Transaction']['id'], 'cellnumber' => $transaction['Transaction']['cell_number']);
					$this->set('trans',$trans);
					
					$this->Session->setFlash(__('Error On Operator Charge System'), 'default', array('class' => 'alert alert-error'), 'charge');
				}
			}else{
				$this->Session->setFlash(__('Invalid Verify'), 'default', array('class' => 'alert alert-error'), 'charge');
			}
		}else{
		    $this->Session->setFlash(__('Invalid PSP Name'), 'default', array('class' => 'alert alert-error'), 'charge');
		}
		$this->set('title_for_layout','');
	}
	
	public function admin_index() {
		   $this->theme = 'Admin';
		   $this->Transaction->Behaviors->attach('Containable');
		   $this->paginate = array(
		           'contain' => array('Product' => array('fields' => array('Product.id','Product.slug')),
				                      'Payment' => array('fields' => array('Payment.name'))),
                   'fields'=>array('Transaction.id','Transaction.amount','Transaction.product_id','Transaction.created','Transaction.status','Transaction.cell_number'),
                   'limit' => Configure::read('SiteSetting.Limit') ,
		           'order' => 'Transaction.created DESC'
           );
           $this->set('transactions', $this->paginate('Transaction'));
    }
	
	public function admin_view($id = null) {
		$this->theme = 'Admin';
		$this->layout = 'view';
		$this->Transaction->id = $id;
        if (!$this->Transaction->exists()) {
			$this->Session->setFlash(__('Invalid Transaction Id'));
        }else{		   
		   $this->Transaction->Behaviors->attach('Containable');
		   $transactions = $this->Transaction->find('all',array(
		           'contain' => array('Product' => array('Service' => array(
				                                                        'fields' => array('Service.slug')),
														   'fields' => array('Product.id','Product.slug')
														   ),
				                      'Payment' => array('fields' => array('Payment.name'))),
		           'conditions' => array('Transaction.id' => $id),
                   'fields'=>array('id','amount','product_id','created','status','email','cell_number','ip','magic'),
                   'limit' => 1 ,
		           'order' => 'Transaction.created DESC'
           ));
		   $this->set('transactions', $transactions);
		}
    }
	
	public function admin_stat() {
		$this->theme = 'Admin';
		$this->Transaction->virtualFields['created_date'] = 'date(`Transaction`.`created`)';
		$this->Transaction->virtualFields['total_amount'] = 'sum(`Transaction`.`amount`)';
		$transactions = $this->Transaction->find('all', array(
											'conditions' => array(
																"Transaction.created >" => date('Y-m-d', strtotime("-1 weeks")),
																"Transaction.status" => "1100",
																),
											'fields' => array('Transaction.created_date','Transaction.total_amount'),
											'recursive' => -1,
											'group' => 'Transaction.created_date'
											));
		$this->set('transactions',$transactions);
	}
	
	public function novincredit() {
		if(!empty($this->request->params['requested'])){
			$this->Novinways->SetVar('UserID', Configure::read('SiteSetting.UserId'));
			$this->Novinways->SetVar('Pass', Configure::read('SiteSetting.Pass'));
			$NovinResponse = $this->Novinways->GetInfo();
			return $NovinResponse;
		}
	}

	public function admin_manualverify($id = null) {
		$this->theme = 'Admin';
		$this->layout = 'view';
		$this->Transaction->id = $id;
        if (!$this->Transaction->exists()) {
			$this->Session->setFlash(__('Invalid Transaction Id'));
        }else{		   
		   $this->Transaction->Behaviors->attach('Containable');
		   $transaction = $this->Transaction->find('first',array(
		           'contain' => array('Product' => array(
				   									'Service' => array('fields' => array('Service.slug')),
													'fields' => array('Product.id','Product.slug')),
				                      				'Payment' => array('fields' => array('Payment.psp','Payment.data'))),
		           'conditions' => array('Transaction.id' => $id, 'Transaction.status' => 200),
                   'fields'=>array('id','amount','product_id','status','email','cell_number','authority','magic'),
           ));

		   if(!empty($transaction)){
			    $ComponentName = ucfirst(strtolower($transaction['Payment']['psp']));
				$this->{$ComponentName}->SetVar('Authority', $transaction['Transaction']['authority']);
				$this->{$ComponentName}->SetVar('Amount', $transaction['Transaction']['amount']);
				$this->{$ComponentName}->SetVar('merchantID', $transaction['Payment']['data']);
				$verify = $this->{$ComponentName}->ManualVerify();
			}else{
				$this->Session->setFlash(__('This mobile number has been previously charged'), 'default', array('class' => 'alert alert-error'), 'admin');
				$this->redirect(array('action' => 'index'));
				exit;
			}
			
			if(isset($verify) && !empty($verify)){
				$this->Novinways->SetVar('UserID', Configure::read('SiteSetting.UserId'));
			    $this->Novinways->SetVar('Pass', Configure::read('SiteSetting.Pass'));
				if($transaction['Transaction']['magic'] == 1){
			    	$this->Novinways->SetVar('Operator',$transaction['Product']['Service']['slug'].'!');
				}else{
					$this->Novinways->SetVar('Operator',$transaction['Product']['Service']['slug']);
				}
			    $this->Novinways->SetVar('Amount',$transaction['Product']['slug']);
			    $this->Novinways->SetVar('Email', $transaction['Transaction']['email']);
				$this->Novinways->SetVar('CellNumber', $transaction['Transaction']['cell_number']);
			    $this->Novinways->SetVar('TransID', $transaction['Transaction']['id']);
			    $NovinResponse = $this->Novinways->Charge();

				if($NovinResponse){
					$this->Transaction->id = $transaction['Transaction']['id'];
					$fields = array('status' => $this->Novinways->ErrorCode) ;
				    $saved = $this->Transaction->save($fields, array('validate' => false, 'fieldList' => array('status')));
					
					App::uses('CakeEmail', 'Network/Email');
					$email = new CakeEmail();
					$email->emailFormat('html');
					$email->template('novin');
					$email->from(array(Configure::read('SiteSetting.SiteMail') => Configure::read('SiteSetting.SiteTitle')));
					$email->to(Configure::read('SiteSetting.ContactMail'));
					$email->subject('شارژ مجدد با شماره '.$transaction['Transaction']['id'].' در '.Configure::read('SiteSetting.SiteTitle').'انجام شد');
					$message = ' شارژ مجدد برای شناسه پرداخت شماره '.$transaction['Transaction']['id'].' در '.Configure::read('SiteSetting.SiteTitle').' انجام شد ';
					$email->send($message);
					
					if(!empty($transaction['Transaction']['email'])){
						$email = new CakeEmail();
						$email->from(array(Configure::read('SiteSetting.SiteMail') => Configure::read('SiteSetting.SiteTitle')));
						$email->to($transaction['Transaction']['email']);
						$email->emailFormat('html');
						$email->template('novin');
						$email->subject('شارژ شما با شماره '.$transaction['Transaction']['id'].' در '.Configure::read('SiteSetting.SiteTitle').'انجام شد');
						$message = ' شارژ شما برای شناسه پرداخت شماره '.$transaction['Transaction']['id'].' در '.Configure::read('SiteSetting.SiteTitle').' انجام شد ';
						$email->send($message);
					}
					
					$trans = array('id' => $this->Transaction->id, 'cellnumber' => $transaction['Transaction']['cell_number'], 'refid' => $this->{$ComponentName}->Detail, 'au' => $this->{$ComponentName}->Authority);
					$this->Session->setFlash(__('Recharge Success'), 'default', array('class' => 'alert alert-success'), 'admin');
					$this->redirect(array('action' => 'index'));

				}else{
					$this->Session->setFlash(__('Error On Operator Charge System'), 'default', array('class' => 'alert alert-error'), 'admin');
					$this->redirect(array('action' => 'index'));
				}
				
			}else{
				$this->Session->setFlash(__('Invalid Verifys'), 'default', array('class' => 'alert alert-error'), 'admin');
				$this->redirect(array('action' => 'index'));
			}
		   
		}
    }
	
	
}