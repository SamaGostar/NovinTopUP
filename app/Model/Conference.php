<?php
class Conference extends AppModel {
	public $name = 'Conference';
	public $belongsTo = array('Transaction','User');
	
	public $validate = array(
        'message' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'message' => 'Message is required'
            ),
			'Length' => array(
        		'rule'    => array('maxLength', 1000),
        		'message' => 'Message must be no larger than 1000 characters long.'
    		),
        ),
    );

}