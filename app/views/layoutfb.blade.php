<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width">
	     
            <title>GreentApp</title>
	{{ HTML::style('css/style.css') }}
	{{ HTML::style('http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css') }}
	{{ HTML::script('script/jquery-1.10.2.min.js') }}
	{{ HTML::script('http://code.jquery.com/ui/1.9.2/jquery-ui.js') }}
	{{ HTML::script('script/jquery.form.min.js') }}
	{{ HTML::script('script/date_si.js') }}
	{{ HTML::script('script/script.js') }}
	
   <script>
   function facebookLogin()
   {
     //FB.login(onFacebookInitialLoginStatus, {perms:'email,read_stream,publish_stream'});
     
      FB.login(function(response) {
        if (response.authResponse) {
          //console.log('Welcome!  Fetching your information.... ');
          FB.api('/me', function(response) {
            //alert('test');
            //console.log('Good to see you, ' + response.name + '.');
            top.location.href = "https://www.facebook.com/otroskaakademija/app_1417051005218245"; //spremeni dinamièno
          });
        } else {
          //console.log('User cancelled login or did not fully authorize.');
        }
      });
   }
   </script>
	
    </head>
                @yield("content")
         </body>
</html>