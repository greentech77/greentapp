@extends("layout")
@section("content")
@include("menu")
<div>
    <div id="data">
    <div id="details">NOVA PROMOCIJA</div>
    {{ Form::open(array('action' => array('PromotionController@addPromotion'),'files' => true)) }}
    <div id="left">
	    <table>
	    <tr><td>
		{{ Form::label('promotion-name', 'Ime promocije') }}
	    </td></tr>
	      <tr><td class="error" style="display: none;">{{ $errors->first('name') }}</td></tr>
	    <tr><td>
		@if ($errors->has('name'))
		{{ Form::text('name',Input::old('name'), [
			"placeholder" => $errors->first('name'),
			"class" => 'error'
		    ]) }}
		@else
		    {{ Form::text('name', Input::old('name'), [
			"placeholder" => "Ime promocije"
		    ]) }}
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
			'cols'    => 32,
			'placeholder' => 'Opis promocije'))
		    }}
		@endif	
	    	    </td></tr>
	    <tr>
		<td>{{ Form::label('start_date', 'Datum začetka') }}</td>
	    </tr>
	    <tr>
		<td>
		 @if ($errors->has('start_date'))
			{{ Form::text('start_date','', [
			    "placeholder" => $errors->first('start_date'),
			    "class" => 'error'
		    ]) }}
		@else
		    {{ Form::text('start_date', '', [
			"placeholder" => "Datum začetka"
		    ]) }}
		@endif
		</td>
	    </tr>
	     <tr>
		<td>{{ Form::label('end_date', 'Datum konca') }}</td>
	    </tr>
	    <tr>
		<td>
		@if ($errors->has('end_date'))
			{{ Form::text('end_date','',  [
			    "placeholder" => $errors->first('end_date'),
			    "class" => 'error'
		    ])  }}
		@else
		    {{ Form::text('end_date', '', [
			"placeholder" => "Datum konca"
		    ]) }}
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
		    {{ Form::text('question', '', [
			"placeholder" => "Vprašanje"
		    ]) }}
		@endif
	    </td></tr>
	    <tr><td>
		{{ Form::label('anwser1', 'Odgovor 1') }} {{ Form::radio('anwser', $id1, true) }}
	    </td></tr>
	    <tr><td>
		@if ($errors->has('anwser1'))
		    {{ Form::text('anwser1','', [
			"placeholder" => $errors->first('anwser1'),
			"class" => 'error'
		    ]) }}
		@else
		    {{ Form::text('anwser1', '', [
			"placeholder" => "Odgovor 1"
		    ]) }}
		@endif
	    </td></tr>
	    <tr><td>
		{{ Form::label('anwser2', 'Odgovor 2') }} {{ Form::radio('anwser', $id2 ) }}
	    </td></tr>
	    <tr><td>
		@if ($errors->has('anwser2'))
		    {{ Form::text('anwser2','', [
			"placeholder" => $errors->first('anwser2'),
			"class" => 'error'
		    ]) }}
		@else
		    {{ Form::text('anwser2', '', [
			"placeholder" => "Odgovor 2"
		    ]) }}
		@endif
	    </td></tr>
	    <tr><td>
		{{ Form::label('anwser3', 'Odgovor 3') }} {{ Form::radio('anwser', $id3 ) }}
	    </td></tr>
	    <tr><td>
		@if ($errors->has('anwser3'))
		    {{ Form::text('anwser3','', [
			"placeholder" => $errors->first('anwser3'),
			"class" => 'error'
		    ]) }}
		@else
		    {{ Form::text('anwser3', '', [
			"placeholder" => "Odgovor 3"
		    ]) }}
		@endif
	    </td></tr>
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
		{{ isset($uploaded_filename) ? HTML::image($uploaded_filename,  'screenshot',  array('id' => 'screenshot')) : HTML::image('http://placehold.it/500x346', 'screenshot',  array('id' => 'screenshot')) }}
		<!--img src="http://placehold.it/500x346" id="screenshot" /-->
	    </div>
	    </td></tr>
	    <tr><td>{{ Form::label('current-image', 'Gumb') }}</td></tr>
	    <tr><td>
	    <div id="gumb">
		{{ isset($uploaded_buttonname) ? HTML::image($uploaded_buttonname,  'buttonscreenshot',  array('id' => 'buttonscreenshot')) : HTML::image('http://placehold.it/163x30', 'buttonscreenshot',  array('id' => 'buttonscreenshot')) }}
		<!--img src="http://placehold.it/163x30" id="buttonscreenshot" /-->
	    </div>
	    </td></tr>
	</table>
	</div>
    {{ Form::close() }}
    </div>  
</div>
@stop

