<?php if(isset($title_for_layout) && !empty($title_for_layout)){$title = " | " . __($title_for_layout);}else{$title = ''; } ?>
<title><?php echo Configure::read('SiteSetting.SiteTitle').$title ; ?></title>
<meta name="description" content="<?php echo Configure::read('SiteSetting.SiteDescription'); ?>" />
<meta name="keywords" content="<?php echo Configure::read('SiteSetting.SiteKeyword'); ?>" />