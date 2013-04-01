$(document).ready(function(){
	 
	var $validCell, $validEmail = 0;

	if($('.remember').attr('checked') && $('#CellNumberInput').val().length == 11) {
		$('#chargeform input[type="submit"]').removeAttr('disabled');
	} else {
		$('#chargeform input[type="submit"]').attr('disabled','disabled');
	}
	
	$("#CellNumberInput").inputmask("mask", {"mask": "09#########",
									"onincomplete": function(){ 
										$(this).addClass("inputerror");
										$('#chargeform input[type="submit"]').attr('disabled','disabled');
										$validCell = 0;
									},
									"oncomplete": function(){ 
										$(this).removeClass("inputerror");
										if($validEmail >= 0){
											$('#chargeform input[type="submit"]').removeAttr('disabled');
										}
										$validCell = 1;
									}}
									
									);
	
	var delay = (function(){
       var timer = 0;
       return function(callback, ms){
        	clearTimeout (timer);
       		timer = setTimeout(callback, ms);
       };
    })();
	
	var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);

	$("#EmailInput").keyup(function() {
		if($(this).val().length > 0) {
			delay(function(){
      			var emailaddress = $("#EmailInput").val();
	  			if(pattern.test(emailaddress)){
					$validEmail = 1;
					$("#EmailInput").removeClass("inputerror");
		  			if($validCell > 0){
						$('#chargeform input[type="submit"]').removeAttr('disabled');
					}
	  			}else{
					$("#EmailInput").addClass("inputerror");
					$('#chargeform input[type="submit"]').attr('disabled', 'disabled');
					$validEmail = -1;
	  			}
	  		},600);
		}else{
			$("#EmailInput").removeClass("inputerror");
			if($validCell > 0){
				$('#chargeform input[type="submit"]').removeAttr('disabled');
			}
			$validEmail = 0;
		}
    });
		
    $(document).ajaxStart(function() {
	     $('.content').append('<div class="loading"><div class="load"><img src="<?php echo Configure::read('Config.SiteUrl');?>/theme/Box/img/load.gif" width="30px" height="30px" /><p>در حال اتصال به درگاه پرداخت</p></div></div>');
    });
	//$(document).ajaxStop(function() {
    //     $('.loading').hide();
    //});
	$(document).ajaxError(function() {
         $('.loading').hide();
    });
	
	$("#chargeform").submit(function(event) {
		 $('#chargeform input[type="submit"]').attr('disabled','disabled');
		 event.preventDefault();
         var values = $(this).serialize();
         $.ajax({
              url: "<?php echo Configure::read('Config.SiteUrl');?>",
              type: "post",
              data: values,
              success: function(data){
                  $(".content").append(data);
		          $('#BankRedirect').submit();
              },
              error:function(){
                  alert("خطا در ارسال ، لطفا صفحه را مجددا بارگزاری فرمائید");
				  $('#chargeform input[type="submit"]').removeAttr('disabled');
              }   
        });
    });
	
	var opname = $("#OperatorInput").attr("value");
	$("#" + opname + "logo").addClass(opname + "active");
	
	function CheckMail(emailAddress) {
		var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
        return pattern.test(emailAddress);
    }
 });