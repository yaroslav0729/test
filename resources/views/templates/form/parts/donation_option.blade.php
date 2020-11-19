<div class="row border border-secondary option rounded p-2 mb-3">
    <div class="col-md-6">
        <div class="form-group">
            <label>Donation amount</label><br>
            <input name="parameters[amount][]" type="number"
                @isset($donationValue) value={{ $donationValue }} @endisset
                placeholder="Enter amount" class="form-control" />
            <input name="parameters[amount_type][]" type="hidden" value="{{ $donationType }}" class="form-control" />
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>Donation text</label><br>
            <textarea class="form-control" name="parameters[amount_text][]" placeholder="Enter text here...">@isset($donationText){{ $donationText }}@endisset</textarea>
        </div>
    </div>
    <div class="col-md-12">
        <hr>
        <button type="button" option-delete class="btn btn-small btn-danger"><i class="far fa-trash-alt"></i></button>
    </div>    
</div>