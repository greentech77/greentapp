$(document).ready(function() {


$("input").click(function() {
  $(this).removeClass("error");
});

$("#startdate").click(function() {
  $(this).removeClass("error");
});

$("#enddate").click(function() {
  $(this).removeClass("error");
});

$("textarea").click(function() {
  $(this).removeClass("error");
});

$("#submit").click(function() {
  
});

$(function(){
    $('[data-method="delete"]').append(function(){
        return "\n"+
        "<form action='"+$(this).attr('href')+"' method='POST' style='display:none'>\n"+
        "<input type='hidden' name='_method' value='"+$(this).attr('data-method')+"'>\n"+
        "</form>\n"
    })
    .removeAttr('href')
    .attr('style','cursor:pointer;')
    .attr('onclick','$(this).find("form").submit();');
    
    $('[data-method="post"]').append(function(){
        return "\n"+
        "<form action='"+$(this).attr('href')+"' method='POST' style='display:none'>\n"+
        "<input type='hidden' name='_method' value='"+$(this).attr('data-method')+"'>\n"+
        "</form>\n"
    })
    .removeAttr('href')
    .attr('style','cursor:pointer;')
    .attr('onclick','$(this).find("form").submit();');
    
    $('#empty').append(function(){
        return "\n"+
        "<form action='"+$(this).attr('href')+"' method='POST' style='display:none'>\n"+
        "<input type='hidden' name='_method' value='delete'>\n"+
        "</form>\n"
    })
    .removeAttr('href')
    .attr('style','cursor:pointer;')
    .attr('onclick','$(this).find("form").submit();');
    
    $("ul.tabs").tabs("div.panes > div");
});

var options = {
        success:       showResponse,
        dataType: 'json'
        }; 
    $('body').delegate('#image','change', function(){
        /*$('#data').ajaxForm(options).submit();
	alert($('#image')[0].files[0].name);*/
	
	/*podatki='file='+$('#image')+'& name='+$('#name');
	
	//alert($('#image').attr("value"));
	
	
	 $.ajax({
            url : '/admin/promotions/upload/image',
            type: 'post',
            dataType: 'json',
	    data: podatki,
	    success: function(response){
		 $("div#image").html("<img src='"+response.file+"' />");
		 $("div#image").css('display','block');
	    }
        });*/
        return false;
    }); 

});

function showResponse(response, statusText, xhr, $form)  {
	if(response.success == false)
	{
		var arr = response.errors;
		$.each(arr, function(index, value)
		{
			if (value.length != 0)
			{
				$("#validation-errors").append('<div class="alert alert-error"><strong>'+ value +'</strong><div>');
			}
		});
		$("#validation-errors").show();
	} else {
		 $("div#output").html("<img src='"+response.file+"' />");
		 $("div#image").css('display','block');
	}
}





