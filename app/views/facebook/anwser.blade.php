@extends("layoutfb")
 
@section("content")
<body background="{{ $promotion->background }}" style="background-repeat:no-repeat;">
<div id="fb-root"></div>
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '1380859678822234',
          status     : true,
          xfbml      : true
        });
      };

      (function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "https://connect.facebook.net/en_US/all.js";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));

	function Reload()
	{
	 top.location.href="<?php echo $link ?>";
	 window.history.go(-1);
	}
    </script
<div>
    {{ Form::open(array('action' => array('FacebookController@checkAnwsers'))) }}
    <div id="questioncontent"  style="color:{{ $promotion->color }}">
        @if ($promotion->id_anwser==$correctId)
        Vaš odgovor je pravilen! <br>
        Hvala za sodelovanje v nagradni igri. <br>
        Nagrajence bomo obvestili po elektronski pošti.
        <div id="button">
                <!--img src="{{ $promotion->button }}" /-->
                <!--a href="#" id="submit" class="submit" style="background-image: url('{{ $promotion->button }}')">Naprej</a-->
                <input type="button" class="submit" id="submit" OnClick="javascript:nazid()" value="Povabi prijatelje" style="background-image: url('{{ $promotion->button }}')" />
        </div>
        <script>
	function nazid() {
                FB.ui({method: 'apprequests',
                    message: 'Odgovori na nagradno vprašanje in sodeluj v nagradni igri!',
                    filters: ['app_non_users'],
                    link : "<?php echo $link ?>", 
                },
                function(response) {
                if (response){
                        $.ajax({
                            type: "POST",
                            url: "save_num_invites.php",
                            data: "req_ids="+ response.to,
                       });
                    }
		    FB.ui({ method : 'feed',
			name : "{{ $promotion->name }}",
			link : "<?php echo $link?>", 
			description: "{{ $promotion->description }}",
			caption: " ",
			picture: 'http://greentapp.greentech.si/images/greentapp-logo-fb.png' //najdi nek primeren logo za aplikacijo
		    },
		    function(response) {
		    if (response){
                        $.ajax({
                            type: "POST",
                            url: "save_num_shares.php",
                            data: "numshares="+ 1,
                        });
		    }
		});
	    });
	}
    </script>
        @else
           Vaš odgovor je napačen! <br>
          Prosimo poskusite ponovno.
          <div id="button">
          <a href="javascript:Reload()" id="submit" class="submit" style="background-image: url('{{ $promotion->button }}')">Poizkusi znova</a>
          </div>
        @endif
    </div>
    {{ Form::close() }}
</div>
@stop