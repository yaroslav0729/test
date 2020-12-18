<!--<footer class="style-2">-->

<footer class="style-1">
    <div class="wrap">
        <div class="row">
            <div class="col-8">
                <ul class="menu d-flex align-items-start">
                    <li>
                        <a href="#">DONATE</a>
                        <ul class="sub-menu">
                            <li><a href="#">Donate now</a></li>
                            <li><a href="#">Food Packs</a></li>
                            <li><a href="#">Ways to empower</a></li>
                            <li><a href="#">Zakat Calculator</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">make a difference</a>
                        <ul class="sub-menu">
                            <li><a href="#">Events</a></li>
                            <li><a href="#">Volunteer</a></li>
                            <li><a href="#">Vacancies</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">our work</a>
                        <ul class="sub-menu">
                            <li><a href="https://www.islamichelp.org.uk/coronavirus/">Coronavirus Appeal</a></li>
                            <li><a href="https://www.islamichelp.org.uk/ramadan-food-packs/">Ramadan Food Packs</a></li>
                            <li><a href="https://www.islamichelp.org.uk/umrah-for-orphans/">Umrah for Orphans</a></li>
                            <li><a href="https://www.islamichelp.org.uk/what-we-do/development-projects/water-and-sanitation/">Donate a water pump</a></li>
                            <li><a href="https://www.islamichelp.org.uk/sponsor-disabled-children/">Disabled Children sponsorships</a></li>
                            <li><a href="https://www.islamichelp.org.uk/what-we-do/development-projects/orphan-sponsorship/">Sponsor an orphan</a></li>
                            <li><a href="https://www.islamichelp.org.uk/sustainable-livelihoods/">Sustainable livelihoods</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">say hello</a>
                        <ul class="sub-menu">
                            <li>
                                <a href="mailto:info@islamichelp.org.uk">Email us:<br>info@islamichelp.org.uk</a>
                            </li>
                            <li><a href="tel:0121%20446%205682">Call us: 0121 446 5682</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="col-1"></div>
            <div class="col-3">
                <div class="social d-flex justify-content-between">
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
        <div class="copy text-right">
            <b>IslamicHelp&nbsp;&nbsp;</b>   2020 <span>|</span> <a href="#">Terms + Conditions</a> <span>|</span> <a href="#">Privacy Policy</a> <span>|</span> Registered Charity Number:  1160490 <span>|</span> Company Number:  0938212
        </div>
    </div>
</footer>

<script>
    $(function() {
        $('footer .menu > li > a').on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).parent().toggleClass('open');
        })
    } );
</script>

    @include('parts.modal_cart')