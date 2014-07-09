@extends("layout")
@section("content")
@include("menu")
<div>
    <div id="data" style="background-image: url('http://greentapp.greentech.si{{ $promotion->background }}'); background-repeat:no-repeat;">
    <div id="questioncontent"  style="color:{{ $promotion->color }}">
        {{ $promotion->question }}
        
        <ul id="anwsers" style="color:{{ $promotion->color }}">
        @foreach($anwsers as $anwser)
            @if ($promotion->id_anwser==$anwser->id)
              <li>{{ Form::radio('anwser', $anwser->id, true)}} {{ Form::label('anwser',$anwser->anwser) }}</li>
            @else
              <li>{{ Form::radio('anwser', $anwser->id)}} {{ Form::label('anwser',$anwser->anwser) }}</li>
            @endif
        @endforeach
         </ul>
	
	<div id="button">
	    <a href="#" id="submit" class="submit" style="background-image: url('{{ $promotion->button }}')">Naprej</a>
	</div>
    </div>  
</div>
@stop