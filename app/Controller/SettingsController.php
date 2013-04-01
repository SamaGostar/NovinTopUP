<?php
class SettingsController extends AppController {
	public $name = 'Settings';
	public $helpers = array(
		'Html',
		'Form',
		);

	public function beforeFilter() {
		parent::beforeFilter();
	}

	public function admin_index() {
		$this->theme = 'Admin';
        $this->Setting->recursive = 0;
		$this->paginate = array(
		                     'fields'=>array('id','name','value')
		                        );
		$this->set('settings', $this->paginate('Setting'));
    }

    public function admin_edit($id = null) {
		$this->theme = 'Admin';
		$this->Setting->recursive = 0;
        $this->Setting->id = $id;
        if (!$this->Setting->exists()) {
            throw new NotFoundException(__('Invalid Setting'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
			unset($this->request->data['Setting']['name']);
            if ($this->Setting->save($this->request->data)) {
				$this->Session->setFlash(__('The %s has been saved',__($this->name)), 'default', array('class' => 'alert alert-success'), 'admin');
                $this->redirect(array('action' => 'index'));
            } else {
				$this->Session->setFlash(__('The %s could not be saved. Please, try again.',__($this->name)), 'default', array('class' => 'alert alert-error'), 'admin');
				//$this->redirect(array('action' => 'index'));
            }
        } else {
            $this->request->data = $this->Setting->read(null, $id);
			if($this->request->data['Setting']['name'] == 'Theme'){
				App::uses('Folder', 'Utility');
				$Folder = new Folder(APP.'/View/Themed/');
				$Results = $Folder->read(true);
				foreach($Results[0] as $FolderName){
					if($FolderName != 'Admin'){
						$Themes[$FolderName] = $FolderName;
					}
				}
				$this->set('values',$Themes);
			}
        }
    }

}