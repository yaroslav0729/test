@php

    $mainImg = "";
    
    if (isset($parameters['main_img'])) {
        $mainImg = $parameters['main_img'];    
    }
    
@endphp

<div class="form-group">
    <label>Main image:</label>
    <input class="form-control"  name="parameters[main_img]" placeholder="Insert image path" value="{{ $mainImg }}" />
</div>


@include('modules.admin.so_what_this_all')

@include('modules.admin.how_does_it_work')

@include('modules.admin.explore_past_missions')

@include('modules.admin.experience_of_lifetime')

@include('modules.admin.be_part_of_possible')

@include('modules.admin.our_latest_mission')

@include('modules.admin.related_page_expanded')