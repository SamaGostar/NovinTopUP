<?php
class Transaction extends AppModel {
	public $name = 'Transaction';
	public $belongsTo = array('Product','Payment');
	public $hasMany = array('Conference');
	
	public $validate = array(
        'cell_number' => array(
            'CheckNumeric' => array(
                'rule'     => 'numeric',
                'message'  => 'Numbers only'
            ),
            'between' => array(
                'rule'    => array('between', 11, 11),
                'message' => '11 characters Only',
				'allowEmpty' => false
            )
        ),
        'product_id' => array(
            'rule'    => array('numeric'),
            'message' => 'Numbers only',
			'allowEmpty' => false
        ),
		'amount' => array(
            'rule'    => array('numeric'),
            'message' => 'Numbers only',
			'allowEmpty' => false
        ),
		'email' => array(
            'rule'    => array('email'),
            'message' => 'Email Not Valid',
			'allowEmpty' => true
        ),
        'operator' => array(
            'rule'       => 'alphaNumeric',
            'message'    => 'Alphabets and numbers only',
            'allowEmpty' => false
        ),
		'ip' => array(
            'rule'    => array('ip'),
            'message' => 'Please supply a valid IP address'
        )
    );
	
}