<div align="center" style="background-color:#f2f2f2; font-family:Tahoma; font-size:11px; padding:15px 10px; direction:rtl;">
	
    <div style="width:600px; border:1px solid #6f6f6f; background-color:#ffffff; border-radius:5px;">
    		
            <div style="height:31px; background-color:#9b9b9b; color:#FFF;">				
				<?php echo Configure::read('SiteSetting.SiteTitle'); ?>
            </div>
    	
        <div style="padding:8px; text-align:right;">
            <?php echo $content ; ?>
		<div style="clear:both"></div>  
        </div>
        
        
        
        
        <div style="border-top:1px solid #6f6f6f; padding:8px; height: 45px;">
            <?php echo Configure::read('SiteSetting.SiteDescription'); ?>
        <div style="float:right; width:380px; text-align:right;">
        ایمیل: <?php echo $this->Html->link(Configure::read('SiteSetting.ContactMail'),'mailto:'.Configure::read('SiteSetting.SiteMail')); ?><br>
        سايت: <?php echo $this->Html->link(Configure::read('Config.SiteUrl'),Configure::read('Config.SiteUrl')); ?>
        </div>
        
        <div style="clear:both"></div>
        </div>
    </div>
    
</div>