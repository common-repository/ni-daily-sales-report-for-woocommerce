jQuery(document).ready(function ($) {
	$('body').on('focus',"._datepicker", function(){
		$(this).datepicker({
			dateFormat: 'yy-mm-dd',
			changeMonth: true,
			changeYear: true,
			showButtonPanel: true
		});
	});
	
	
	$("#frm_daily_report").submit(function (event) {
		
		$.ajax({
			url: nidsrfw_ajax_object.nidsrfw_ajaxurl,
			data: $(this).serialize(),
			success: function (response) {
				//alert(JSON.stringify(response));	
				$("._nidsrfw_ajax_content").html(response);			
			},
			error: function (response) {
				alert(JSON.stringify(response));		
				
			}
		});
		return false;
	});
	$('#frm_daily_report').trigger('submit');
})