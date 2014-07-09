@extends("layoutfb")
 
@section("content")
@if ($empty==1)
<body background="/public/images/ozadje.png" style="background-repeat:no-repeat;">
    <div id="noentries" class="noentries">
        Trenutno ni aktvnih nagradnih iger!
    </div>
</body>
@elseif ($empty==0))
<body background="{{ $promotion->background }}" style="background-repeat:no-repeat;">
    {{ Form::open(array('action' => array('FacebookController@checkAnwsers'))) }}
    <div id="questioncontent"  style="color:{{ $promotion->color }}">
        @if (isset($notliked))
              Klikni "Like" in sodeluj<br />
              v nagradni igri!
        @elseif (isset($promotion))
        {{ $promotion->question }}
        <input type="hidden" name="link" value="{{ $link }}">
        <ul id="anwsers" style="color:{{ $promotion->color }}">
        @foreach($anwsers as $anwser)
            @if ($i++==1)
              <li>{{ Form::radio('anwser', $anwser->id, true)}} {{ Form::label('anwser',$anwser->anwser) }}</li>
            @else
              <li>{{ Form::radio('anwser', $anwser->id)}} {{ Form::label('anwser',$anwser->anwser) }}</li>
            @endif
        @endforeach
         </ul>
        <div id="button">
                <input type="submit" value="Naprej" class="submit" id="submit" style="background-image: url('{{ $promotion->button }}')">
        </div>
        @endif
    </div>
    {{ Form::close() }}
</div>
@endif
@stop