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
    <div class="row align-items-center">
        <div class="col-12 col-md-6 text-right">
            <div class="help-info-grid pr-5">
                <div>
                    <span>8.2k</span>
                    <span>Meals provided</span>
                </div>
                <div>
                    <span>10.1k</span>
                    <span>Children educated</span>
                </div>
                <div>
                    <span>6.6k</span>
                    <span>People empowered</span>
                </div>
                <div>
                    <span>8k</span>
                    <span>Wells built</span>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 pl-5">
            <p class="font-size-40 text-white mb-3"><b>{{ $bePartTitle }}</b></p>
            <p class="font-size-16 text-white mb-5">
                {{ $bePartText }}
            </p>
            <div class="pt-0">
                <a href="{{ $bePartLink }}" class="btn btn-outline-primary border-white">Apply now</a>
            </div>
        </div>
    </div>
</section>