@php

    $previewText = "";
    $previewPosition = "";
    $previewImage = "";

    $eventDateText = "";
    $eventTimeText = "";
    $eventLink = "";
    $eventLinkText = "";

    $eventDetailsEntry = "";
    $eventDetailsOrganiser = "";
    $eventDetailsSpeaker = "";
    $eventDetailsContact = "";

    $mainHtml = "";

    $informationTitle ="";
    $informationText ="";

    if (isset($parameters['preview_text'])) {
        $previewText = $parameters['preview_text'];    
    }

    if (isset($parameters['preview_position'])) {
        $previewPosition = $parameters['preview_position'];    
    }

    if (isset($parameters['preview_image'])) {
        $previewImage = $parameters['preview_image'];    
    }

    if (isset($parameters['event_date_text'])) {
        $eventDateText = $parameters['event_date_text'];    
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

    if (isset($parameters['main_html'])) {
        $mainHtml = $parameters['main_html'];    
    }

    if (isset($parameters['information_title'])) {
        $informationTitle = $parameters['information_title'];    
    }

    if (isset($parameters['information_text'])) {
        $informationText = $parameters['information_text'];    
    }

@endphp

<div class="form-group">
    <label>Preview text:</label>
    <textarea class="form-control" name="parameters[preview_text]">{{ $previewText }}</textarea>
</div>

<div class="form-group">
    <label>Preview position:</label>
    <input class="form-control" name="parameters[preview_position]" value="{{ $previewPosition }}" />
</div>

<div class="form-group">
    <label>Preview image:</label>
    <input class="form-control" name="parameters[preview_image]" value="{{ $previewImage }}" />
</div>

<div class="form-group">
    <label>Event date text:</label>
    <input class="form-control" name="parameters[event_date_text]" value="{{ $eventDateText }}" />
</div>

<div class="form-group">
    <label>Event time text:</label>
    <input class="form-control" name="parameters[event_time_text]" value="{{ $eventTimeText }}" />
</div>

<div class="form-group">
    <label>Event link text:</label>
    <input class="form-control" name="parameters[event_link_text]" value="{{ $eventLinkText }}" />
</div>

<div class="form-group">
    <label>Event link:</label>
    <input class="form-control" name="parameters[event_link]" value="{{ $eventLink }}" />
</div>

<div class="form-group">
    <label>Event details entry:</label>
    <input class="form-control" name="parameters[event_details_entry]" value="{{ $eventDetailsEntry }}" />
</div>

<div class="form-group">
    <label>Event details organiser:</label>
    <input class="form-control" name="parameters[event_details_organiser]" value="{{ $eventDetailsOrganiser }}" />
</div>

<div class="form-group">
    <label>Event details speaker:</label>
    <input class="form-control" name="parameters[event_details_speaker]" value="{{ $eventDetailsSpeaker }}" />
</div>

<div class="form-group">
    <label>Event details contact:</label>
    <input class="form-control" name="parameters[event_details_contact]" value="{{ $eventDetailsContact }}" />
</div>

<div class="form-group">
    <label>Main html</label>
    <textarea wysiwyg-editor class="form-control" id="main_html" name="parameters[main_html]">{{ $mainHtml }}</textarea>
</div>

<div class="form-group">
    <label>Information title:</label>
    <input class="form-control" name="parameters[information_title]" value="{{ $informationTitle }}" />
</div>

<div class="form-group">
    <label>Information text:</label>
    <textarea class="form-control" id="information_text" name="parameters[information_text]">{{ $informationText }}</textarea>
</div>
