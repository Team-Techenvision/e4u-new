$(function() {
  $(".navbar-expand-toggle").click(function() {
    $(".app-container").toggleClass("expanded");
    return $(".navbar-expand-toggle").toggleClass("fa-rotate-90");
  });
  return $(".navbar-right-expand-toggle").click(function() {
    $(".navbar-right").toggleClass("expanded");
    return $(".navbar-right-expand-toggle").toggleClass("fa-rotate-90");
  });
});

$(function() {
  //return $('select').select2();
});

$(function() {
  return $('.toggle-checkbox').bootstrapSwitch({
    size: "small"
  });
});

$(function() {
  return $('.match-height').matchHeight();
});
/*
$(function() {
  return $('.datatable').DataTable({
    "dom": '<"top"fl<"clear">>rt<"bottom"ip<"clear">>'
  });
});
*/
/**
	   * it is used to Bulk data's more action performed
	   * @()
	*/
	$('#selecctall').click(function(event) {  //on click
		$('.js-checkbox-all').attr('checked',false);
        if(this.checked) { // check select status
            $('.js-checkbox-all').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "js-checkbox" 
				$('#rowclick1 tr').filter(':has(:checkbox:checked)').addClass('selectrow');
				$('#rowclick1 tr').filter(':has(:checkbox:unchecked)').removeClass('selectrow');
            });
        }else{
            $('.js-checkbox-all').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "js-checkbox"
				$('#rowclick1 tr').filter(':has(:checkbox:checked)').addClass('selectrow');
				$('#rowclick1 tr').filter(':has(:checkbox:unchecked)').removeClass('selectrow');
            });        
        }
    });
	
	$('.js-more-action').change(function(event) {  //on click
	//$('.js-more-action').live('change',function(){
		var flag = 0;
		var job=document.getElementsByName('checkall_box[]');
		for(var i=0;i<job.length;i++) {
			 if(job[i].checked == true){
				flag++;
			}
		}
		if ( $("#MoreActionId").val() == "") {
			return false;
		} else if (flag == 0) {
            alert('Please select atleast one record!');
            $('#MoreActionId').val('');	
            return false;
        } else{
            if (window.confirm('Are you sure you want to do this action?')) {
				//console.log($(this).parents('form').submit());
                //$(this).parents('form').submit();
				//console.log(document.forms[0]);
				var  form_count = $( "form" ).length - 1;
				document.forms[form_count].submit();
            }else{			
				$('#rowclick1 tr').filter(':has(:checkbox:checked)').trigger('click');			
				$('#selecctall').attr('checked',false);		
				$('#MoreActionId').val('');	
						
			}
        }
	});

$('a.delete-con').click(function(event) { 
		if (window.confirm("Are you sure want to delete this record?")) {
			if (window.confirm("if you continue to delete, all the child records were also deleted")) {
				return true;
			}else {
				return false;
			}
		} else {
			return false;
		}
	});
	
$('a.cancel-con').click(function(event) { 		
		if (window.confirm("Are you sure want to cancel this order?")) {
			return true;
		} else {
			return false;
		}
	});

$('a.change_status').click(function(event) { 
		if (window.confirm("Are you sure want to change status?")) {
				return true;
			} else {
			return false;
		}
	});
