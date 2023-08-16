@php

    $colTitle1 = "";
    $colText1 = "";
    $colTitle2 = "";
    $colText2 = "";
    $colTitle3 = "";
    $colText3 = "";

    if (isset($parameters['col_title1'])) {
        $colTitle1 = $parameters['col_title1'];    
    }

    if (isset($parameters['col_title2'])) {
        $colTitle2 = $parameters['col_title2'];    
    }

    if (isset($parameters['col_title3'])) {
        $colTitle3 = $parameters['col_title3'];    
    }

    if (isset($parameters['col_text1'])) {
        $colText1 = $parameters['col_text1'];    
    }

    if (isset($parameters['col_text2'])) {
        $colText2 = $parameters['col_text2'];    
    }

    if (isset($parameters['col_text3'])) {
        $colText3 = $parameters['col_text3'];    
    }
    
@endphp

<section class="how-does-work">
    <div class="title">
        <p>How does it<br>work?</p>
        <span>Find the mission you love</span>
    </div>
    <div class="item">
        <div class="num">01</div>
        <div>{{ $colTitle1 }}</div>
        <p>{{ $colText1 }}</p>
    </div>
    <div class="item">
        <div class="num">02</div>
        <div>{{ $colTitle2 }}</div>
        <p>{{ $colText2 }}</p>
    </div>
    <div class="item pl-0 pl-md-5">
        <div class="num">03</div>
        <div>{{ $colTitle3 }}</div>
        <p>{{ $colText3 }}</p>
    </div>
</section>