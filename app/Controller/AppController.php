<?php
App::uses('Controller', 'Controller');
class AppController extends Controller {
	
	public $components = array(
	  'Session',
      'Auth' => array(
	    'loginRedirect' => array(
			'controller' => 'transactions', 
			'action' => 'stat',
			'admin' => true
		),
        'loginAction' => array(
            'controller' => 'users',
            'action' => 'login',
			'admin' => false
        ),
        'authError' => 'شما مجوز دسترسی به این قسمت را ندارید !',
        'authenticate' => array(
            'Form' => array(
                'fields' => array('username' => 'email'),
            ),
        )
      )
   );
   
   public $view = 'Theme';
   public $theme = 'Box';
   
   public function beforeFilter() {
		parent::beforeFilter();
		Configure::write('Config.language', 'per');
		Configure::write('Config.SiteUrl',Router::url('/', true));
		$Settings = Cache::read('SiteSetting','longterm');
		if (!$Settings) {
		    $this->loadModel('Setting');
            $Settings = $this->Setting->find('all');
			Cache::write('SiteSetting',$Settings,'longterm');
		}
	    foreach ($Settings as $Seting){
	 	    Configure::write('SiteSetting.'.$Seting['Setting']['name'],$Seting['Setting']['value']);
	    }
		
		$this->theme = Configure::read('SiteSetting.Theme');
   }
   
}
