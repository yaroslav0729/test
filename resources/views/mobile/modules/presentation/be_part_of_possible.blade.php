@php
    
    $bePartTitle = "";
    $bePartText = "";
    $bePartLink = "";

    if (isset($parameters['be_part_title'])) {
        $bePartTitle = $parameters['be_part_title'];    
    }

    if (isset($parameters['be_part_text'])) {
        $bePartText = $parameters['be_part_text'];    
    }

    if (isset($parameters['be_part_link'])) {
        $bePartLink = $parameters['be_part_link'];    
    }

@endphp

<section class="be-part-possible bg-red">
    <div class="">
        <p class="font-size-30 text-white mb-3"><b>{{ $bePartTitle }}</b></p>
        <p class="font-size-16 text-white mb-5">
            {{ $bePartText }}
        </p>
        <div class="pt-0">
            <a href="{{ $bePartLink }}" class="btn btn-outline-primary border-white">Apply now</a>
        </div>
    </div>
</section>