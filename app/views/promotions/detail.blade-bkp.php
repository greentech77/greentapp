@extends("layout")
@section("content")
@include("menu")
<div>
    <div id="data">	
    <div id="details"></div>
	{{ Form::model($promotion, array('action' => array('PromotionController@updatePromotion', $promotion->id),'files' => true)) }}
	
    <div id="left">
	@if($errors->has())
	    @foreach ($errors->all() as $error)
		<div>{{ $error }}</div>
	    @endforeach
	@endif
	    <table>
	    <tr><td>
		{{ Form::label('promotion-name', 'Ime promocije') }}
	    </td></tr>
	    <tr><td>
	    @if ($errors->has('name'))
		{{ Form::text('name','', [
			"placeholder" => $errors->first('name'),
			"class" => 'error'
		    ]) }}
	    @else
		{{ Form::text('name') }}
	    @endif
	    </td></tr>
	    <tr><td>
		{{ Form::label('promotion-desc', 'Opis promocije') }}
	    </td></tr>
	    <tr><td colspan="2">
	    
	    @if ($errors->has('description'))
		{{ Form::textarea('description', null, array(
		    'id'      => 'description',
		    'rows'    => 10,
		    'cols'    => 32,
		    'class'   => 'error',
		    'placeholder' => $errors->first('description')))
		}}
	    @else
		{{ Form::textarea('description', null, array(
		    'id'      => 'description',
		    'rows'    => 10,
		    'cols'    => 32))
		}}
	    @endif
	    </td></tr>
	    <tr>
		<td>{{ Form::label('start_date', 'Datum začetka') }}</td>
	    </tr>
	    <tr>
		<td>
		    @if ($errors->has('start_date'))
			{{ Form::text(date('d.m.Y H:i',strtotime($promotion->start_date)),'', [
			    "placeholder" => $errors->first('start_date'),
			    "class" => 'error'
		    ]) }}
		    @else
			{{ Form::text('start_date', date('d.m.Y H:i',strtotime($promotion->start_date))) }}
		    @endif
		</td>
	    </tr>
	     <tr>
		<td>{{ Form::label('end_date', 'Datum konca') }}</td>
	    </tr>
	    <tr>
		<td>
		    @if ($errors->has('end_date'))
			{{ Form::text('end_date',date('d.m.Y H:i',strtotime($promotion->end_date)),'',  [
			    "placeholder" => $errors->first('end_date'),
			    "class" => 'error'
		    ])  }}
		    @else
			{{ Form::text('end_date',date('d.m.Y H:i',strtotime($promotion->end_date))) }}
		    @endif
		</td>
	    </tr>
	    </table>
	    {{ Form::submit('Shrani') }}
	
    </div>
    <div id="left">
	<table id="middle">
	    <tr><td>
		{{ Form::label('question', 'Vprašanje') }}
	    </td></tr>
	    <tr><td>
		    @if ($errors->has('question'))
			{{ Form::text('question','', [
			    "placeholder" => $errors->first('question'),
			    "class" => 'error'
		    ]) }}
		    @else
			{{ Form::text('question') }}
		    @endif
		
	    </td></tr>
	    <@foreach($anwsers as $anwser)
		@if ($promotion->id_anwser==$anwser->id)
		<tr>
		    <td>{{ Form::label('anwser', 'Odgovor '.$i++) }} {{ Form::radio('anwser', $anwser->id, true) }}</td>
		</tr>
		@else
		     <td>{{ Form::label('anwser', 'Odgovor '.$i++) }} {{ Form::radio('anwser', $anwser->id) }}</td>
		@endif
		<tr><td>
		    @if ($errors->has('anwser'.$j))
			{{ Form::text('anwser'.$j++,'',  [
			"placeholder" => $errors->first('anwser'.$k++),
			"class" => 'error'
		    ]) }}
		    @else
			{{ Form::text('anwser'.$j++,$anwser->anwser) }}
		    @endif
		    
	    </td></tr>
	    @endforeach
	    <tr><td>
		{{ Form::label('color', 'Barva teksta') }}
	    </td></tr>
	    <tr><td>
		    @if ($errors->has('color'))
			{{ Form::input('color','color', array('class' => 'error')) }}
		    @else
			{{ Form::input('color', 'color') }}
		    @endif
	    </td></tr>
	    <tr><td>
		{{ Form::label('image', 'Slika') }}
	    </td></tr>
	    <tr><td>
		    @if ($errors->has('image'))
			{{Form::file('image', array('onchange' => 'readURL(this);', 'class' => 'error'))}}
		    @else
			{{Form::file('image', array('onchange' => 'readURL(this);'))}}
		    @endif
		
	    </td></tr>
	    <tr><td>
		{{ Form::label('button', 'Gumb') }}
	    </td></tr>
	    <tr><td>
		    @if ($errors->has('button'))
			{{Form::file('button', array('onchange' => 'readButton(this);', 'class' => 'error'))}}
		    @else
			{{Form::file('button', array('onchange' => 'readButton(this);'))}}
		    @endif
		
	    </td></tr>
	</table>
    </div>
    <div id="left">
	<table>
	    <tr><td>{{ Form::label('current-image', 'Trenutna slika') }}</td></tr>
	    <tr><td>
	    <div id="image">
		<img src="{{ $images->background }}" id="screenshot" />
	    </div>
	    </td></tr>
	    <tr><td>{{ Form::label('current-image', 'Gumb') }}</td></tr>
	    <tr><td>
	    <div id="gumb">
		<img src="{{ $images->button}}" id="buttonscreenshot" />
	    </div>
	    </td></tr>
	</table>
	</div>
    {{ Form::close() }}
    </div>  
</div>
@stop

