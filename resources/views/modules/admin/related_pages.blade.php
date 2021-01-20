@php
    use App\Models\Category;
    $categories = Category::all();
    $relPageCatId = "";
    $bgClass = '';

    if (isset($parameters['rel_page_category'])) {
        $relPageCatId = (int)$parameters['rel_page_category'];
    }

    if (isset($parameters['bg_rel_class'])) {
        $bgClass = $parameters['bg_rel_class'];
    }
@endphp

<h3 class="text-center">Related pages module:</h3>

<div class="form-group">
    <label>Related pages category:</label>
    <select name="parameters[rel_page_category]" class="form-control">
        <option value="">Not selected</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}"
                    @if($relPageCatId === $category->id) selected @endif>{{ $category->name }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label>Background class:</label>
    <input class="form-control" name="parameters[bg_rel_class]" placeholder="Example - bg-light" value="{{ $bgClass }}" />
</div>
