<?php
class ProductsController extends AppController {
	public $name = 'Products';
	public $helpers = array(
		'Html',
		'Form',
		);

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index');
	}
	
    public function index($operator = null) {
	  if(!empty($this->request->params['requested'])){
		$productt = array();
        $this->Product->recursive = 0;
		$operators = $this->Product->Service->find('list',array('fields'=>array('slug'),'conditions' => array('Service.active' => 1)));
        $productt['operators'] = $operators ;
		if(isset($operators) && !empty($operators)){
			if(isset($operator) && !empty($operator) && in_array($operator,$operators) || $operator = Configure::read('SiteSetting.DefaultOperator')){
		        $products = $this->Product->find('all',array(
		                                        'conditions' => array('Product.active' => 1,'Service.active' => 1,'Service.slug' => $operator),
												'order' => array('Product.id ASC'),
												'fields'=>array('id','description')
		                                        ));
				if(isset($products) && !empty($products)){
		            foreach($products as $product){
			            $productsList[$product['Product']['id']] = $product['Product']['description'] ;
		            }
					$productt['product'] = $productsList ;
					$productt['operator'] = $operator ;
					return $productt ;
				}
			}
			return $productt ;
		}
	  }
	  return ;
    }
	
	public function admin_index() {
		   $this->theme = 'Admin';
		   $this->Product->Behaviors->attach('Containable');
		   $this->paginate = array(
		           'contain' => array('Service' => array('fields' => array('Service.slug'))),
                   'fields'=>array('id','price','slug','description','service_id','active'),
                   'limit' => Configure::read('SiteSetting.Limit') ,
		           'order' => 'Product.id DESC'
           );
           $this->set('products', $this->paginate('Product'));
    }
	
    public function admin_active($id = null,$active = null) {
		$this->theme = 'Admin';
        $this->Product->id = $id;
        if (!$this->Product->exists() && !isset($active) && empty($active)) {
            throw new NotFoundException(__('Invalid Product'));
        }
        if ($active == 1 || $active == 0) {
			if ($this->Product->saveField('active', $active)){
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

    public function admin_add() {
		$this->theme = 'Admin';
        if ($this->request->is('post')) {
            $this->Product->create();
            if ($this->Product->save($this->request->data)) {
				$this->Session->setFlash(__('The %s has been saved',__($this->name)), 'default', array('class' => 'alert alert-success'), 'admin');
                $this->redirect(array('action' => 'index'));
            } else {
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.',__($this->name)), 'default', array('class' => 'alert alert-error'), 'admin');
            }
        }
		$services = $this->Product->Service->find('list',array('fields' => array('Service.id','Service.slug')));
		$this->set('services',$services);
    }

    public function admin_edit($id = null) {
		$this->theme = 'Admin';
        $this->Product->id = $id;
        if (!$this->Product->exists()) {
            throw new NotFoundException(__('Invalid Product'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Product->save($this->request->data)) {
				$this->Session->setFlash(__('The %s has been saved',__($this->name)), 'default', array('class' => 'alert alert-success'), 'admin');
                $this->redirect(array('action' => 'index'));
            } else {
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.',__($this->name)), 'default', array('class' => 'alert alert-error'), 'admin');
				//$this->redirect(array('action' => 'index'));
            }
        } else {
            $this->request->data = $this->Product->read(null, $id);
			$services = $this->Product->Service->find('list',array('fields' => array('Service.id','Service.slug')));
		    $this->set('services',$services);
        }
    }

    public function admin_delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Product->id = $id;
        if (!$this->Product->exists()) {
            throw new NotFoundException(__('Invalid Product'));
        }
        if ($this->Product->delete()) {
			$this->Session->setFlash(__('The %s has been deleted',__($this->name)), 'default', array('class' => 'alert alert-success'), 'admin');
            $this->redirect(array('action' => 'index'));
        }
		$this->Session->setFlash(__('The %s could not be deleted. Please, try again.',__($this->name)), 'default', array('class' => 'alert alert-error'), 'admin');
        $this->redirect(array('action' => 'index'));
    }
}
