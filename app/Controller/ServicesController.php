<?php
class ServicesController extends AppController {
	public $name = 'Services';
	public $helpers = array(
		'Html',
		'Form',
		);

	public function beforeFilter() {
		parent::beforeFilter();
		//$this->Auth->allow('index');
	}

	public function admin_index() {
		$this->theme = 'Admin';
        $this->Service->recursive = 0;
		$this->paginate = array(
		                     'fields'=>array('id','slug','active')
		                        );
		$this->set('services', $this->paginate('Service'));
    }

    public function admin_add() {
		$this->theme = 'Admin';
        if ($this->request->is('post')) {
            $this->Service->create();
            if ($this->Service->save($this->request->data)) {
				$this->Session->setFlash(__('The %s has been saved',__($this->name)), 'default', array('class' => 'alert alert-success'), 'admin');
                $this->redirect(array('action' => 'index'));
            } else {
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.',__($this->name)), 'default', array('class' => 'alert alert-error'), 'admin');
            }
        }
    }

    public function admin_edit($id = null) {
		$this->theme = 'Admin';
		$this->Service->recursive = 0;
        $this->Service->id = $id;
        if (!$this->Service->exists()) {
            throw new NotFoundException(__('Invalid Service'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Service->save($this->request->data)) {
				$this->Session->setFlash(__('The %s has been saved',__($this->name)), 'default', array('class' => 'alert alert-success'), 'admin');
                $this->redirect(array('action' => 'index'));
            } else {
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.',__($this->name)), 'default', array('class' => 'alert alert-error'), 'admin');
				//$this->redirect(array('action' => 'index'));
            }
        } else {
            $this->request->data = $this->Service->read(null, $id);
        }
    }

    public function admin_delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Service->id = $id;
        if (!$this->Service->exists()) {
            throw new NotFoundException(__('Invalid Service'));
        }
        if ($this->Service->delete()) {
			$this->Session->setFlash(__('%s deleted',__($this->name)), 'default', array('class' => 'alert alert-success'), 'admin');
            $this->redirect(array('action' => 'index'));
        }
		$this->Session->setFlash(__('%s was not deleted',__($this->name)), 'default', array('class' => 'alert alert-error'), 'admin');
        $this->redirect(array('action' => 'index'));
    }

    public function admin_active($id = null,$active = null) {
		$this->theme = 'Admin';
        $this->Service->id = $id;
        if (!$this->Service->exists() && !isset($active) && empty($active)) {
            throw new NotFoundException(__('Invalid Service'));
        }
        if ($active == 1 || $active == 0) {
			if ($this->Service->saveField('active', $active)){
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
