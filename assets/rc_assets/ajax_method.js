var height = $( window ).height();
	var f_h = height/5;
	var loading = '<div style="height:'+height+'px; width:100%;">'
				  +'<div class="spinner" style="top:'+f_h+'px;position:relative;">'
				  +'<div class="rect1"></div>'
				  +'  <div class="rect2"></div>'
				  +'  <div class="rect3"></div>'
				  +'  <div class="rect4"></div>'
				  +'  <div class="rect5"></div>'
				  +'</div>';
				  +'</div>';
	function form_submit(form_id,noty,e)
	{
		var alerta = $('#form'); // alert div for show alert message
		var form = $('#'+form_id);
		//alert(form_id); return false;
		var can = '';
		if(!extra){
			var extra = '';
		}
		form.find('.summernotes').each(function() {
            var now = $(this);
            now.closest('div').find('.val').val(now.code());
        });
		
		//var form = $(this);
	    var formdata = false;
		if (window.FormData)
		{
	        formdata = new FormData(form[0]);
	    }
		var a = 0;
		var req = 'This field required';
		var take = '';
		form.find(".required").each(function(){
			var txt = '*'+req;
            a++;
            if(a == 1){
                take = 'scroll';
            }
            var here = $(this);
			if(here.val() == '')
			{
				if(!here.is('select'))
				{
                    here.css({borderColor: 'red'});
					if(here.attr('type') == 'number')
					{
                        txt = '*This field required';
                    }
                    
					if(here.closest('div').find('.badge-danger').length)
					{

					} 
					else 
					{
                        here.closest('div').append(''
                            +'  <span id="'+take+'" class="badge badge-danger" >'
                            +'      '+txt
                            +'  </span>'
                        );
                    }
				} 
				else if(here.is('select'))
				{
                    here.closest('div').find('.chosen-single').css({borderColor: 'red'});
					if(here.closest('div').find('.require_alert').length)
					{

					}
					else 
					{   
                           here.closest('div').append(''
                            +'  <span id="'+take+'" class="badge badge-danger" >'
                            +'      *Required'
                            +'  </span>'
                        );
                    }

                }
                var topp = 100;
				if(form_id == 'product_add' || form_id == 'product_edit')
				{
				} 
				else 
				{
	                $('html, body').animate({
	                      // scrollTop: $("#scroll").offset().top - topp
	                }, 500);
                }
                can = 'no';
            }

			if (here.attr('type') == 'email')
			{
				if(!isValidEmailAddress(here.val()))
				{
					here.css({borderColor: 'red'});
					if(here.closest('div').find('.badge-valid').length)
					{
	
					} 
					else 
					{	
						here.closest('div').append(''
							+'  <span id="'+take+'" class="badge badge-danger badge-valid" >'
							+'      *Enter valid Email'
							+'  </span>'
						);
					}
					can = 'no';
				}
			}

			take = '';
		});

		if(can !== 'no')
		{
			if(form_id !== 'vendor_pay')
			{
				//alert(base_url+'index.php/'+user_type+'/'+module+'/'+list_cont_func+'/'+extra,'list','first'); return false;
				//alert(form.attr('action')); return false;
				$.ajax({
					url: form.attr('action'), // form action url
					type: 'POST', // form submit method get/post
					dataType: 'html', // request type html/json/xml
					data: formdata ? formdata : form.serialize(), // serialize form data 
			        cache       : false,
			        contentType : false,
			        processData : false,
			        async: false,
					beforeSend: function() {
						var buttonp = $('.enterer');
						buttonp.addClass('disabled');
						buttonp.html('working');
					},
					success: function(data) {
					var obj = JSON.parse(data);
				
				if(!obj.response)
				{
					var buttonp = $('.enterer');
					buttonp.addClass('enabled');
					buttonp.html('Upload');
					notify(obj.message,'danger','top','right');
					
				}
				
				else
				{
					var buttonp = $('.enterer');
					buttonp.addClass('enabled');
					buttonp.html('Upload');
					notify(obj.message,'success','top','right');
					if(obj.is_redirect)
					{
						setTimeout(function () { top.location.href = obj.redirect_url; }, 800);
						return false;
					}
				}	
					},
					error: function(e) {
						console.log(e)
					}
				});
			}
			else 
			{	
				//form.html('fff');
				form.submit();
				//alert('ff');
				return false;
			}
		} 
		else 
		{
			if(form_id == 'product_add' || form_id == 'product_edit')
			{
				var ih = $('.require_alert').last().closest('.tab-pane').attr('id');		
				$("[href=#"+ih+"]").click();
			}
			//$('body').scrollTo('#scroll');
			return false;
		}
	}
	
	function ajax_load(url,id,type){
		var list = $('#'+id);
		$.ajax({
			url: url, // form action url
    		cache: false,
        	dataType: "html",
			beforeSend: function(){
				//list.fadeOut();
				if(type !== 'other'){
					list.html(loading); // change submit button text
				}
			},
			success: function(data) {
				if(data !== ''){
					list.html('');
					list.html(data).fadeIn(); // fade in response data
				}
				if(type == 'first'){
					$('#dataTable').DataTable();
					
					//set_switchery();
					$('#dataTable img').each(function() {
						if($(this).attr('src') !== ''){
							if($(this).data('im') !== 'fb'){
						    	$(this).attr('src', $(this).attr('src')+'?random='+new Date().getTime());
							}
						}
					});
				} else if(type=='form') {
					//reloadStylesheets();
			        $('#demo-tp-textinput').timepicker({
			            minuteStep: 5,
			            showInputs: false,
			            disableFocus: true
			        });
			        
				} else if(type=='delete') {
					ajax_load(base_url+'index.php/'+user_type+'/'+module+'/'+list_cont_func,'list','first');
					//other_delete();
					 
				} else if(type=='other') {
					other();
				} else {

				}
			},
			error: function(e) {
				console.log(e)
			}
		});
	}
	
	
		function isValidEmailAddress(emailAddress) {
		var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
		return pattern.test(emailAddress);
	}
		function delete_confirm(msg,id){
		//alert(base_url+'index.php/'+user_type+'/'+module+'/'+dlt_cont_func+'/'+id,'list','delete');
		// alert(id);
		// alert(msg); return false;
		msg = '<div class="modal-title">'+msg+'</div>';
		bootbox.confirm(msg, function(result) {
			if (result) 
			{
				ajax_load(base_url+user_type+'/'+module+'/'+dlt_cont_func+'/'+id,'list','delete');
				notify('Success','success','bottom','right');
			}
			else
			{
				notify('Cancelled','danger','bottom','right');
			};
		});
	}
	function delete_confirm_tab(msg,url){
		//alert(base_url+'index.php/'+user_type+'/'+module+'/'+dlt_cont_func+'/'+id,'list','delete');
		// alert(id);
		// alert(msg); return false;
		msg = '<div class="modal-title">'+msg+'</div>';
		bootbox.confirm(msg, function(result) {
			if (result) 
			{
				$.ajax({
					url: url, // form action url
					type: 'POST', // form submit method get/post
					dataType: 'html', // request type html/json/xml
					 cache       : false,
			        contentType : false,
			        processData : false,
			        async: false,
					
					success: function(data) {
					var obj = JSON.parse(data);
				
				if(!obj.response){
					
					notify(obj.message,'danger','top','right');
					
				}else{
					
					notify(obj.message,'success','top','right');
					if(obj.is_redirect){
						setTimeout(function () { top.location.href = obj.redirect_url; }, 800);
						return false;
					}
				}
						
						
					},
					error: function(e) {
						console.log(e)
					}
				});
			}
			else
			{
				notify('Cancelled','danger','bottom','right');
			};
		});
	}

	function delete_con(url){
		//var url  = '<?php echo base_url(); ?>toolplaza/delete_suppporting/'+mtr+'/'+id;
		var list = $('#supporting_file_list');
		var loading_set = '<div class="col-md-2"><div class="stat"><div class="stat-icon" style="color:#fa8564"><i class="fa fa-refresh fa-spin"></i></div></div></div>';
		
		$.ajax({
			url: url, // form action url
    		cache: false,
        	dataType: "html",
			beforeSend: function() {
				list.html(loading); // change submit button text
			},
			success: function(data) {
				if(data !== ''){
					list.html('');
					list.html(data).fadeIn(); // fade in response data
				}
			},
			error: function(e) {
				console.log(e)
			}
		});
	}
	

		$(document).on('click', '.paginate_button', function(e){
		 			$('#dataTable').DataTable();
					 $("[data-toggle='toggle']").bootstrapToggle('destroy')                 
		   			 $("[data-toggle='toggle']").bootstrapToggle(); 
		});
		$(document).on('change', '.custom-select', function(e){
 			$('#dataTable').DataTable();
					 $("[data-toggle='toggle']").bootstrapToggle('destroy')                 
		   			 $("[data-toggle='toggle']").bootstrapToggle(); 
});


	function approve_confirm(msg,id){
		//alert(base_url+'index.php/'+user_type+'/'+module+'/'+approve_cnt_fun+'/'+id,'list','delete');
		
		msg = '<div class="modal-title">'+msg+'</div>';
		bootbox.confirm(msg, function(result) {
			if (result) {
				//alert(result);
				ajax_load(base_url+user_type+'/'+module+'/'+approve_cnt_fun+'/'+id,'list','delete');
				notify('Success','success','bottom','right');
			}else{
				notify('Cancelled','danger','bottom','right');
			};
		});
	}

	function action_confirm(msg)
	{	
		msg = '<div class="modal-title">'+msg+'</div>';
		var action = $("#action").val();
		
		var values = []
		$("input[name='check[]']:checked").each(function ()
		{
		    values.push(parseInt($(this).val()));
			//alert(values);
		});
		
		values = values.toString();
		//alert(base_url+'index.php/'+user_type+'/'+module+'/'+action_cont_func+'/'+action+'/'+encodeURIComponent(values),'list','action'); return false;
		bootbox.confirm(msg, function(result) {
			if (result) {
				//alert(action); return;
				ajax_load(base_url+user_type+'/'+module+'/'+action_cont_func+'/'+action+'/'+encodeURIComponent(values),'list','action');
				var mesg = '';
				if (action == 'delete') {
					mesg = 'Deleted Successfully';
				}else if (action == 'active') {
					mesg = 'Active Successfully';
				}else if (action == 'inactive') {
					mesg = 'Inactive Successfully';
				}else{
					mesg = 'Some Thing Wrong! Try Again.';
				}
				notify('Success','success','bottom','right');
				
				
			}else{
				notify('Cancelled','danger','bottom','right');
				
			};
		});

	}
function notify(message,type,from,align){
	$.notify({
		message: message 
	},{
		// settings
		type: type,
		placement: {
			from: from,
			align: align
		}
	});
	
}

function ConfirmBox(heading, note, SendUrl, RedirectType){
	
	bootbox.confirm({
	title: heading,
	message: note,
	buttons: {
		cancel: {
			label: '<i class="fa fa-times"></i> Cancel',
			className: 'btn-danger'
		},
		confirm: {
			label: '<i class="fa fa-check"></i> Confirm',
			className: 'btn-success'
		}
	},
	callback: function (result) {
		if(result){
			if(RedirectType=='ajax'){
				  jQuery(function () 
				  {
					jQuery.ajax({                                      
						url: SendUrl,
						data: '',
						contentType: false,
						processData: false,
						cache: false,
						success: function(data)          //on recieve of reply
						{
							var obj = JSON.parse(data);
							
							if(!obj.response){
								notify(obj.message,'danger','bottom','right');
							}else{
								notify(obj.message,'success','bottom','right');
								if(obj.is_redirect){
									setTimeout(function () { top.location.href = obj.redirect_url; }, 800);
									return false;
								}
							}
						},
						error: function(XMLHttpRequest, textStatus, errorThrown) {
							notify('Could not complete your request. Please refresh page and try again.','danger','bottom','right');
						}
					});
				  }); 
			}else{
				top.location.href = SendUrl;
			}

		}
	}
	});
}

function ajax_html(url,id){
	var loading_set = '<div class="col-md-2"><div class="stat"><div class="stat-icon" style="color:#fa8564"><i class="fa fa-refresh fa-spin"></i></div></div></div>';
	var list = $('#'+id);
	$.ajax({
		url: url,
		beforeSend: function() {
			list.html(loading_set);
		},
		success: function(data) {
			list.html('');
			list.html(data).fadeIn();
			 $('#dataTable').DataTable();
			$("[data-toggle='toggle']").bootstrapToggle('destroy')                 
   			 $("[data-toggle='toggle']").bootstrapToggle();
		},
		error: function(e) {
			
			//notify('An error occurred. Please refresh page and try again.','danger','bottom','right');
		}
	});
}

