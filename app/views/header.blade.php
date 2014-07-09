@section("header")
<div id="top-bar">
    <span>GreentApp</span>
    @if (Auth::check())
        <a href="{{ URL::route("user/logout") }}">Odjava</a>
    @endif
</div>
 <div id="container">
@show