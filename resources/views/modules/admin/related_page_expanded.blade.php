@php
    use App\Models\Category;
    $relPageTitle = "";
    $relPageLinkTitle = "";
    $relPageLink = "";
    $bgClass = "";
    $bgClassMobile = "";

    if (isset($parameters['rel_page_title'])) {
        $relPageTitle = $parameters['rel_page_title'];
    }

    if (isset($parameters['rel_page_link_title'])) {
        $relPageLinkTitle = $parameters['rel_page_link_title'];
    }

    if (isset($parameters['rel_page_link'])) {
        $relPageLink = $parameters['rel_page_link'];
    }

    if (isset($parameters['bg_class'])) {
        $bgClass = $parameters['bg_class'];
    }

    if (isset($parameters['bg_class_mobile'])) {
        $bgClassMobile = $parameters['bg_class_mobile'];
    }

    $categories = Category::all();
    $relPageCatId = "";

    if (isset($parameters['rel_page_category'])) {
        $relPageCatId = (int)$parameters['rel_page_category'];
    }

@endphp

<h3 class="text-center mt-lg-5">Related pages expanded module:</h3>

<div class="row mt-lg-3">
    <div class="form-group col-12 col-lg-6">
        <label>Relation page title (DISCOVER MORE - by default):</label>
        <input class="form-control" name="parameters[rel_page_title]" placeholder="Relation page title" value="{{ $relPageTitle }}" />
    </div>

    <div class="form-group col-12 col-lg-6">
        <label>Relation page link title (VISIT NEWSROOM - by default):</label>
        <input class="form-control" name="parameters[rel_page_link_title]" placeholder="Relation page link title" value="{{ $relPageLinkTitle }}" />
    </div>

    <div class="form-group col-12 col-lg-6">
        <label>Relation page link (/newsroom - by default):</label>
        <input class="form-control" name="parameters[rel_page_link]" placeholder="Relation page link" value="{{ $relPageLink }}" />
    </div>

    <div class="form-group col-12 col-lg-6">
        <label>Background class:</label>
        <input class="form-control" name="parameters[bg_class]" placeholder="Example - bg-light" value="{{ $bgClass }}" />
    </div>

    <div class="form-group col-12 col-lg-6">
        <label>Background class (mobile):</label>
        <input class="form-control" name="parameters[bg_class_mobile]" placeholder="Example - bg-light" value="{{ $bgClassMobile }}" />
    </div>

    <div class="form-group col-12 col-lg-6">
        <label>Related pages category:</label>
        <select name="parameters[rel_page_category]" class="form-control">
            <option value="">Not selected</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                        @if($relPageCatId === $category->id) selected @endif>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
</div>





