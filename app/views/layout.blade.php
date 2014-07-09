<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width">
	     
        <title>GreentApp</title>
	{{ HTML::style('css/style.css') }}
	{{ HTML::style('http://fonts.googleapis.com/css?family=Roboto&subset=latin,latin-ext') }}
	{{ HTML::style('http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css') }}
	{{ HTML::script('script/jquery-1.10.2.min.js') }}
	{{ HTML::script('script/jquery-ui.js') }}
	{{ HTML::script('script/jquery-ui-timepicker-addon.js') }}
	{{ HTML::script('script/jquery.form.min.js') }}
	{{ HTML::script('script/date_si.js') }}
	{{ HTML::script('script/script.js') }}
	{{ HTML::script('script/jquery.tools.min.js') }}

	  <script>
		    var dateToday = new Date();
	    
		    $(function() {
			$( "#start_date" ).datetimepicker({dateFormat: 'dd.mm.yy',timeFormat: 'HH:mm',timeOnlyTitle: 'Samo čas',
			    timeText: 'Čas',
			    hourText: 'Ura',
			    minuteText: 'Minuta',
			    secondText: 'sekunda',
			    currentText: 'Zdaj',
			    closeText: 'Zapri',
			    /*minDate: dateToday,*/
			    defaultDate: null
			    });
			
			$( "#end_date" ).datetimepicker({dateFormat: 'dd.mm.yy',timeFormat: 'HH:mm',timeOnlyTitle: 'Samo čas',
			    timeText: 'Čas',
			    hourText: 'Ura',
			    minuteText: 'Minuta',
			    secondText: 'sekunda',
			    currentText: 'Zdaj',
			    closeText: 'Zapri',
			    //minDate: dateToday,
			    defaultDate: null});
		    });
		    
	 </script>
	<div id='fb-root'></div>
	<script src='http://connect.facebook.net/en_US/all.js'></script>
	  <script type="text/javascript">
	  
	  FB.init({appId: "1380859678822234", status: true, cookie: true});
	    function addToPage() {
	      // calling the API ...
	      var obj = {
		method: 'pagetab'
	      };
	      FB.ui(obj);
	    }
	  
	    function readURL(input) {
		if (input.files && input.files[0]) {
		    var reader = new FileReader();
	    
		    reader.onload = function (e) {
			$('#screenshot').attr('src', e.target.result).css(
			{
			    'width': '500',
			    'height': '346'
			});
		    };
		    reader.readAsDataURL(input.files[0]);
		}
	    }
	    
	    function readButton(input) {
		if (input.files && input.files[0]) {
		    var reader = new FileReader();
		    
		    reader.onload = function (e) {
			$('#buttonscreenshot').attr('src', e.target.result).css(
			{
			    'width': '163',
			    'height': '30'
			});
			
		    };
		    reader.readAsDataURL(input.files[0]);
		}
	    }
	</script>
    </head>
    <body>
        @include("header")
                @yield("content")
            </div>
        @include("footer")
    </body>
</html>