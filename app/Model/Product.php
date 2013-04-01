<?php
class Product extends AppModel {
	public $name = 'Product';
	public $hasMany = array('Transaction');
	public $belongsTo = array('Service');
	
	public $validate = array(
		'slug' => array(
            'rule'    => array('numeric'),
            'message' => 'Numbers only',
			'allowEmpty' => false
        ),
		'price' => array(
            'rule'    => array('numeric'),
            'message' => 'Numbers only',
			'allowEmpty' => false
        )
    );
	
}