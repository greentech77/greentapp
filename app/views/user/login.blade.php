@extends("layout")
@section("content")
<div id="login">
    PRIJAVA
    <div class="login-form">
        <table id="login">
    {{ Form::open() }}
        <tr><td>{{ Form::text("username", Input::get("username"), [
            "placeholder" => "Uporabniško ime"
        ]) }}
        </td>
        </tr>
        <tr><td>{{ Form::password("password", [
            "placeholder" => "••••••••••"
        ]) }}
        </td></tr>
        @if ($error = $errors->first("password"))
         <tr><td class="error">
                {{ $error }}
            </td>
        </tr>
        @endif
         <tr><td id="submit">{{ Form::submit("Prijava") }}</td></tr>
         <tr><td>{{ HTML::link('login/fb', 'Facebook prijava') }}</td></tr>
         <tr><td>{{ HTML::link('user/register', 'Registracija novega uporabnika') }}</td></tr>
    {{ Form::close() }}
</table>
</div>
</div>
@stop