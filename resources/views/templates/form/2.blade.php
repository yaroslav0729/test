@php

    $previewPosition = "";
    $eventTypeParticipate = "";

    $eventStartDate = "";
    $eventEndDate = "";
    $eventStartTime = "";
    $eventEndTime = "";
    $eventEndSaleDate = "";

    $eventLink = "";
    $eventLinkText = "";

    $eventDetailsEntry = "";
    $eventEntryPrice = "";
    $eventDetailsOrganiser = "";
    $eventDetailsSpeaker = "";
    $eventDetailsContact = "";

    $informationTitle = "";
    $informationText = "";

    $importantInformationTitle = "";
    $importantInformationText = "";

    if (isset($parameters['preview_position'])) {
        $previewPosition = $parameters['preview_position'];
    }

    if (isset($parameters['event_type_participate'])) {
        $eventTypeParticipate = $parameters['event_type_participate'];
    }

    if (isset($parameters['event_start_date'])) {
        $eventStartDate = $parameters['event_start_date'];
    }

    if (isset($parameters['event_end_date'])) {
        $eventEndDate = $parameters['event_end_date'];
    }

    if (isset($parameters['event_start_time'])) {
        $eventStartTime = $parameters['event_start_time'];
    }

    if (isset($parameters['event_end_time'])) {
        $eventEndTime = $parameters['event_end_time'];
    }

    if (isset($parameters['event_end_sale_date'])) {
        $eventEndSaleDate = $parameters['event_end_sale_date'];
    }

    if (isset($parameters['event_time_text'])) {
        $eventTimeText = $parameters['event_time_text'];
    }

    if (isset($parameters['event_link'])) {
        $eventLink = $parameters['event_link'];
    }

    if (isset($parameters['event_link_text'])) {
        $eventLinkText = $parameters['event_link_text'];
    }

    if (isset($parameters['event_details_entry'])) {
        $eventDetailsEntry = $parameters['event_details_entry'];
    }

    if (isset($parameters['event_entry_price'])) {
        $eventEntryPrice = $parameters['event_entry_price'];
    }

    if (isset($parameters['event_details_entry'])) {
        $eventDetailsEntry = $parameters['event_details_entry'];
    }

    if (isset($parameters['event_details_organiser'])) {
        $eventDetailsOrganiser = $parameters['event_details_organiser'];
    }

    if (isset($parameters['event_details_speaker'])) {
        $eventDetailsSpeaker = $parameters['event_details_speaker'];
    }

    if (isset($parameters['event_details_contact'])) {
        $eventDetailsContact = $parameters['event_details_contact'];
    }

    if (isset($parameters['information_title'])) {
        $informationTitle = $parameters['information_title'];
    }

    if (isset($parameters['information_text'])) {
        $informationText = $parameters['information_text'];
    }

    if (isset($parameters['important_information_title'])) {
        $importantInformationTitle = $parameters['important_information_title'];
    }

    if (isset($parameters['important_information_text'])) {
        $importantInformationText = $parameters['important_information_text'];
    }

@endphp
<div class="row">
    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Event details entry:</label>
            <select name="parameters[event_type_participate]" class="form-control">
                <option value="">Not selected</option>
                @foreach (\App\Models\Event::ALL_TYPE_EVENT as $typeId => $typeEvent)
                    <option value="{{ $typeId }}"
                            @if((int)$eventTypeParticipate === $typeId) selected @endif >{{ $typeEvent }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Preview position:</label>
            <input class="form-control" required name="parameters[preview_position]"
                   placeholder="Insert preview position name" value="{{ $previewPosition }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Event link text:</label>
            <input class="form-control" required name="parameters[event_link_text]" placeholder="Insert event link text"
                   value="{{ $eventLinkText }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Event link:</label>
            <input class="form-control" required name="parameters[event_link]" placeholder="Insert event link"
                   value="{{ $eventLink }}"/>
        </div>
    </div>

</div>
<div class="row mt-lg-5">
    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Event start date:</label>
            <input type="date" class="form-control" required name="parameters[event_start_date]"
                   placeholder="Choice start event date" value="{{ $eventStartDate }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Event start time (00:00 - 24:00):</label>
            <input type="time" class="form-control" required name="parameters[event_start_time]"
                   placeholder="Insert start event time" value="{{ $eventStartTime }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Event end date:</label>
            <input type="date" class="form-control" name="parameters[event_end_date]"
                   placeholder="Choice start event date" value="{{ $eventEndDate }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Event end time (00:00 - 24:00):</label>
            <input type="time" class="form-control" name="parameters[event_end_time]"
                   placeholder="Insert start event time" value="{{ $eventEndTime }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Event sale and date:</label>
            <input type="date" class="form-control" required name="parameters[event_end_sale_date]"
                   placeholder="Choice start event date" value="{{ $eventEndSaleDate }}"/>
        </div>
    </div>
</div>

<div class="row mt-lg-5">
    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Event details entry:</label>
            <select name="parameters[event_details_entry]" class="form-control">
                <option value="">Not selected</option>
                @foreach (\App\Models\Event::ALL_TYPES_ENTRY as $typeId => $typeLabel)
                    <option value="{{ $typeId }}"
                            @if((int)$eventDetailsEntry === $typeId) selected @endif >{{ $typeLabel }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Event price:</label>
            <input class="form-control" name="parameters[event_entry_price]"
                   placeholder="Insert entry price" value="{{ $eventEntryPrice }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Event details organiser:</label>
            <input class="form-control" required name="parameters[event_details_organiser]"
                   placeholder="Insert event details organiser" value="{{ $eventDetailsOrganiser }}"/>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Event details speaker:</label>
            <input class="form-control" required name="parameters[event_details_speaker]"
                   placeholder="Insert event details speaker" value="{{ $eventDetailsSpeaker }}"/>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Event details contact:</label>
            <input class="form-control" required name="parameters[event_details_contact]"
                   placeholder="Insert event details contact" value="{{ $eventDetailsContact }}"/>
        </div>
    </div>
</div>

<div class="row mt-lg-5">
    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Information title:</label>
            <input class="form-control" required name="parameters[information_title]"
                   placeholder="Insert information title" value="{{ $informationTitle }}"/>
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label>Information text</label>
            <textarea wysiwyg-editor class="form-control" id="main_html"
                      name="parameters[information_text]">{{ $informationText }}</textarea>
        </div>
    </div>
</div>

<div class="row mt-lg-5">
    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Important information title:</label>
            <input class="form-control" required name="parameters[important_information_title]"
                   placeholder="Important information title" value="{{ $importantInformationTitle }}"/>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Important information text:</label>
            <textarea class="form-control" required name="parameters[important_information_text]"
                      placeholder="Important information text">{{ $importantInformationText }}</textarea>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-12">
        @include('modules.admin.related_page_expanded', [
            'parameters' => $parameters
        ])
    </div>
</div>
