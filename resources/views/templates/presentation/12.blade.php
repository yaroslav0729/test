@php

    $mainImg = "";

    if (isset($parameters['main_img'])) {
        $mainImg = $parameters['main_img'];
    }
    $deployment_date = "";

    if (isset($parameters['our_latest_text1'])) {
        $deployment_date = $parameters['our_latest_text1'];    
    }
@endphp

<section class="head-mission-impossible bg-light">

    @empty($mainImg)
    <div class="wrap" style="background-image: url(img/content/head-mission-impossible.jpg)">
    @else
    <div class="wrap" style="background-image: url({{ $mainImg }})">
    @endempty
        <div class="text">
            <div>EMPOWERING PEOPLE IN NEED</div>
            <div class="">
                {{ $deployment_date }}
            </div>
        </div>
        <div class="decor-text">
            <span class="text-red">Mission</span>
            <span>Possible</span>
        </div>
    </div>
</section>

@php
    $bePartLink = "";
    if (isset($parameters['be_part_link'])) {
        $bePartLink = $parameters['be_part_link'];    
    }
@endphp

<!-- Large Apply Now Section -->
<section class="apply-now-section text-center py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <a href="{{ $bePartLink }}" class="btn btn-outline-primary btn-xl px-5 py-3" style="font-size: 1.4rem; font-weight: bold; border-width: 2px; min-width: 200px;">
                    APPLY NOW
                </a>
            </div>
        </div>
    </div>
</section>

<div class="additional-content mt-4 text-center d-flex justify-content-center">
    <div class="mb-3">
        <img src="/storage/Screenshot 2025-06-03 at 15.14.36.jpg" 
             alt="Mission Possible Image" 
             class="img-fluid mb-3 zoomable-image" 
             style="max-width: 800px; width: 100%; border-radius: 10px; cursor: pointer; transition: transform 0.3s ease;" 
             id="missionImage"
             onmouseover="this.style.transform='scale(1.05)'" 
             onmouseout="this.style.transform='scale(1)'">
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Mission Possible Image</h5>
                <button type="button" class="btn-close" id="modalCloseBtn" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body text-center">
                <img src="/storage/Screenshot 2025-06-03 at 15.14.36.jpg" 
                    alt="Mission Possible Image" 
                    class="img-fluid" 
                    style=" height: 80vh; border-radius: 10px;">
            </div>
        </div>
    </div>
</div>

<style>
.zoomable-image {
    transition: transform 0.3s ease, box-shadow 0.3s ease !important;
}

.zoomable-image:hover {
    transform: scale(1.05) !important;
    box-shadow: 0 8px 25px rgba(0,0,0,0.2) !important;
}

#imageModal {
    background-color: rgba(0,0,0,0.8);
}

#imageModal .modal-content {
    border: none;
    border-radius: 15px;
}

#imageModal .modal-body {
    padding: 0;
}

#imageModal .modal-body img {
    border-radius: 0 0 15px 15px;
}

#imageModal .modal-header {
    border-bottom: 1px solid #dee2e6;
}

#imageModal .btn-close {
    font-size: 1.5rem;
    font-weight: bold;
    border: none;
    background: none;
    padding: 0.5rem;
}

/* Apply Now Button Hover Effect */
.btn-outline-primary:hover {
    background-color: #007bff !important;
    border-color: #007bff !important;
    color: white !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 8px 20px rgba(0,123,255,0.3) !important;
    transition: all 0.3s ease !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const image = document.getElementById('missionImage');
    const modal = document.getElementById('imageModal');
    const closeBtn = document.getElementById('modalCloseBtn');
    
    // Open modal when image is clicked
    if (image && modal) {
        image.addEventListener('click', function() {
            modal.style.display = 'block';
            modal.classList.add('show');
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        });
    }
    
    // Close modal when close button is clicked
    if (closeBtn && modal) {
        closeBtn.addEventListener('click', function() {
            modal.style.display = 'none';
            modal.classList.remove('show');
            document.body.style.overflow = 'auto'; // Restore scrolling
        });
    }
    
    // Close modal when clicking outside the modal content
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.style.display = 'none';
                modal.classList.remove('show');
                document.body.style.overflow = 'auto'; // Restore scrolling
            }
        });
    }
    
    // Close modal when pressing Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal && modal.style.display === 'block') {
            modal.style.display = 'none';
            modal.classList.remove('show');
            document.body.style.overflow = 'auto'; // Restore scrolling
        }
    });
});
</script>

<section class="swiper-mission-impossible bg-light" swiper-wrapper="mission_possible" space-between="0" centered-slides="true" slides-per-view="auto">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="text text-uppercase"><span><b>1: </b>MISSION POSSIBLE IS THE LIFE-CHANGING HUMANITARIAN EXPERIENCE</span></div>
                <div class="img" style="background-image: url(https://islamichelp.org.uk/storage/slider1%20missionpossible.jpeg)"></div>
            </div>
            <div class="swiper-slide">
                <div class="text text-uppercase"><span><b>2: </b>FROM CAMPAIGNING TO FUNDRAISING TO DEPLOYMENT AND DELIVERY</span></div>
                <div class="img" style="background-image: url(https://islamichelp.org.uk/storage/slider2%20missionpossible.jpeg)"></div>
            </div>
            <div class="swiper-slide">
                <div class="text text-uppercase"><span><b>3: </b>IT GIVES YOU THE FULL SPECTRUM OF THE HUMANITARIAN AID PROCESS</span></div>
                <div class="img" style="background-image: url(https://islamichelp.org.uk/storage/slider3%20mission%20possible.jpeg)"></div>
            </div>
            <div class="swiper-slide">
                <div class="text text-uppercase"><span><b>4: </b>YOU DIRECTLY DELIVER THE AID YOU HAVE RAISED THROUGH YOUR EFFORTS</span></div>
                <div class="img" style="background-image: url(https://islamichelp.org.uk/storage/slider4%20mission%20possible.jpeg)"></div>
            </div>
            <div class="swiper-slide">
                <div class="text text-uppercase"><span><b>5: </b>IT EMPOWERS THE COMMUNITIES YOU HELP, AND IT EMPOWERS YOU</span></div>
                <div class="img" style="background-image: url(https://islamichelp.org.uk/storage/slider%205%20mission%20possible.jpeg)"></div>
            </div>
        </div>
    </div>
</section>

@include('modules.presentation.so_what_this_all')

@include('modules.presentation.how_does_it_work')

@include('modules.presentation.explore_past_missions')

@include('modules.presentation.experience_of_lifetime')

@include('modules.presentation.be_part_of_possible')

@include('modules.presentation.our_latest_mission')

@include('modules.presentation.related_topics_project')

<div class="pt-5 pb-5"></div>
