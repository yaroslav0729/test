@php

$bgImage = '';
$ourMissionTitle = '';
$ourValuesDescription = '';
$ourValuesInActionTitle = '';
$ourValuesInActionDescription = '';
$ourValuesVideo = '';
$ourValuesVideoPreview = '';
$mapImage = '';
$mapAlternativeImage = '';
$hdrColorType = '';

$hideMap = '';

if (isset($parameters['hide_map'])) {
    $hideMap = $parameters['hide_map'];
}

$storyActive = $parameters['story_active'] ?? [];

for ($i = 1; $i <= 4; $i++) {
    $actionActive[$i] = '';
    $actionName[$i] = '';
    $actionPhoto[$i] = '';
    $actionSlogan[$i] = '';
    $actionTitle[$i] = '';
    $actionDescription[$i] = '';
    $actionLearnMoreLink[$i] = '';
}

for ($i = 1; $i <= 3; $i++) {
    ${'storyPhoto' . $i} = '';
    ${'storyYear' . $i} = '';
    ${'storyText' . $i} = '';
}

for ($i = 1; $i <= 2; $i++) {
    ${'lifeChangingPhoto' . $i} = '';
    ${'lifeChangingPhrase' . $i} = '';
}

$lifeChangingBlockTitle = '';
$lifeChangingBlockText = '';
$lifeChangingBlockTextMobile = '';

if (isset($parameters['hdr_color_type'])) {
    $hdrColorType = $parameters['hdr_color_type'];
}

if (isset($parameters['background_image'])) {
    $bgImage = $parameters['background_image'];
}

if (isset($parameters['our_mission_title'])) {
    $ourMissionTitle = $parameters['our_mission_title'];
}

if (isset($parameters['our_values_description'])) {
    $ourValuesDescription = $parameters['our_values_description'];
}

if (isset($parameters['our_values_video'])) {
    $ourValuesVideo = $parameters['our_values_video'];
}

if (isset($parameters['our_values_video_preview'])) {
    $ourValuesVideoPreview = $parameters['our_values_video_preview'];
}

if (isset($parameters['map_image'])) {
    $mapImage = $parameters['map_image'];
}

if (isset($parameters['map_alt_image'])) {
    $mapAlternativeImage = $parameters['map_alt_image'];
}

if (isset($parameters['our_values_action_title'])) {
    $ourValuesInActionTitle = $parameters['our_values_action_title'];
}

if (isset($parameters['our_values_action_description'])) {
    $ourValuesInActionDescription = $parameters['our_values_action_description'];
}

for ($i = 1; $i <= 4; $i++) {
    if (isset($parameters['action_active_' . $i])) {
        $actionActive[$i] = $parameters['action_active_' . $i];
    }
    if (isset($parameters['action_name_' . $i])) {
        $actionName[$i] = $parameters['action_name_' . $i];
    }
    if (isset($parameters['action_photo_' . $i])) {
        $actionPhoto[$i] = $parameters['action_photo_' . $i];
    }
    if (isset($parameters['action_slogan_' . $i])) {
        $actionSlogan[$i] = $parameters['action_slogan_' . $i];
    }
    if (isset($parameters['action_title_' . $i])) {
        $actionTitle[$i] = $parameters['action_title_' . $i];
    }
    if (isset($parameters['action_description_' . $i])) {
        $actionDescription[$i] = $parameters['action_description_' . $i];
    }
    if (isset($parameters['action_learn_more_link_' . $i])) {
        $actionLearnMoreLink[$i] = $parameters['action_learn_more_link_' . $i];
    }
}

for ($i = 1; $i <= 3; $i++) {
    if (isset($parameters["story_year_{$i}"])) {
        ${'storyYear' . $i} = $parameters["story_year_{$i}"];
    }
    if (isset($parameters["story_photo_{$i}"])) {
        ${'storyPhoto' . $i} = $parameters["story_photo_{$i}"];
    }
    if (isset($parameters["story_text_{$i}"])) {
        ${'storyText' . $i} = $parameters["story_text_{$i}"];
    }
}

for ($i = 1; $i <= 2; $i++) {
    if (isset($parameters["changing_block_photo_{$i}"])) {
        ${'lifeChangingPhoto' . $i} = $parameters["changing_block_photo_{$i}"];
    }
    if (isset($parameters["changing_block_phrase_{$i}"])) {
        ${'lifeChangingPhrase' . $i} = $parameters["changing_block_phrase_{$i}"];
    }
}

$changingActive = $parameters['changing_active'] ?? [];

if (isset($parameters['changing_block_title'])) {
    $lifeChangingBlockTitle = $parameters['changing_block_title'];
}

if (isset($parameters['changing_block_text'])) {
    $lifeChangingBlockText = $parameters['changing_block_text'];
}

if (isset($parameters['changing_block_text_mobile'])) {
    $lifeChangingBlockTextMobile = $parameters['changing_block_text_mobile'];
}

$donationModuleEnabled = false;
if (isset($parameters['donation_module_enabled'])) {
    $donationModuleEnabled = $parameters['donation_module_enabled'] === '1';
}

$hideOurStory = '';
if (isset($parameters['hide_our_story'])) {
    $hideOurStory = $parameters['hide_our_story'];
}

$showFAQs = '';
if (isset($parameters['show_faq'])) {
    $showFAQs = $parameters['show_faq'];
}

$faqs = [];
for ($i = 0; $i < 7; $i++) {
    $faqs[] = [
        'question' => '',
        'answer' => '',
    ];

    if (isset($parameters['faq_question_' . $i])) {
        $faqs[$i]['question'] = $parameters['faq_question_' . $i];
    }
    if (isset($parameters['faq_answer_' . $i])) {
        $faqs[$i]['answer'] = $parameters['faq_answer_' . $i];
    }
}

$projectImagesCarousel = [];
for($i = 0; $i < 10; $i++) {
    if (isset($parameters['project_images_carousel_' . $i])) {
        $projectImagesCarousel[$i] = $parameters['project_images_carousel_' . $i];
    }
}
@endphp

<div class="row">
    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Background image:</label>
            <input class="form-control" name="parameters[background_image]" placeholder="Insert background image path"
                value="{{ $bgImage }}" />
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Our mission title:</label>
            <input class="form-control" name="parameters[our_mission_title]" placeholder="Our mission title"
                value="{{ $ourMissionTitle }}" />
        </div>
    </div>

    <div class="col-12 mt-5">
        <div class="form-group">
            <label>Our values description:</label>
            <textarea class="form-control" name="parameters[our_values_description]"
                placeholder="Our values description">{{ $ourValuesDescription }}</textarea>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Our values video:</label>
            <input class="form-control" name="parameters[our_values_video]" placeholder="Insert youtube video link"
                value="{{ $ourValuesVideo }}" />
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Our values video preview:</label>
            <input class="form-control" name="parameters[our_values_video_preview]" placeholder="Insert path"
                value="{{ $ourValuesVideoPreview }}">
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Map image path:</label>
            <input class="form-control" name="parameters[map_image]" placeholder="Insert map image path"
                value="{{ $mapImage }}" />
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Map alternative image path:</label>
            <input class="form-control" name="parameters[map_alt_image]" placeholder="Insert map alternative image path"
                value="{{ $mapAlternativeImage }}" />
        </div>
    </div>
</div>

<div class="form-group mt-5">
    <label class="font-weight-bold">Our story:</label>
    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" id="hide-our-story-checkbox" name="parameters[hide_our_story]"
               value="1" @if ($hideOurStory === '1') checked @endif>
        <label class="form-check-label" for="hide-map-checkbox">
            Hide Our story
        </label>
    </div>
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            @for ($i = 1; $i <= 3; $i++)
                <a class="nav-item nav-link @if ($i===1) active @endif"
                    id="nav-action-tab-{{ $i }}" data-toggle="tab" href="#nav-story-{{ $i }}"
                    role="tab" aria-controls="nav-home" aria-selected="true">Slide {{ $i }}</a>
            @endfor
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        @for ($i = 1; $i <= 3; $i++)
            <div class="tab-pane fade show @if ($i===1) active @endif"
                id="nav-story-{{ $i }}" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" name="parameters[story_active][]" type="checkbox"
                                value="{{ $i }}" id="defaultCheck{{ $i }}" @if (in_array($i, $storyActive)) checked @endif>
                            <label class="form-check-label" for="defaultCheck{{ $i }}">
                                Active slide
                            </label>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6 mt-2">
                        <div class="form-group">
                            <label>Year:</label>
                            <input class="form-control" name="parameters[story_year_{{ $i }}]"
                                placeholder="Year" value="{!! ${'storyYear' . $i} !!}" />
                        </div>
                        <div class="form-group">
                            <label>Photo:</label>
                            <input class="form-control" name="parameters[story_photo_{{ $i }}]"
                                placeholder="Insert photo path" value="{!! ${'storyPhoto' . $i} !!}" />
                        </div>
                    </div>

                    <div class="col-12 col-lg-6 mt-2">
                        <div class="form-group">
                            <label>Text:</label>
                            <textarea class="form-control" rows="3" name="parameters[story_text_{{ $i }}]"
                                placeholder="Life changing support text">{!! ${'storyText' . $i} !!}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        @endfor
    </div>
</div>

<div class="row mt-5">
    <div class="col-12 font-weight-bold">FAQs:</div>
    <div class="col-12">
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="show-faq-checkbox" name="parameters[show_faq]"
                   value="1" @if ($showFAQs === '1') checked @endif>
            <label class="form-check-label" for="show-faq">
                Show FAQ block
            </label>
        </div>
    </div>
    @for($item = 0; $item < 7; $item++)
        <div class="col-12 col-lg-6">
            <div class="form-group">
                <label>Question #{{ $item + 1 }}:</label>
                <input class="form-control" name="parameters[faq_question_{{ $item }}]"
                       placeholder="Question #{{ $item + 1 }} text" value="{{ $faqs[$item]['question'] }}" />
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="form-group">
                <label>Answer #{{ $item + 1 }}:</label>
                <input class="form-control" name="parameters[faq_answer_{{ $item }}]"
                       placeholder="Answer #{{ $item + 1 }} text" value="{{ $faqs[$item]['answer'] }}" />
            </div>
        </div>
    @endfor
</div>

<div class="row mt-5">
    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Life changing support title:</label>
            <input class="form-control" name="parameters[changing_block_title]"
                placeholder="Life changing support title" value="{{ $lifeChangingBlockTitle }}" />
        </div>
    </div>

    <div class="form-group col-12 col-lg-6">
        <label>Header color style</label>
        <select name="parameters[hdr_color_type]" class="form-control">
            <option value="blue" @if ($hdrColorType === 'blue') selected @endif>Blue</option>
            <option value="red" @if ($hdrColorType === 'red') selected @endif>Red</option>
        </select>
    </div>

    @for ($i = 1; $i <= 2; $i++)
        <div class="col-12 col-lg-6 mt-2">
            <div class="form-check">
                <input class="form-check-input" name="parameters[changing_active][]" type="checkbox"
                    value="{{ $i }}" id="defaultCheck{{ $i }}" @if (in_array($i, $changingActive)) checked @endif>
                <label class="form-check-label" for="defaultCheck{{ $i }}">
                    Active slide {{ $i }}
                </label>
            </div>
            <div class="form-group mt-2">
                <label>Photo:</label>
                <input class="form-control" name="parameters[changing_block_photo_{{ $i }}]"
                    placeholder="Insert photo path" value="{!! ${'lifeChangingPhoto' . $i} !!}" />
            </div>
            <div class="form-group">
                <label>Phrase:</label>
                <input class="form-control" name="parameters[changing_block_phrase_{{ $i }}]"
                    placeholder="Phrase" value="{!! ${'lifeChangingPhrase' . $i} !!}" />
            </div>
        </div>
    @endfor

    <div class="col-12 mt-3">
        <div class="form-group">
            <label>Life changing support text:</label>
            <textarea wysiwyg-editor id="main_html" class="form-control" name="parameters[changing_block_text]"
                placeholder="Life changing support text">{{ $lifeChangingBlockText }}</textarea>
        </div>

        <div class="form-group">
            <label>Life changing support text (mobile):</label>
            <textarea wysiwyg-editor id="mobile_html" class="form-control" name="parameters[changing_block_text_mobile]"
                placeholder="Life changing support text (mobile)">{{ $lifeChangingBlockTextMobile }}</textarea>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-12">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="donate-module-checkbox" name="parameters[donation_module_enabled]"
                value="1" @if ($donationModuleEnabled) checked @endif>
            <label class="form-check-label" for="donate-module-checkbox">
                Enable donation module
            </label>
        </div>

        <div id="donate-module">
            @include('modules.admin.donate_module', ['priceHandlersOnly' => true])
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-12 font-weight-bold">Together with Gaza carousel:</div>
    <div class="col-12">
        @for($i = 0; $i < 10; $i++)
            <div class="form-group">
                <label>Project image {{ $i + 1 }}:</label>
                <input class="form-control" name="parameters[project_images_carousel_{{ $i }}]"
                       placeholder="Insert image path" value="{{ $projectImagesCarousel[$i] ?? '' }}" />
            </div>
        @endfor
    </div>
</div>

<div class="mt-2">
    <div class="form-group">
        <label>Our values in action description (for mobile):</label>
        <textarea class="form-control" name="parameters[our_values_action_description]"
            placeholder="Our values in action description (for mobile)" required>{{ $ourValuesInActionDescription }}</textarea>
    </div>
</div>

<script>
    $(document).ready(function () {
        const isChecked = $('#donate-module-checkbox').is(':checked');
        if (isChecked) {
            $('#donate-module').show();
        } else {
            $('#donate-module').hide();
        }
        $('#donate-module-checkbox').change(function () {
            if (this.checked) {
                $('#donate-module').show();
            } else {
                $('#donate-module').hide();
            }
        });
    });
</script> 