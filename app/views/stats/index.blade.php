@extends("layout")
@section("content")
@include("menu")
<div>
    <div id="data">
	<table id="data">
	    <tr>
		    <th>IME</th><th class="narrow">Spol</th><th class="narrow">IP naslov</th><th class="narrow">Datum</th>
	    </tr>
	    @foreach($stats as $stat)
	    <tr>
                    <td>{{ $stat->name }}</td><td>{{ $stat->gender }}</td><td>{{ $stat->ip }}</td><td>{{ date('d.m.Y H:i',strtotime($stat->votetime)) }}</td>
             </tr>     
	    @endforeach
	</table>
    </div>  
</div>
@stop