<?php include "_header.php"; ?>

<div class="pt-5 bp-5"></div>
<section class="head-Volunteer">
    <!--step 1-->
    <h1>Great! You've taken<br>the first step in doing<br>good, let's get<br>cracking then.</h1>
    <button class="btn btn-outline-primary">Start</button>

    <!--step 2-->
    <form action="/">
        <div class="title"><span>1 <i class="moon-icons-arrow-right"></i></span>     Hey there! What's your name?</div>
        <div class="field"><input type="text" placeholder="Get typing here..."></div>
        <div class="field"><textarea placeholder="Get typing here..."">Textarea</textarea></div>
        <button class="btn btn-outline-primary">Next</button>
    </form>

    <!--step 3-->
    <div>
        <div class="row mb-4">
            <div class="col-6"><img src="img/head-Volunteer-element.png" alt="" class="w-100"></div>
        </div>
        <h1 class="pt-0">Yay! All done, we can't wait to get started.</h1>
    </div>

</section>

<section class="how-does-work pt-4">
    <div class="title">
        <p>Why should I volunteer?</p>
        <span>Find the mission you love</span>
    </div>
    <div class="item">
        <div class="num">01</div>
        <div>be part of change</div>
        <p>160 characters und omnis iste natus error sit volupt accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi.</p>
    </div>
    <div class="item">
        <div class="num">02</div>
        <div>use your skills</div>
        <p>160 characters und omnis iste natus error sit volupt accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi.</p>
    </div>
    <div class="item pl-0 pl-md-5">
        <div class="num">03</div>
        <div>make a difference</div>
        <p>160 characters und omnis iste natus error sit volupt accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi.</p>
    </div>
</section>



<div class="pt-4 pb-3"></div>

<section class="discover-more bg-danger-light">
    <div class="wrap">
        <div class="title">
            <b class="font-size-25 text-uppercase">Related topics</b>
        </div>
        <div class="current-projects-list current-projects-swiper">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <a href="#" class="item">
                            <span class="img" style="background-image: url(img/content/discover-more-1.jpg)"></span>
                            <span class="descr">
                            <span class="name font-size-16">EVENT</span>
                            <span class="text font-size-16"><b>Critical campaign title, 60 char lorem sit amet, demis.</b></span></span>
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="#" class="item">
                            <span class="img" style="background-image: url(img/content/discover-more-2.jpg)"></span>
                            <span class="descr">
                                <span class="name font-size-16">PROJECT</span>
                                <span class="text font-size-16"><b>Critical campaign title, 60 char lorem sit amet, demis.</b></span>
                            </span>
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="#" class="item">
                            <span class="img" style="background-image: url(img/content/discover-more-3.jpg)"></span>
                            <span class="descr">
                            <span class="name font-size-16">ARTICLE</span>
                            <span class="text font-size-16"><b>Critical campaign title, 60 char lorem sit amet, demis.</b></span>
                        </span>
                        </a>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>

        <script>
            var swiper = new Swiper('.current-projects-swiper .swiper-container', {
                pagination: {
                    el: '.current-projects-swiper .swiper-pagination'
                }
            });
        </script>
    </div>
</section>




<?php include "_footer.php";?>

</body>
</html>
