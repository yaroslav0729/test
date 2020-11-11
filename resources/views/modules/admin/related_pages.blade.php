@php
    $relPageCatId = "";
    
    if (isset($parameters['rel_page_category'])) {
        $relPageCatId = (int)$parameters['rel_page_category'];    
    }
@endphp

<div class="form-group">
    <label>Related pages category:</label>
    <select name="parameters[rel_page_category]" class="form-control">
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" @if($relPageCatId === $category->id) selected @endif>{{ $category->name }}</option>
        @endforeach
    </select>
</div>