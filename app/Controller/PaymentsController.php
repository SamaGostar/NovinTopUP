<?php
class PaymentsController extends AppController {
	public $name = 'Payments';
	public $helpers = array(
		'Html',
		'Form',
		);

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index');
	}
	
    public function index() {
		if(!empty($this->request->params['requested'])){
           $this->Payment->recursive = 0;
		   $Payments = $this->Payment->find('list',array(
		                                        'conditions' => array('Payment.active' => 1),
												'fields'=>array('id','name')
		                                        ));
		   if(isset($Payments) && !empty($Payments)){return $Payments;}
		   return ;
		}
    }
	
	public function admin_index() {
		$this->theme = 'Admin';
        $this->Payment->recursive = 0;
		$this->paginate = array(
		                     'fields'=>array('id','name','psp','active')
		                        );
		$this->set('payments', $this->paginate('Payment'));
    }

    public function admin_add() {
		$this->theme = 'Admin';
        if ($this->request->is('post')) {
            $this->Payment->create();
            if ($this->Payment->save($this->request->data)) {
				$this->Session->setFlash(__('The %s has been saved',__($this->name)), 'default', array('class' => 'alert alert-success'), 'admin');
                $this->redirect(array('action' => 'index'));
            } else {
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.',__($this->name)), 'default', array('class' => 'alert alert-error'), 'admin');
            }
        }
    }

    public function admin_edit($id = null) {
		$this->theme = 'Admin';
        $this->Payment->id = $id;
        if (!$this->Payment->exists()) {
            throw new NotFoundException(__('Invalid Payment'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Payment->save($this->request->data)) {
				$this->Session->setFlash(__('The %s has been saved',__($this->name)), 'default', array('class' => 'alert alert-success'), 'admin');
                $this->redirect(array('action' => 'index'));
            } else {
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.',__($this->name)), 'default', array('class' => 'alert alert-error'), 'admin');
            }
        } else {
            $this->request->data = $this->Payment->read(null, $id);
        }
    }
	
    public function admin_active($id = null,$active = null) {
		$this->theme = 'Admin';
        $this->Payment->id = $id;
        if (!$this->Payment->exists() && !isset($active) && empty($active)) {
            throw new NotFoundException(__('Invalid Payment'));
        }
        if ($active == 1 || $active == 0) {
			if ($this->Payment->saveField('active', $active)){
				$this->Session->setFlash(__('The %s has been saved',__($this->name)), 'default', array('class' => 'alert alert-success'), 'admin');
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