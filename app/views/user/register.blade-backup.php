@extends("layout")
@section("content")
<div id="login">
    REGISTRACIJA NOVEGA UPORABNIKA
    <div class="login-form">
        {{ Form::open(array('action' => array('UserController@registerAction'),'files' => true)) }}
        <table id="register">
        <tr><td>
		{{ Form::label('name', 'Ime in priimek') }}
	    </td>
        <td>{{ Form::text("name", Input::get("username"), [
            "placeholder" => "ime in priimek"
        ]) }}
        </td>
        <tr><td>
		{{ Form::label('uporabnsiko-ime', 'Uporabniško ime') }}
	    </td>
        <td>{{ Form::text("username", Input::get("username"), [
            "placeholder" => "uporabniško ime"
        ]) }}
        </td>
        </tr>
	<tr><td>
		{{ Form::label('email', 'E-mail') }}
	    </td>
        <td>{{ Form::text("email", Input::get("email"), [
            "placeholder" => "email"
        ]) }}
        </td>
        </tr>
        <tr>
        <td>
	    {{ Form::label('password', 'Geslo') }}
	</td>
        <td>{{ Form::password("password", [
            "placeholder" => "••••••••••"
        ]) }}
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