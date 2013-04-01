<?php
class Service extends AppModel {
	public $name = 'Service';
	public $hasMany = array('Transaction');
	
	public $validate = array(
        'slug' => array(
            'slug_between' => array(
                'rule' => array('between', 3, 3),
                'message'  => 'Numbers only'
            ),
			'alphaNumeric' => array(
                'rule'     => 'alphaNumeric',
                'required' => true,
                'message'  => 'Alphabets and numbers only'
            ),
        ),
	);
}