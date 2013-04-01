<?php
class Setting extends AppModel{
	public $name = 'Setting';
		
	public function afterSave(){
		$Settings = Cache::read('SiteSetting','longterm');
        if($Settings){
            Cache::delete('SiteSetting','longterm');
        }
        return true;
    }
}