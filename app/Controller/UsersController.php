<?php
class UsersController extends AppController {
	public $name = 'Users';
	public $helpers = array(
		'Html',
		'Form',
		);
	public $components = array(
		'Paginator',
		'Email',
		//'Security',
	);

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('forgetpass','newpass','login','logout');
	}

	public function login() {
      if ($this->request->is('post')) {
        if ($this->Auth->login()) {
		        $this->User->id = $this->Auth->user('id');
				$fields = array('last_login' => date('Y-m-d H:i:s'));
				$this->User->save($fields, array('validate' => false, 'fieldList' => array('last_login'))); 
            return $this->redirect($this->Auth->redirect());
        } else {
            $this->Session->setFlash(__('Username or password is incorrect'), 'default', array(), 'auth');
        }
      }
    }
	
	public function logout() {
        $this->redirect($this->Auth->logout());
    }
	
    public function admin_index() {
		$this->theme = 'Admin';
        $this->User->recursive = 0;
		$this->paginate = array(
		                     'fields'=>array('id','name','email','last_login')
		                        );
		$this->set('users', $this->paginate('User'));
    }

    public function admin_edit($id = null) {
        $this->theme = 'Admin';
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
			if(!empty($this->request->data['User']['password'])){ unset($this->request->data['User']['password']); }
            if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The %s has been saved',__($this->name)), 'default', array('class' => 'alert alert-success'), 'admin');
                $this->redirect(array('action' => 'index'));
            } else {
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.',__($this->name)), 'default', array('class' => 'alert alert-error'), 'admin');
            }
        } else {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
        }
    }

    public function admin_changepass($id = null) {
        $this->theme = 'Admin';
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The %s has been saved',__($this->name)), 'default', array('class' => 'alert alert-success'), 'admin');
                $this->redirect(array('action' => 'index'));
            } else {
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.',__($this->name)), 'default', array('class' => 'alert alert-error'), 'admin');
            }
        } else {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
        }
    }
	
	public function forgetpass() {
		if ($this->request->is('post')) {
        	if (!empty($this->request->data)) {
				$user = $this->User->find('first',array(
												'conditions' => array('User.email' => $this->request->data['User']['email']),
                   								'fields'=>array('email','id','password'),
												'recursive' => -1,
												));
				if(!empty($user['User']['id'])){
					$this->User->id = $user['User']['id'];
					$ResetUrl = Configure::read('Config.SiteUrl') . 'users/newpass/' . base64_encode($this->request->data['User']['email']) . '/' . $this->User->ResetPassHash();
					App::uses('CakeEmail', 'Network/Email');
					$email = new CakeEmail();
					$email->from(array(Configure::read('SiteSetting.SiteMail') => Configure::read('SiteSetting.SiteTitle')));
					$email->to($user['User']['email']);
					$email->subject(__('Reset Password : ').Configure::read('SiteSetting.SiteTitle'));
					$message = ' درخواست تغییر رمز عبور برای شناسه کاربری شما در سایت '.Configure::read('SiteSetting.SiteTitle').' دریافت شده است ، برای تغییر رمز عبور به نشانی زیر مراجعه بفرمائید : '.$ResetUrl ;
					$email->send($message);
					$this->Session->setFlash(__('New Password Was Send To Your Email'), 'default', array(), 'auth');
					$this->redirect(array('action' => 'login'));
				}
        	} else {
            	$this->Session->setFlash(__('Username is incorrect'), 'default', array(), 'auth');
        	}
     	}		
	}

	public function newpass($email = null, $key = null) {
		if (!empty($email) && !empty($key)) {
				$user = $this->User->find('first',array(
												'conditions' => array('User.email' => base64_decode($email)),
                   								'fields'=>array('email','id','password'),
												'recursive' => -1,
												));
				if(!empty($user['User']['id'])){
					$this->User->id = $user['User']['id'];
					$Resethash = $this->User->ResetPassHash();
					if($Resethash == $key){
						if(!empty($this->request->data['User']['password']) && $this->request->data['User']['password'] == $this->request->data['User']['confpass']){
							$this->User->id = $user['User']['id'];
							if($this->User->saveField('password', $this->request->data['User']['password'],array('validate' => true,'fieldList' => array('password')))){
								$this->Session->setFlash(__('Password is Changed'), 'default', array(), 'auth');
								$this->redirect(array('action' => 'login'));
							}else{
								$this->Session->setFlash(__('Password is Not Changed, try again'), 'default', array(), 'auth');
								//$this->redirect(array('action' => 'login'));
							}
						}else{
							//$this->Session->setFlash(__('Error'), 'default', array(), 'auth');
						}
					}else{
						$this->redirect('/');
					}
        		} else {
            		//$this->Session->setFlash(__('Username is incorrect'), 'default', array(), 'auth');
					$this->redirect('/');
        		}
		}
	}
		

}
