@php
    $featuredCompaignLink = "";
    $slideTitle = [];
    $slideText = [];
    
    if (isset($parameters['feat_camp_link'])) {
        $featuredCompaignLink = $parameters['feat_camp_link'];    
    }

    for ($i = 0; $i < 4; $i++) {
        if (isset($parameters['slide_title_' . $i])) {
            $slideTitle[$i] = $parameters['slide_title_' . $i];    
        } else {
            $slideTitle[$i] = "";
        }

        if (isset($parameters['slide_text_' . $i])) {
            $slideText[$i] = $parameters['slide_text_' . $i];    
        } else {
            $slideText[$i] = ""; 
        }
    }
    

@endphp

<h3 class="mt-4 mb-4">Current projects module:</h3>

<div class="form-group">
    <label>Featured campaign link:</label>
    <input class="form-control" required name="parameters[feat_camp_link]" placeholder="Featured campaign link" value="{{ $featuredCompaignLink }}" />
</div>

<ul class="nav nav-tabs" id="currentProjects" role="tablist">
    @for ($i = 0; $i < 4; $i++)
        <li class="nav-item">
            <a class="nav-link @if($i===0) active @endif" id="tab-slide-{{ $i }}" data-toggle="tab" href="#slide_{{ $i }}" role="tab" aria-controls="tab-slide-{{ $i }}" aria-selected="@if($i===0) true @else false @endif">Slide {{ $i }}</a>
        </li>
    @endfor
</ul>
<div class="tab-content" id="myTabContent">
    @for ($i = 0; $i < 4; $i++)
        <div class="tab-pane fade @if($i===0) show active @endif" id="slide_{{ $i }}" role="tabpanel" aria-labelledby="tab-slide-{{ $i }}">
            
            <div class="form-group">
                <label>Slide {{ $i }} title:</label>
                <input class="form-control" name="parameters[slide_title_{{ $i }}]" placeholder="Slide {{ $i }} title" value="{{ $slideTitle[$i] }}" />
            </div>

            <div class="form-group">
                <label>Slide {{ $i }} text:</label>
                <textarea class="form-control" name="parameters[slide_text_{{ $i }}]" placeholder="Slide {{ $i }} text">{{ $slideText[$i] }}</textarea>
            </div>

        </div>
    @endfor
</div>