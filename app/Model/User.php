<?php
App::uses('AuthComponent', 'Controller/Component');
class User extends AppModel {
	public $name = 'User';
	
	public function beforeSave($options = array()) {
        if (isset($this->data['User']['password'])) {
            $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
        }
        return true;
    }
	
	public $validate = array(
        'email' => array(
            'required' => array(
                'rule' => array('email'),
				'allowEmpty' => false,
                'message' => 'A username is required'
            )
        ),
        'password' => array(
            'required' => array(
               'rule'    => array('minLength', 8),
               'message' => 'Password must be at least 8 characters long',
			   'allowEmpty' => false,
            ),
        ),
		'confrim_password' => array(
			'rule' => 'confirmPassword',
			'message' => 'The passwords are not equal, please try again.',
			'allowEmpty' => false,
		),
		'old_password' => array(
			'rule' => 'changePassword',
			'message' => 'The passwords are not equal, please try again.',
			'allowEmpty' => false,
		),
    );

	public function confirmPassword($password = null) {
		if (isset($this->data[$this->alias]['password'])){
			if(!empty($password['confrim_password']) && isset($password['confrim_password'])){
			   if($this->data[$this->alias]['password'] === $password['confrim_password']) {
			      return true;
			   }
			}
		}
		return false;
	}
	
	public function changePassword($password = null) {
		if (isset($this->data[$this->alias]['password'])){
		    if(isset($password['old_password']) && !empty($password['old_password'])){
				$OldPass = $this->field('password',array('id' => AuthComponent::user('id')));
				if($OldPass == AuthComponent::password($password['old_password'])){
			        return true;
				}
			}
		}
		return false;
	}
	
	public function ResetPassHash(){
		if (!isset($this->id)) {
			return false;
		}
		return substr(Security::hash(md5($this->field('password'))), 5, 12);
	}

}