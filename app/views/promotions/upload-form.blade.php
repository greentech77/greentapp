@extends("layout")
@section("content")
@include("menu")
<div>
    <div id="data">
    <div class="span8">
        <!-- Post Title -->
        <div class="row">
            <div class="span8">
                <h4>Ajax Image Upload and Preview With Laravel</h4>
            </div>
        </div>
        <!-- Post Footer -->
        <div class="row">
            <div class="span3">
                <div id="validation-errors"></div>
                <form class="form-horizontal" id="upload" enctype="multipart/form-data" method="post" action="{{ url('admin/promotions/upload/image') }}" autocomplete="off">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="file" name="image" id="image" />
                </form>
 
            </div>
            <div class="span5">
                <div id="output" style="display:none">
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
@stop
