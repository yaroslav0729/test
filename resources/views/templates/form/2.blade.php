@php

    $eventTitle = "";
    $eventDescription = "";
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

    $informationTitle ="";
    $informationText ="";
    $informationTextMobile ="";

    $eventbriteCode = "";

    if (isset($parameters['event_title'])) {
        $eventTitle = $parameters['event_title'];
    }

    if (isset($parameters['event_description'])) {
        $eventDescription = $parameters['event_description'];
    }

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

    if (isset($parameters['information_text_mobile'])) {
        $informationTextMobile = $parameters['information_text_mobile'];
    }

    if (isset($parameters['eventbrite_code'])) {
        $eventbriteCode = $parameters['eventbrite_code'];
    }

@endphp
<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label>Event title (max 60 characters):</label>
            <input class="form-control" name="parameters[event_title]"
                   placeholder="Insert Event title" value="{{ $eventTitle }}"/>
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <label>Event description (max 150 characters):</label>
            <textarea class="form-control" name="parameters[event_description]"
                      placeholder="Event description">{{ $eventDescription }}</textarea>
        </div>
    </div>
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
            <input class="form-control" name="parameters[preview_position]"
                   placeholder="Insert preview position name" value="{{ $previewPosition }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Event link text:</label>
            <input class="form-control" name="parameters[event_link_text]" placeholder="Insert event link text"
                   value="{{ $eventLinkText }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Event link:</label>
            <input class="form-control" name="parameters[event_link]" placeholder="Insert event link"
                   value="{{ $eventLink }}"/>
        </div>
    </div>

</div>
<div class="row mt-lg-5">
    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Event start date (GMT):</label>
            <input type="date" class="form-control" name="parameters[event_start_date]"
                   placeholder="Choice start event date" value="{{ $eventStartDate }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Event start time (GMT 00:00 - 24:00):</label>
            <input type="time" class="form-control" name="parameters[event_start_time]"
                   placeholder="Insert start event time" value="{{ $eventStartTime }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Event end date (GMT):</label>
            <input type="date" class="form-control" name="parameters[event_end_date]"
                   placeholder="Choice start event date" value="{{ $eventEndDate }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Event end time (GMT 00:00 - 24:00):</label>
            <input type="time" class="form-control" name="parameters[event_end_time]"
                   placeholder="Insert start event time" value="{{ $eventEndTime }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Event sales end on (GMT):</label>
            <input type="date" class="form-control" name="parameters[event_end_sale_date]"
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
            <input type="number" class="form-control" name="parameters[event_entry_price]"
                   placeholder="Insert entry price" value="{{ $eventEntryPrice }}"/>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Event details organiser:</label>
            <input class="form-control" name="parameters[event_details_organiser]"
                   placeholder="Insert event details organiser" value="{{ $eventDetailsOrganiser }}"/>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Event details speaker:</label>
            <input class="form-control" name="parameters[event_details_speaker]"
                   placeholder="Insert event details speaker" value="{{ $eventDetailsSpeaker }}"/>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Event details contact:</label>
            <input class="form-control" name="parameters[event_details_contact]"
                   placeholder="Insert event details contact" value="{{ $eventDetailsContact }}"/>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Eventbrite iFrame code:</label>
            <input class="form-control" name="parameters[eventbrite_code]"
                   placeholder="Insert eventbrite code" value="{{ $eventbriteCode }}"/>
        </div>
    </div>
</div>

<div class="row mt-lg-5">
    <div class="col-12 col-lg-6">
        <div class="form-group">
            <label>Information title:</label>
            <input class="form-control" name="parameters[information_title]"
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

    <div class="col-12">
        <div class="form-group">
            <label>Information text for mobile (max 460 characters):</label>
            <textarea class="form-control" name="parameters[information_text_mobile]"
                      placeholder="Information text for mobile" rows="3">{{ $informationTextMobile }} </textarea>
        </div>
    </div>
</div>



<div class="row mt-5">
    <div class="col-12">
        @include('modules.admin.important_information', [
            'parameters' => $parameters
        ])
    </div>
</div>

<div class="row mt-5">
    <div class="col-12">
        @include('modules.admin.related_page_expanded', [
            'parameters' => $parameters
        ])
    </div>
</div>
