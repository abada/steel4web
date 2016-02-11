@if ($errors->any())
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        @foreach ($errors->all() as $error)
            {!! $error !!}<br/>
        @endforeach
    </div>
@elseif (Session::get('flash_success'))
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        @if(is_array(json_decode(Session::get('flash_success'), true)))
            {!! implode('', Session::get('flash_success')->all(':message<br/>')) !!}
        @else
            {!! Session::get('flash_success') !!}
        @endif
    </div>
@elseif (Session::get('flash_warning'))
    <div class="alert alert-warning">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        @if(is_array(json_decode(Session::get('flash_warning'), true)))
            {!! implode('', Session::get('flash_warning')->all(':message<br/>')) !!}
        @else
            {!! Session::get('flash_warning') !!}
        @endif
    </div>
@elseif (Session::get('flash_info'))
    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        @if(is_array(json_decode(Session::get('flash_info'), true)))
            {!! implode('', Session::get('flash_info')->all(':message<br/>')) !!}
        @else
            {!! Session::get('flash_info') !!}
        @endif
    </div>
@elseif (Session::get('flash_danger'))
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        @if(is_array(json_decode(Session::get('flash_danger'), true)))
            {!! implode('', Session::get('flash_danger')->all(':message<br/>')) !!}
        @else
            {!! Session::get('flash_danger') !!}
        @endif
    </div>
@elseif (Session::get('flash_message'))
    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        @if(is_array(json_decode(Session::get('flash_message'), true)))
            {!! implode('', Session::get('flash_message')->all(':message<br/>')) !!}
        @else
            {!! Session::get('flash_message') !!}
        @endif
    </div>
@elseif (Session::get('ApWarning'))
    <div class="alert alert-warning">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        @if(is_array(json_decode(Session::get('ApWarning'), true)))
            {!! implode('', Session::get('ApWarning')->all(':message<br/>')) !!}
        @else
            {!! Session::get('ApWarning') !!}
        @endif
    </div>
@elseif (Session::get('ApDanger'))
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        @if(is_array(json_decode(Session::get('ApDanger'), true)))
            {!! implode('', Session::get('ApDanger')->all(':message<br/>')) !!}
        @else
            {!! Session::get('ApDanger') !!}
        @endif
    </div>
@elseif (Session::get('ApSuccess'))
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        @if(is_array(json_decode(Session::get('ApSuccess'), true)))
            {!! implode('', Session::get('ApSuccess')->all(':message<br/>')) !!}
        @else
            {!! Session::get('ApSuccess') !!}
        @endif
    </div>
@endif

<?php 
    if(\Session::get('ApWarning'))
            \Session::forget('ApWarning');
        if(\Session::get('ApDanger'))
            \Session::forget('ApDanger');
        if(\Session::get('ApSuccess'))
            \Session::forget('ApSuccess');
 ?>
