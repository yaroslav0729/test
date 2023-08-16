@csrf
                
<div class="form-group">
    <label for="text">Text</label><br>
    @if(!empty($textValues))
        <select class="form-control" name="text">
            @foreach ($textValues as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
    @else
        <input id="text" name="text" class="form-control" type="text" value="{{ $text }}" />
    @endif
</div>

@if(!$isMenuAdditional)
    <div class="form-group">
        <div class="form-check">

            @if (is_null($groupCheckboxDisabled))
                <input type="hidden" name="is_group" value="0">
            @endif

            <input type="checkbox" class="form-check-input" id="is_group" name="is_group" value="1" {{ $groupCheckboxChecked }} {{ $groupCheckboxDisabled }} >

            <label class="form-check-label" for="is_group">Is group</label>
        </div>
    </div>
@endif

<div class="form-group">
    <label for="link">Link</label><br>
    <input id="link" name="link" class="form-control" value="{{ $link }}" {{ $linkInputDisabled }} />
</div>

<button class="btn btn-info" type="submit">
    Submit
</button>