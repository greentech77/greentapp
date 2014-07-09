@extends("layoutfb")
 
@section("content")
<body background="{{ $promotion->background }}" style="background-repeat:no-repeat;">
    echo '<input type="button" id="login-first" class="submit" OnClick="facebookLogin();" value="Vstopi v nagradno igro" />';
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
            @if ($promotion->id_anwser==$anwser->id)
              <li>{{ Form::radio('anwser', $anwser->id, true)}} {{ Form::label('anwser',$anwser->anwser) }}</li>
            @else
              <li>{{ Form::radio('anwser', $anwser->id)}} {{ Form::label('anwser',$anwser->anwser) }}</li>
            @endif
        @endforeach
         </ul>
        <div id="button">
                <!--img src="{{ $promotion->button }}" /-->
                <!--a href="#" id="submit" class="submit" style="background-image: url('{{ $promotion->button }}')">Naprej</a-->
                <input type="submit" value="Naprej" class="submit" id="submit" style="background-image: url('{{ $promotion->button }}')">
        </div>
        @endif
    </div>
    {{ Form::close() }}
</div>
@stop