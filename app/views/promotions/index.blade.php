@extends("layout")
@section("content")
@include("menu")
<div>
    <div id="data">
	@if (count($promotions) > 0)
	    <table id="data">
	    <tr>
		    <th>IME</th><th class="narrow">DATUM</th><th class="narrow">ŠTEVILO PRIJAV</th><th class="last"></th>
	    </tr>
	    @foreach($promotions as $promotion)
	    <tr>
                    <td><a href="/admin/promotions/edit/{{ $promotion->id }}">{{ $promotion->name }}</a></td><td>{{ date("d.m.Y",strtotime($promotion->start_date)) }}</td><td>{{ @$promotion->user_count }}</td>
                    <td class="actions">
			<ul class="actions"> 
			    <!--{{ HTML::link('/admin/promotions/edit/'.$promotion->id, HTML::image('images/icons/edit.png', 'Uredi', array('id' => 'edit', 'title' => 'Uredi'))); }}-->
			    <li><a href="/admin/promotions/edit/{{ $promotion->id }}">{{HTML::image('images/icons/edit.png', 'Uredi', array('id' => 'edit', 'title' => 'Uredi'));}}</a></li>
			    <li><a href="/admin/promotions/duplicate/{{ $promotion->id }}" data-method="post">{{HTML::image('images/icons/edit_add.png', 'Podvoji', array('id' => 'duplicate', 'title' => 'Podvoji'));}}</a></li>
			    <li><a href="/admin/promotions/preview/{{ $promotion->id }}">{{HTML::image('images/icons/preview.png', 'Predogled', array('id' => 'preview', 'title' => 'Predogled'));}}</a></li>
			    <li><a onclick="addToPage(); return false;">{{HTML::image('images/icons/facebook-add.png', 'Dodaj na Facebook', array('id' => 'add', 'title' => 'Dodaj na Facebook'));}}</a></li>
			    <li><a href="/admin/promotions/stats/{{ $promotion->id }}" data-method="post">{{HTML::image('images/icons/statistics.png', 'Statistika', array('id' => 'statistika', 'title' => 'Statistika'));}}</a></li>
			    <li><a href="/admin/promotions/drop/{{ $promotion->id }}" id="empty">{{HTML::image('images/icons/trashcan_delete.png', 'Izprazni', array('id' => 'empty', 'title' => 'Izprazni'));}}</a></li>
			    <li><a href="/admin/promotions/delete/{{ $promotion->id }}" data-method="delete">{{HTML::image('images/icons/delete.png', 'Zbriši', array('id' => 'delete', 'title' => 'Zbriši'));}}</a></li>
			    
			</ul>
                    </td>
                </tr>
	    @endforeach
	</table>
	@else
	    <span class="empty">Dodana ni nobena promocija.{{ HTML::link('/admin/promotions/new/', 'Dodaj novo promocijo') }} </span>
	@endif
	
    </div>  
</div>
@stop