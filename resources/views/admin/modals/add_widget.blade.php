@extends('modal')

@section('title')
    Add widget:
@endsection

@section('body')

<div class="modal-body">
    <div class="form-group">
        <select class="form-control" id="add_new_widget">
            <option value="0">No widget selected</option>
            @foreach (\App\Models\Widget::WIDGET_LABELS as $key => $widget)
                <option value="{{ $key }}">{{ $widget }}</option>  
            @endforeach
        </select>
    </div>
</div>
@endsection

@section('footer')

<button type="button" class="btn btn-primary" data-dismiss="modal">Select</button>

@endsection