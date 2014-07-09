@extends("layout")
@section("content")
<div id="login">
    REGISTRACIJA NOVEGA UPORABNIKA
    @foreach($errors as $error)
        {{ $error }}
    @endforeach
    <div class="login-form">
        {{ Form::open(array('action' => array('UserController@registerAction'),'files' => true)) }}
        <table id="register">
        <tr><td>
		{{ Form::label('name', 'Ime in priimek') }}
	    </td>
        <td>
	    @if ($errors->has('name'))
	       {{ Form::text("name", '', array('class' => 'error'), ["placeholder" => "ime in priimek"]) }}
	    @else
	       {{ Form::text("name", '', ["placeholder" => "ime in priimek"]) }}
	    @endif
        </td>
        <tr><td>
		{{ Form::label('uporabnsiko-ime', 'Uporabniško ime') }}
	    </td>
        <td>
	    @if ($errors->has('name'))
	       {{ Form::text("username",'',array('class' => 'error'), ["placeholder" => "uporabniško ime" ]) }}
	    @else
	       {{ Form::text("username", '', ["placeholder" => "uporabniško ime" ]) }}
	    @endif
        </td>
        </tr>
	<tr><td>
		{{ Form::label('email', 'E-mail') }}
	    </td>
        <td>
	    @if ($errors->has('email'))
	       {{ Form::text("email", '',array('class' => 'error'), ["placeholder" => "email"]) }}
	    @else
	       {{ Form::text("email", '', ["placeholder" => "email"]) }}
	    @endif
        </td>
        </tr>
        <tr>
        <td>
	    {{ Form::label('password', 'Geslo') }}
	</td>
        <td>
	    @if ($errors->has('password'))
	       {{ Form::password("password", '', array('class' => 'error'), ["placeholder" => "••••••••••"]) }}
	    @else
	       {{ Form::password("password", ["placeholder" => "••••••••••"]) }}
	    @endif
	    
        </td></tr>
        @if ($error = $errors->first("password"))
         <tr><td class="error">
                {{ $error }}
            </td>
        </tr>
        @endif
         <tr>
	    <td id="summit">
		{{ Form::submit("Registracija") }}
	 </td></tr>
    {{ Form::close() }}
</table>
</div>
</div>
@stop
@section("footer")
    @parent
    <script src="//polyfill.io"></script>
@stop