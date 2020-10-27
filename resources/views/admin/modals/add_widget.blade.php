@extends('modal')

@section('title')
    Add widget:
@endsection

@section('body')

<div class="d-none alert alert-danger">
</div>

<form action="{{ route('admin.modal.add-widget') }}" id="modal-form" method="post">
    @csrf
    <div class="modal-body">
        <div class="form-group">
            <select class="form-control" id="widget_id" name="widget_id">
                <option value="">No widget selected</option>
                @foreach (\App\Models\Widget::WIDGET_LABELS as $key => $widget)
                    <option value="{{ $key }}">{{ $widget }}</option>  
                @endforeach
            </select>
        </div>
    </div>
</form>
@endsection

@section('footer')

<button type="button" id="submit_modal_form" class="btn btn-primary">Select</button>

@endsection