<?php
class Payment extends AppModel {
	public $name = 'Payment';
	public $hasMany = array('Transaction');
	public $validate = array(
        'psp' => array(
            'between' => array(
                'rule'    => array('between', 3, 3),
                'message' => '3 characters Only',
            ),
			'alphaNumeric' => array(
                'rule'    => array('alphaNumeric'),
                'message' => 'Alpha Numeric Only',
            )
        ),
		'name' => array(
            'alphaNumeric' => array(
                'rule'    => array('notEmpty'),
                'message' => 'This field cannot be left blank',
            )
        ),
    );	
}