<?php
class ConferencesController extends AppController {
	public $name = 'Conferences';
	public $helpers = array(
		'Html',
		'Form',
		'Persiandate',
		);
	public $components = array(
		'Paginator',
		'Security',
	);

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index');
	}
	
    public function admin_index() {
		$this->theme = 'Admin';
        $this->Conference->recursive = 0;
		$this->Conference->Behaviors->attach('Containable');
		$this->paginate = array(
							'contain' => array('Transaction' => array(
								'fields'=>array('id','created','conference_status','cell_number'),
							)),
							'conditions' => array(
							                      'Transaction.conference_status' => array(1,3), 
												  ),
							'fields'=>array('id','created','transaction_id'),
							'group' => array('Conference.transaction_id'),
							'order' => array('Conference.created' => 'desc')
							);
		$this->set('conferences', $this->paginate('Conference'));
    }
	
	public function status() {
		if($this->request->is('ajax')){
			$this->loadModel('Transaction');
			$Statuses = array(1, 3);
			foreach($Statuses as $Status){
				$count = $this->Transaction->find('count',array(
											'conditions' => array(
							                      'Transaction.conference_status' => $Status, 
											)));
				if(empty($count)) $count = 0;
				$counts[] = array('count' => $count, 'title' => __('ConferenceStatus'. $Status), 'status' => $Status);
			}

			Configure::write('debug', 0);
            $this->disableCache();
			$this->set('counts', $counts);
			$this->layout = 'ajax';
		}
	}

    public function admin_all($status = null) {
		$this->theme = 'Admin';
        $this->Conference->recursive = 0;
		$this->Conference->Behaviors->attach('Containable');
		if(!empty($status)){
			$this->paginate = array(
							'contain' => array('Transaction' => array(
								'fields'=>array('Transaction.id','Transaction.created','Transaction.conference_status','Transaction.cell_number'),
							)),
							'conditions' => array(
							                      'Transaction.conference_status' => $status , 
												  ),
							'fields'=>array('Conference.id','Conference.created','Conference.transaction_id'),
							'group' => array('Conference.transaction_id'),
							'order' => array('Conference.created' => 'desc')
							);
		}else{
			$this->paginate = array(
							'contain' => array('Transaction' => array(
								'fields'=>array('Transaction.id','Transaction.created','Transaction.conference_status','Transaction.cell_number'),
							)),
							'conditions' => array(
							                      'Transaction.conference_status !=' => 0 , 
												  ),
							'fields'=>array('Conference.id','Conference.created','Conference.transaction_id'),
							'group' => array('Conference.transaction_id'),
							'order' => array('Conference.created' => 'desc')
							);
		}
		$this->set('conferences', $this->paginate('Conference'));
    }

    public function index($TransID = null, $CellNumber = null) {

		if(!empty($this->request->data['Conference']['id']) && !empty($this->request->data['Conference']['number']) && is_numeric($this->request->data['Conference']['id']) && is_numeric($this->request->data['Conference']['number'])){
        	$this->redirect(array('action' => 'index', $this->request->data['Conference']['id'], $this->request->data['Conference']['number']));
		}
		
		if(!empty($TransID) && !empty($CellNumber)){
			$this->loadModel('Transaction');
			$transactions = $this->Transaction->find('first',array(
												'conditions' => array(
													'Transaction.id' => $TransID,
													'Transaction.cell_number' => $CellNumber,
												),
												'fields'=>array('Transaction.id','Transaction.cell_number','Transaction.amount','Transaction.created','Transaction.status','Transaction.conference_status','Transaction.magic'),
												'recursive' => -1,
												));
															
			if (!empty($transactions)){
				
				$this->set('transactions',$transactions);
				
				if (!empty($this->request->data)) {
					
					App::uses('Sanitize', 'Utility');
					$this->request->data['Conference']['message'] = Sanitize::html($this->request->data['Conference']['message'], array('remove' => true));
					$message = $this->request->data['Conference']['message'] ;

					$this->request->data['Conference']['user_id'] = -1 ;
					$this->request->data['Conference']['transaction_id'] = $transactions['Transaction']['id'];
					$this->request->data['Conference']['note'] = 0 ;

               		$this->Conference->create();
            		if($this->Conference->save($this->request->data,array(
																		'validate' => true, 
																		'fieldList' => array('message','note','user_id','transaction_id')
,																		))){
						
						$this->Transaction->id = $TransID;
						$this->Conference->Transaction->saveField('conference_status', 1);
						
						App::uses('CakeEmail', 'Network/Email');
						$email = new CakeEmail();
						$email->emailFormat('html');
						$email->template('novin');
						$email->from(array(Configure::read('SiteSetting.SiteMail') => Configure::read('SiteSetting.SiteTitle')));
						$email->to(Configure::read('SiteSetting.ContactMail'));
						$email->subject(' تیکت جدید برای سفارش شماره '.$TransID.' در سایت '.Configure::read('SiteSetting.SiteTitle').' ثبت شد ');
						$messages = ' متن تیکت : '.$message;
						$email->send($messages);
											
              	 		$this->Session->setFlash(__('The conference has been saved'));
              		  	$this->redirect(array('action' => 'index', $transactions['Transaction']['id'], $transactions['Transaction']['cell_number']));
            		} else {
              		  	$this->Session->setFlash(__('The conference could not be saved. Please, try again.'));
            		}
       			}
			
				$this->Conference->Behaviors->attach('Containable');
				$messages = $this->Conference->find('all',array( 
											   'contain' => array('User.name'),
											   'conditions' => array(
											   						'Conference.transaction_id' => $TransID,
																	'Conference.note' => 0,
											   ),
											   'order' => array('Conference.created'),
											   ));
				$this->set('conferences',$messages);
			}else{
				throw new NotFoundException(__('Invalid Data'));
			}
		}else{
			throw new NotFoundException(__('Invalid Data'));
		}
    }


    public function admin_view($TransID = null) {
		$this->theme = 'Admin';
		
		if(!empty($TransID)){
			$this->loadModel('Transaction');
			$transactions = $this->Transaction->find('first',array(
												'conditions' => array(
																	'id' => $TransID,
												),
												'fields'=>array('Transaction.id','Transaction.email','Transaction.cell_number','Transaction.amount','Transaction.created','Transaction.status','Transaction.conference_status','Transaction.magic'),
												'recursive' => -1,
												));
			if (!empty($transactions)){
				
				$this->set('transactions',$transactions);

				if (!empty($this->request->data)) {
					$this->request->data['Conference']['user_id'] = AuthComponent::user('id');
					$this->request->data['Conference']['transaction_id'] = $TransID;
               		$this->Conference->create();
            		if($this->Conference->save($this->request->data)){
						
						$this->Transaction->id = $TransID;
						$this->Conference->Transaction->saveField('conference_status', $this->request->data['Conference']['status']);
						
						if(!empty($transactions['Transaction']['email']) && $this->request->data['Conference']['note'] != 1){
							App::uses('CakeEmail', 'Network/Email');
							$email = new CakeEmail();
							$email->emailFormat('html');
							$email->template('novin');
							$email->from(array(Configure::read('SiteSetting.SiteMail') => Configure::read('SiteSetting.SiteTitle')));
							$email->to($transactions['Transaction']['email']);
							$email->subject(' تیکت شما در رابطه با سفارش شماره '.$TransID.' در سایت '.Configure::read('SiteSetting.SiteTitle').' پاسخ داده شد ');
							$message = ' متن پاسخ شما : '.$this->request->data['Conference']['message'];
							$email->send($message);
						}
						
              	 		$this->Session->setFlash(__('The conference has been saved'));
              		  	$this->redirect(array('action' => 'index'));
            		} else {
              		  	$this->Session->setFlash(__('The conference could not be saved. Please, try again.'));
            		}
       			}
			
				$this->Conference->Behaviors->attach('Containable');
				$messages = $this->Conference->find('all',array( 
											   'contain' => array('User.name'),
											   'conditions' => array(
											   						'Conference.transaction_id' => $TransID,
											   ),
											   'order' => array('Conference.created'),
											   ));
				$this->set('conferences',$messages);
			}else{
				//$this->Session->setFlash(__('Incorrect Data'));
				//$this->redirect('/');
			}
		}
    }

    public function admin_active($id = null,$active = null) {
		$this->theme = 'Admin';
        $this->Conference->id = $id;
        if (!$this->Conference->exists() && !isset($active) && empty($active)) {
            throw new NotFoundException(__('Invalid Conference'));
        }
        if ($active == 1 || $active == 0) {
			if ($this->Conference->saveField('active', $active)){
				$this->Conference->setFlash(__('The %s has been saved',__($this->name)), 'default', array('class' => 'alert alert-success'), 'admin');
                $this->redirect(array('action' => 'index'));
            } else {
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.',__($this->name)), 'default', array('class' => 'alert alert-error'), 'admin');
				$this->redirect(array('action' => 'index'));
            }
		}
		else{
			    $this->redirect(array('action' => 'index'));
		}
    }
	

}
